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

require_once _PS_MODULE_DIR_ . '/coingate/vendor/coingate/init.php';
require_once _PS_MODULE_DIR_ . '/coingate/vendor/version.php';

class Coingate extends PaymentModule
{
    private $html = '';
    private $postErrors = array();

    public $api_auth_token;
    public $receive_currency;
    public $test;

    public function __construct()
    {
        $this->name = 'coingate';
        $this->tab = 'payments_gateways';
        $this->version = '1.4.1';
        $this->author = 'CoinGate.com';
        $this->is_eu_compatible = 1;
        $this->controllers = array('payment', 'redirect', 'callback', 'cancel');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->module_key = 'bbccfdc38891a5f0428161d79b55ce55';

        $this->currencies = true;
        $this->currencies_mode = 'checkbox';

        $this->bootstrap = true;

        $config = Configuration::getMultiple(
            array(
                'COINGATE_API_AUTH_TOKEN',
                'COINGATE_RECEIVE_CURRENCY',
                'COINGATE_TEST',
            )
        );

        if (!empty($config['COINGATE_API_AUTH_TOKEN'])) {
            $this->api_auth_token = $config['COINGATE_API_AUTH_TOKEN'];
        } elseif (!empty($config['COINGATE_API_SECRET'])) {
            $this->api_auth_token = $config['COINGATE_API_SECRET'];
        }

        if (!empty($config['COINGATE_RECEIVE_CURRENCY'])) {
            $this->receive_currency = $config['COINGATE_RECEIVE_CURRENCY'];
        }

        if (!empty($config['COINGATE_TEST'])) {
            $this->test = $config['COINGATE_TEST'];
        }

        parent::__construct();

        $this->displayName = $this->l('Accept Cryptocurrencies with CoinGate');
        $this->description = $this->l('Accept Bitcoin and other cryptocurrencies as a payment method with CoinGate');
        $this->confirmUninstall = $this->l('Are you sure you want to delete your details?');

        if (!isset($this->api_auth_token)
            || !isset($this->receive_currency)) {
            $this->warning = $this->l('API Access details must be configured in order to use this module correctly.');
        }
    }

