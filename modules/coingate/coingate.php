<?php
/**
 * NOTICE OF LICENSE
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2015-2016 CoinGate
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished to do so, subject
 * to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
 * IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author    CoinGate <info@coingate.com>
 * @copyright 2015-2016 CoinGate
 * @license   https://github.com/coingate/prestashop-plugin/blob/master/LICENSE  The MIT License (MIT)
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

require_once _PS_MODULE_DIR_ . '/coingate/vendor/coingate-php/init.php';

class Coingate extends PaymentModule
{
    private $html = '';
    private $postErrors = [];

    public $api_auth_token;
    public $test;

    public function __construct()
    {
        $this->name = 'coingate';
        $this->tab = 'payments_gateways';
        $this->version = '2.1.0';
        $this->author = 'CoinGate.com';
        $this->is_eu_compatible = 1;
        $this->controllers = ['payment', 'redirect', 'callback', 'cancel'];
        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];
        $this->module_key = 'bbccfdc38891a5f0428161d79b55ce55';

        $this->currencies = true;
        $this->currencies_mode = 'checkbox';

        $this->bootstrap = true;

        $config = Configuration::getMultiple(
            [
                'COINGATE_API_AUTH_TOKEN',
                'COINGATE_TEST',
            ]
        );

        if (!empty($config['COINGATE_API_AUTH_TOKEN'])) {
            $this->api_auth_token = $config['COINGATE_API_AUTH_TOKEN'];
        } elseif (!empty($config['COINGATE_API_SECRET'])) {
            $this->api_auth_token = $config['COINGATE_API_SECRET'];
        }


        if (!empty($config['COINGATE_TEST'])) {
            $this->test = $config['COINGATE_TEST'];
        }

        parent::__construct();

        $this->displayName = $this->trans('Accept Cryptocurrencies with CoinGate', [], 'Modules.Coingate.Admin');
        $this->description = $this->trans('Accept Bitcoin and other cryptocurrencies as a payment method with CoinGate', [], 'Modules.Coingate.Admin');
        $this->confirmUninstall = $this->trans('Are you sure you want to delete your details?', [], 'Modules.Coingate.Admin');

        if (!isset($this->api_auth_token)) {
            $this->warning = $this->trans('API Access details must be configured in order to use this module correctly.', [], 'Modules.Coingate.Admin');
        }
    }

    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    public function install()
    {
        if (!function_exists('curl_version')) {
            $this->_errors[] = $this->trans('This module requires cURL PHP extension in order to function normally.', [], 'Modules.Coingate.Admin');

            return false;
        }

        $order_pending = new OrderState();
        $order_pending->name = array_fill(0, 10, 'Awaiting CoinGate payment');
        $order_pending->send_email = 0;
        $order_pending->invoice = 0;
        $order_pending->color = 'RoyalBlue';
        $order_pending->unremovable = false;
        $order_pending->logable = 0;

        $order_expired = new OrderState();
        $order_expired->name = array_fill(0, 10, 'CoinGate payment expired');
        $order_expired->send_email = 0;
        $order_expired->invoice = 0;
        $order_expired->color = '#DC143C';
        $order_expired->unremovable = false;
        $order_expired->logable = 0;

        $order_confirming = new OrderState();
        $order_confirming->name = array_fill(0, 10, 'Awaiting CoinGate payment confirmations');
        $order_confirming->send_email = 0;
        $order_confirming->invoice = 0;
        $order_confirming->color = '#d9ff94';
        $order_confirming->unremovable = false;
        $order_confirming->logable = 0;

        $order_invalid = new OrderState();
        $order_invalid->name = array_fill(0, 10, 'CoinGate invoice is invalid');
        $order_invalid->send_email = 0;
        $order_invalid->invoice = 0;
        $order_invalid->color = '#8f0621';
        $order_invalid->unremovable = false;
        $order_invalid->logable = 0;

        if ($order_pending->add()) {
            copy(_PS_ROOT_DIR_ . '/modules/coingate/logo.png', _PS_ROOT_DIR_ . '/img/os/' . (int) $order_pending->id . '.gif');
        }

        if ($order_expired->add()) {
            copy(_PS_ROOT_DIR_ . '/modules/coingate/logo.png', _PS_ROOT_DIR_ . '/img/os/' . (int) $order_expired->id . '.gif');
        }

        if ($order_confirming->add()) {
            copy(_PS_ROOT_DIR_ . '/modules/coingate/logo.png', _PS_ROOT_DIR_ . '/img/os/' . (int) $order_confirming->id . '.gif');
        }

        if ($order_invalid->add()) {
            copy(_PS_ROOT_DIR_ . '/modules/coingate/logo.png', _PS_ROOT_DIR_ . '/img/os/' . (int) $order_invalid->id . '.gif');
        }

        Configuration::updateValue('COINGATE_PENDING', $order_pending->id);
        Configuration::updateValue('COINGATE_EXPIRED', $order_expired->id);
        Configuration::updateValue('COINGATE_CONFIRMING', $order_confirming->id);
        Configuration::updateValue('COINGATE_INVALID', $order_invalid->id);

        if (!parent::install()
            || !$this->registerHook('paymentReturn')
            || !$this->registerHook('paymentOptions')) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        $order_state_pending = new OrderState(Configuration::get('COINGATE_PENDING'));
        $order_state_expired = new OrderState(Configuration::get('COINGATE_EXPIRED'));
        $order_state_confirming = new OrderState(Configuration::get('COINGATE_CONFIRMING'));
        $order_state_invalid = new OrderState(Configuration::get('COINGATE_INVALID'));

        return
            Configuration::deleteByName('COINGATE_APP_ID')
            && Configuration::deleteByName('COINGATE_API_KEY')
            && Configuration::deleteByName('COINGATE_API_SECRET')
            && Configuration::deleteByName('COINGATE_API_AUTH_TOKEN')
            && Configuration::deleteByName('COINGATE_RECEIVE_CURRENCY')
            && Configuration::deleteByName('COINGATE_TEST')
            && Configuration::deleteByName('COINGATE_CLIENT_EMAIL_DATA')
            && Configuration::deleteByName('COINGATE_TRANSFER_SHOPPER_DETAILS')
            && $order_state_pending->delete()
            && $order_state_expired->delete()
            && $order_state_confirming->delete()
            && $order_state_invalid->delete()
            && parent::uninstall();
    }

    private function postValidation()
    {
        if (Tools::isSubmit('btnSubmit')) {
            if (!Tools::getValue('COINGATE_API_AUTH_TOKEN')) {
                $this->postErrors[] = $this->trans('API Auth Token is required.', [], 'Modules.Coingate.Admin');
            }

            if (empty($this->postErrors)) {
                $auth_token = $this->stripString(Tools::getValue('COINGATE_API_AUTH_TOKEN'));
                $environment = Tools::getValue('COINGATE_TEST') == 1 ? true : false;
                \CoinGate\Client::setAppInfo('PrestaShop v' . _PS_VERSION_, $this->version);
                $test = \CoinGate\Client::testConnection($auth_token, $environment);

                if ($test !== true) {
                    $this->postErrors[] = $this->trans('Invalid API token.', [], 'Modules.Coingate.Admin');
                }
            }
        }
    }

    private function postProcess()
    {
        if (Tools::isSubmit('btnSubmit')) {
            Configuration::updateValue(
                'COINGATE_API_AUTH_TOKEN',
                $this->stripString(Tools::getValue('COINGATE_API_AUTH_TOKEN'))
            );
            Configuration::updateValue('COINGATE_TEST', Tools::getValue('COINGATE_TEST'));
            Configuration::updateValue('COINGATE_TRANSFER_SHOPPER_DETAILS', Tools::getValue('COINGATE_TRANSFER_SHOPPER_DETAILS'));
        }

        $this->html .= $this->displayConfirmation($this->trans('Settings updated', [], 'Modules.Coingate.Admin'));
    }

    private function displayCoingate()
    {
        return $this->display(__FILE__, 'infos.tpl');
    }

    private function displayCoingateInformation($renderForm)
    {
        $this->html .= $this->displayCoingate();
        $this->context->controller->addCSS($this->_path . '/views/css/tabs.css', 'all');
        $this->context->controller->addJS($this->_path . '/views/js/javascript.js', 'all');
        $this->context->smarty->assign('form', $renderForm);
        return $this->display(__FILE__, 'information.tpl');
    }

    public function getContent()
    {
        if (Tools::isSubmit('btnSubmit')) {
            $this->postValidation();
            if (!count($this->postErrors)) {
                $this->postProcess();
            } else {
                foreach ($this->postErrors as $err) {
                    $this->html .= $this->displayError($err);
                }
            }
        } else {
            $this->html .= '<br />';
        }

        $renderForm = $this->renderForm();
        $this->html .= $this->displayCoingateInformation($renderForm);

        return $this->html;
    }

    public function hookDisplayOrderConfirmation($params)
    {
        if (!$this->active) {
            return;
        }

        if (!$this->checkCurrency($params['cart'])) {
            return;
        }

        $this->smarty->assign([
            'this_path' => $this->_path,
            'this_path_bw' => $this->_path,
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/',
        ]);

        return $this->context->smarty->fetch(__FILE__, 'payment.tpl');
    }

    public function hookPaymentReturn($params)
    {
        if (!$this->active) {
            return;
        }

        $state = $params['order']->getCurrentState();

        $this->smarty->assign([
            'state' => $state,
            'shop_name' => $this->context->shop->name,
            'paid_state' => (int) Configuration::get('PS_OS_PAYMENT'),
            'this_path' => $this->_path,
            'this_path_bw' => $this->_path,
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/',
        ]);
        return $this->display(__FILE__, 'payment_return.tpl');
    }

    public function hookPaymentOptions($params)
    {
        if (!$this->active) {
            return;
        }

        if (!$this->checkCurrency($params['cart'])) {
            return;
        }

        $newOption = new PrestaShop\PrestaShop\Core\Payment\PaymentOption();
        $newOption->setModuleName($this->name);
        $newOption->setCallToActionText($this->trans('Pay with Bitcoin, stablecoins and other cryptocurrencies', [], 'Modules.Coingate.Shop'));
        $newOption->setAction($this->context->link->getModuleLink($this->name, 'redirect', [], true));
        $newOption->setAdditionalInformation($this->fetch('module:coingate/views/templates/hook/coingate_intro.tpl'));

        return [$newOption];
    }

    public function checkCurrency($cart)
    {
        $currency_order = new Currency($cart->id_currency);
        $currencies_module = $this->getCurrency($cart->id_currency);

        if (is_array($currencies_module)) {
            foreach ($currencies_module as $currency_module) {
                if ($currency_order->id == $currency_module['id_currency']) {
                    return true;
                }
            }
        }

        return false;
    }

    public function renderForm()
    {
        $fields_form = [
            'form' => [
                'legend' => [
                    'title' => $this->trans('Accept Cryptocurrencies with CoinGate', [], 'Modules.Coingate.Admin'),
                    'icon' => 'icon-bitcoin',
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->trans('API Auth Token', [], 'Modules.Coingate.Admin'),
                        'name' => 'COINGATE_API_AUTH_TOKEN',
                        'desc' =>  $this->trans('Your Auth Token (created on CoinGate)', [], 'Modules.Coingate.Admin'),
                        'required' => true,
                    ],
                    [
                        'type' => 'select',
                        'label' =>  $this->trans('Test Mode', [], 'Modules.Coingate.Admin'),
                        'name' => 'COINGATE_TEST',
                        'desc' =>  $this->trans(
                            '
                                                To test on sandbox.coingate.com, turn Test Mode "On".
                                                Please note, for Test Mode you must create a separate account
                                                on sandbox.coingate.com and generate API credentials there.', [], 'Modules.Coingate.Admin'
                        ),
                        'required' => true,
                        'options' => [
                            'query' => [
                                [
                                    'id_option' => 0,
                                    'name' => 'Off',
                                ],
                                [
                                    'id_option' => 1,
                                    'name' => 'On',
                                ],
                            ],
                            'id' => 'id_option',
                            'name' => 'name',
                        ],
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->trans('Transfer Shopper Billing Details', [], 'Modules.Coingate.Admin'),
                        'name' => 'COINGATE_TRANSFER_SHOPPER_DETAILS',
                        'desc' => $this->trans(
                            "When enabled, this plugin will collect and securely transfer shopper billing information (e.g. name, address, email) to the configured payment processor during checkout for the purposes of payment processing, fraud prevention, and compliance. Enabling this option also helps enhance the shopper's experience by pre-filling required fields during checkout, making the process faster and smoother.",
                            [],
                            'Modules.Coingate.Admin'
                        ),
                        'required' => true,
                        'options' => [
                            'query' => [
                                [
                                    'id_option' => 0,
                                    'name' => 'Off',
                                ],
                                [
                                    'id_option' => 1,
                                    'name' => 'On',
                                ],
                            ],
                            'id' => 'id_option',
                            'name' => 'name',
                        ],
                    ],
                ],
                'submit' => [
                    'title' => $this->trans('Save', [], 'Admin.Actions'),
                ],
            ],
        ];

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int) Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = (Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG')
            ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0);
        $this->fields_form = [];
        $helper->id = (int) Tools::getValue('id_carrier');
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'btnSubmit';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            . '&configure=' . $this->name . '&tab_module='
            . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = [
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        ];

        return $helper->generateForm([$fields_form]);
    }

    public function getConfigFieldsValues()
    {
        return [
            'COINGATE_API_AUTH_TOKEN' => $this->stripString(Tools::getValue(
                'COINGATE_API_AUTH_TOKEN',
                empty(Configuration::get('COINGATE_API_AUTH_TOKEN')) ?
                    Configuration::get('COINGATE_API_SECRET') :
                    Configuration::get('COINGATE_API_AUTH_TOKEN')
            )),
            'COINGATE_TEST' => Tools::getValue(
                'COINGATE_TEST',
                Configuration::get('COINGATE_TEST')
            ),
            'COINGATE_TRANSFER_SHOPPER_DETAILS' => Tools::getValue(
                'COINGATE_TRANSFER_SHOPPER_DETAILS',
                Configuration::get('COINGATE_TRANSFER_SHOPPER_DETAILS')
            ),
        ];
    }

    private function stripString($item)
    {
        return preg_replace('/\s+/', '', $item);
    }
}
