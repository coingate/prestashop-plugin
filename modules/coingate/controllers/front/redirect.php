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

class CoingateRedirectModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    public function initContent()
    {
        parent::initContent();

        $cart = $this->context->cart;

        if (!$this->module->checkCurrency($cart)) {
            Tools::redirect('index.php?controller=order');
        }

        $total = (float)number_format($cart->getOrderTotal(true, 3), 2, '.', '');
        $currency = Context::getContext()->currency;

        $token = $this->generateToken($cart->id);

        $description = array();
        foreach ($cart->getProducts() as $product) {
            $description[] = $product['cart_quantity'] . ' × ' . $product['name'];
        }

        $customer = new Customer($cart->id_customer);
        $success_url = (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://')
        . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8')
        . __PS_BASE_URI__ . 'index.php?controller=order-confirmation&id_cart='
        . $cart->id . '&id_module=' . $this->id . '&id_order='
        . $this->currentOrder . '&key=' . $customer->secure_key;


        $cgConfig = array(
          'app_id' => Configuration::get('COINGATE_APP_ID'),
          'api_key' => Configuration::get('COINGATE_API_KEY'),
          'api_secret' => Configuration::get('COINGATE_API_SECRET'),
          'environment' => intval(Configuration::getValue('COINGATE_TEST')) == 1 ? 'sandbox' : 'live',
          'user_agent' => 'CoinGate - Prestashop v'._PS_VERSION_.' Extension v'.COINGATE_PRESTASHOP_EXTENSION_VERSION
        );

        \CoinGate\CoinGate::config($cgConfig);

        $order = \CoinGate\Merchant\Order::create(array(
            'order_id'         => $cart->id,
            'price'            => $total,
            'currency'         => $currency->iso_code,
            'receive_currency' => $this->module->receive_currency,
            'cancel_url'       => $this->context->link->getModuleLink('coingate', 'cancel'),
            'callback_url'     => $this->context->link->getModuleLink(
                'coingate',
                'callback',
                array('cg_token' => $token)
            ),
            'success_url'      => $success_url,
            'title'            => Configuration::get('PS_SHOP_NAME') . ' Order #' . $cart->id,
            'description'      => join($description, ', ')
        ));

        if ($order) {
            if (!$order->payment_url) {
                Tools::redirect('index.php?controller=order&step=3');
            }

            $customer = new Customer($cart->id_customer);
            $this->module->validateOrder(
                $cart->id,
                Configuration::get('COINGATE_PENDING'),
                $total,
                $this->module->displayName,
                null,
                null,
                (int)$currency->id,
                false,
                $customer->secure_key
            );

            Tools::redirect($order->payment_url);
        } else {
            coingate_log('[Request]', $cgConfig, $order);
            Tools::redirect('index.php?controller=order&step=3');
        }
    }

    private function generateToken($order_id)
    {
        return hash('sha256', $order_id + $this->module->api_secret);
    }
}