    public function install()
    {
        if (!function_exists('curl_version')) {
            $this->_errors[] = $this->l('This module requires cURL PHP extension in order to function normally.');

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
            copy(
                _PS_ROOT_DIR_ . '/modules/coingate/logo.png',
                _PS_ROOT_DIR_ . '/img/os/' . (int)$order_pending->id . '.gif'
            );
        }

        if ($order_expired->add()) {
            copy(
                _PS_ROOT_DIR_ . '/modules/coingate/logo.png',
                _PS_ROOT_DIR_ . '/img/os/' . (int)$order_expired->id . '.gif'
            );
        }

        if ($order_confirming->add()) {
            copy(
                _PS_ROOT_DIR_ . '/modules/coingate/logo.png',
                _PS_ROOT_DIR_ . '/img/os/' . (int)$order_confirming->id . '.gif'
            );
        }

        if ($order_invalid->add()) {
            copy(
                _PS_ROOT_DIR_ . '/modules/coingate/logo.png',
                _PS_ROOT_DIR_ . '/img/os/' . (int)$order_invalid->id . '.gif'
            );
        }

        Configuration::updateValue('COINGATE_PENDING', $order_pending->id);
        Configuration::updateValue('COINGATE_EXPIRED', $order_expired->id);
        Configuration::updateValue('COINGATE_CONFIRMING', $order_confirming->id);
        Configuration::updateValue('COINGATE_INVALID', $order_invalid->id);

        if (!parent::install()
            || !$this->registerHook('payment')
            || !$this->registerHook('displayPaymentEU')
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

        return (
            Configuration::deleteByName('COINGATE_APP_ID') &&
            Configuration::deleteByName('COINGATE_API_KEY') &&
            Configuration::deleteByName('COINGATE_API_SECRET') &&
            Configuration::deleteByName('COINGATE_API_AUTH_TOKEN') &&
            Configuration::deleteByName('COINGATE_RECEIVE_CURRENCY') &&
            Configuration::deleteByName('COINGATE_TEST') &&
            $order_state_pending->delete() &&
            $order_state_expired->delete() &&
            $order_state_confirming->delete() &&
            parent::uninstall()
        );
    }

    private function postValidation()
    {
        if (Tools::isSubmit('btnSubmit')) {
            if (!Tools::getValue('COINGATE_API_AUTH_TOKEN')) {
                $this->postErrors[] = $this->l('API Auth Token is required.');
            }

            if (!Tools::getValue('COINGATE_RECEIVE_CURRENCY')) {
                $this->postErrors[] = $this->l('Receive Currency is required.');
            }

            if (empty($this->postErrors)) {
                $cgConfig = array(
                    'auth_token' => $this->stripString(Tools::getValue('COINGATE_API_AUTH_TOKEN')),
                    'environment' => (int)(Tools::getValue('COINGATE_TEST')) == 1 ? 'sandbox' : 'live',
                    'user_agent' => 'CoinGate - Prestashop v' . _PS_VERSION_
                        . ' Extension v' . COINGATE_PRESTASHOP_EXTENSION_VERSION,
                );

                \CoinGate\CoinGate::config($cgConfig);

                $test = \CoinGate\CoinGate::testConnection();

                if ($test !== true) {
                    $this->postErrors[] = $this->l($test);
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
            Configuration::updateValue('COINGATE_RECEIVE_CURRENCY', Tools::getValue('COINGATE_RECEIVE_CURRENCY'));
            Configuration::updateValue('COINGATE_TEST', Tools::getValue('COINGATE_TEST'));
        }

        $this->html .= $this->displayConfirmation($this->l('Settings updated'));
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
        if (_PS_VERSION_ <= 1.7) {
            return;
        }

        if (!$this->active) {
            return;
        }

        if (!$this->checkCurrency($params['cart'])) {
            return;
        }

        $this->smarty->assign(array(
            'this_path' => $this->_path,
            'this_path_bw' => $this->_path,
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/',
        ));

        return $this->context->smarty->fetch(__FILE__, 'payment.tpl');
    }


    public function hookPaymentReturn($params)
    {
        if (!$this->active) {
            return;
        }
        if (_PS_VERSION_ < 1.7) {
            $order = $params['objOrder'];
            $state = $order->current_state;
        } else {
            $state = $params['order']->getCurrentState();
        }
        $this->smarty->assign(array(
            'state' => $state,
            'paid_state' => (int)Configuration::get('PS_OS_PAYMENT'),
            'this_path' => $this->_path,
            'this_path_bw' => $this->_path,
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/',
        ));
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
        $newOption->setCallToActionText('Bitcoin, Ethereum, Litecoin or other')
            ->setAction($this->context->link->getModuleLink($this->name, 'redirect', array(), true))
            ->setAdditionalInformation(
                $this->context->smarty->fetch('module:coingate/views/templates/hook/coingate_intro.tpl')
            );

        $payment_options = array($newOption);

        return $payment_options;
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
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Accept Cryptocurrencies with CoinGate'),
                    'icon' => 'icon-bitcoin',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('API Auth Token'),
                        'name' => 'COINGATE_API_AUTH_TOKEN',
                        'desc' => $this->l('Your Auth Token (created on CoinGate)'),
                        'required' => true,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Payout Currency'),
                        'name' => 'COINGATE_RECEIVE_CURRENCY',
                        'desc' => $this->l(
                            '
                                                Choose the currency in which you would like to receive payouts.
                                                For real-time EUR or USD settlements,
                                                you must verify as a merchant on CoinGate.'
                        ),
                        'required' => true,
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'btc',
                                    'name'      => 'Bitcoin (฿)',
                                ),
                                array(
                                    'id_option' => 'usdt',
                                    'name'      => 'USDT',
                                ),
                                array(
                                    'id_option' => 'eur',
                                    'name'      => 'Euros (€)',
                                ),
                                array(
                                    'id_option' => 'usd',
                                    'name'      => 'US Dollars ($)',
                                ),
                                array(
                                    'id_option' => 'DO_NOT_CONVERT',
                                    'name'      => 'Do not convert',
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Test Mode'),
                        'name' => 'COINGATE_TEST',
                        'desc' => $this->l(
                            '
                                                To test on sandbox.coingate.com, turn Test Mode “On”.
                                                Please note, for Test Mode you must create a separate account
                                                on sandbox.coingate.com and generate API credentials there.'
                        ),
                        'required' => true,
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => 'Off',
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => 'On',
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = (Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG')
            ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0);
        $this->fields_form = array();
        $helper->id = (int)Tools::getValue('id_carrier');
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'btnSubmit';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            . '&configure=' . $this->name . '&tab_module='
            . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        return array(
            'COINGATE_API_AUTH_TOKEN' => $this->stripString(Tools::getValue(
                'COINGATE_API_AUTH_TOKEN',
                empty(Configuration::get('COINGATE_API_AUTH_TOKEN')) ?
                    Configuration::get('COINGATE_API_SECRET') :
                    Configuration::get('COINGATE_API_AUTH_TOKEN')
            )),
            'COINGATE_RECEIVE_CURRENCY' => Tools::getValue(
                'COINGATE_RECEIVE_CURRENCY',
                Configuration::get('COINGATE_RECEIVE_CURRENCY')
            ),
            'COINGATE_TEST' => Tools::getValue(
                'COINGATE_TEST',
                Configuration::get('COINGATE_TEST')
            ),
        );
    }

    private function stripString($item)
    {
        return preg_replace('/\s+/', '', $item);
    }
}
