<?php
/**
* 2016 CoinGate
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    CoinGate <support@coingate.com>
*  @copyright 2016 CoinGate
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

require_once(_PS_MODULE_DIR_ . '/coingate/vendor/coingate/init.php');
require_once(_PS_MODULE_DIR_ . '/coingate/vendor/version.php');
require_once(_PS_MODULE_DIR_ . '/coingate/vendor/logger.php');

class CoingateCallbackModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    public function postProcess()
    {
        $order_id = Order::getOrderByCartId(Tools::getValue('order_id'));
        $order = new Order($order_id);

        try {
            if (!$order) {
                throw new Exception('Order #' . Tools::getValue('order_id') . ' does not exists');
            }

            $token = $this->generateToken(Tools::getValue('order_id'));

            if ($token == '' || Tools::getValue('cg_token') != $token) {
                throw new Exception('Token: ' . Tools::getValue('cg_token') . ' do not match');
            }

            $cgConfig = array(
              'app_id' => Configuration::get('COINGATE_APP_ID'),
              'api_key' => Configuration::get('COINGATE_API_KEY'),
              'api_secret' => Configuration::get('COINGATE_API_SECRET'),
              'environment' => (int)(Configuration::get('COINGATE_TEST')) == 1 ? 'sandbox' : 'live',
              'user_agent' => 'CoinGate - Prestashop v'._PS_VERSION_
                .' Extension v'.COINGATE_PRESTASHOP_EXTENSION_VERSION
            );

            \CoinGate\CoinGate::config($cgConfig);
            $cgOrder = \CoinGate\Merchant\Order::find(Tools::getValue('id'));

            if (!$cgOrder) {
                coingate_log('[Callback]', $cgConfig, $cgOrder);

                throw new Exception('CoinGate Order #' . Tools::getValue('id') . ' does not exists');
            }

            switch ($cgOrder->status) {
                case 'paid':
                    $order_status = 'PS_OS_PAYMENT';
                    break;
                case 'confirming':
                    $order_status = 'COINGATE_CONFIRMING';
                    break;
                case 'expired':
                    $order_status = 'COINGATE_EXPIRED';
                    break;
                case 'invalid':
                    $order_status = 'COINGATE_INVALID';
                    break;
                case 'canceled':
                    $order_status = 'PS_OS_CANCELED';
                    break;
                case 'refunded':
                    $order_status = 'PS_OS_REFUND';
                    break;
                default:
                    $order_status = false;
                    break;
            }

            if ($order_status !== false) {
                $history = new OrderHistory();
                $history->id_order = $order->id;
                $history->changeIdOrderState((int)Configuration::get($order_status), $order->id);
                $history->addWithemail(true, array(
                    'order_name' => Tools::getValue('order_id'),
                ));

                die('OK');
            } else {
                die('Status'.$cgOrder->status.' not implemented');
            }
        } catch (Exception $e) {
            echo get_class($e) . ': ' . $e->getMessage();
        }
    }

    private function generateToken($order_id)
    {
        return hash('sha256', $order_id + $this->module->api_secret);
    }
}
