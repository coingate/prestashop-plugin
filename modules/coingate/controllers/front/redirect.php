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

class CoingateRedirectModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $version = '2.1.0';

    public function initContent()
    {
        parent::initContent();

        $cart = $this->context->cart;

        if (!$this->module->checkCurrency($cart)) {
            Tools::redirect('index.php?controller=order');
        }

        $total = (float) number_format($cart->getOrderTotal(true, 3), 2, '.', '');
        $currency = Context::getContext()->currency;

        $token = $this->generateToken($cart->id);

        $description = [];
        foreach ($cart->getProducts() as $product) {
            $description[] = $product['cart_quantity'] . ' × ' . $product['name'];
        }

        $customer = new Customer($cart->id_customer);

        $link = new Link();
        $success_url = $link->getPageLink('order-confirmation', null, null, [
            'id_cart' => $cart->id,
            'id_module' => $this->module->id,
            'key' => $customer->secure_key,
        ]);

        $auth_token = Configuration::get('COINGATE_API_AUTH_TOKEN');
        $auth_token = empty($auth_token) ? Configuration::get('COINGATE_API_SECRET') : $auth_token;
        $environment = Configuration::get('COINGATE_TEST') == 1 ? true : false;

        $client = new \CoinGate\Client($auth_token, $environment);
        \CoinGate\Client::setAppInfo('PrestaShop v' . _PS_VERSION_, $this->version);
        $params = [
            'order_id' => $cart->id,
            'price_amount' => $total,
            'price_currency' => $currency->iso_code,
            'callback_url' => $this->context->link->getModuleLink('coingate', 'callback'),
            'cancel_url' => $this->context->link->getModuleLink('coingate', 'cancel'),
            'success_url' => $success_url,
            'title' => Configuration::get('PS_SHOP_NAME') . ' Order #' . $cart->id,
            'description' => join(', ', $description),
            'token' => $this->generateToken($cart->id),
        ];

        $transfer_shopper_details = Configuration::get('COINGATE_TRANSFER_SHOPPER_DETAILS') == 1 ? true : false;
        if ($transfer_shopper_details) {
            $shopper_info = $this->getShopperInfo($customer, $cart);
            if (!empty($shopper_info)) {
                $params['shopper'] = $shopper_info;
            }
        }

        try {
            $order = $client->order->create($params);
        } catch (\CoinGate\Exception\ApiErrorException $e) {
        }

        if ($order) {
            if (!$order->payment_url) {
                Tools::redirect('index.php?controller=order&step=3');
            }
            $customer = new Customer($cart->id_customer);
            $this->module->validateOrder(
                $cart->id,
                Configuration::get('COINGATE_PENDING'),
                0,
                $this->module->displayName,
                null,
                null,
                (int) $currency->id,
                false,
                $customer->secure_key
            );

            Tools::redirect($order->payment_url);
        } else {
            Tools::redirect('index.php?controller=order&step=3');
        }
    }

    private function generateToken($order_id)
    {
        return hash('sha256', $order_id . (empty(Configuration::get('COINGATE_API_AUTH_TOKEN')) ? Configuration::get('API_SECRET') : Configuration::get('COINGATE_API_AUTH_TOKEN')));
    }

    /**
     * @param Customer $customer
     * @param Cart $cart
     *
     * @return array
     */
    private function getShopperInfo($customer, $cart): array
    {
        $billingAddress = new Address($cart->id_address_invoice);
        $country = new Country($billingAddress->id_country);

        $isBusiness = !empty($billingAddress->company) || !empty($billingAddress->vat_number);

        $shopper = [
            'type' => $isBusiness ? 'business' : 'personal',
            'ip_address' => Tools::getRemoteAddr(),
            'email' => $customer->email,
            'first_name' => $customer->firstname,
            'last_name' => $customer->lastname,
        ];

        // Add date of birth if available
        if (!empty($customer->birthday) && $customer->birthday !== '0000-00-00') {
            $shopper['date_of_birth'] = $customer->birthday;
        }

        if ($isBusiness) {
            $shopper['company_details'] = [
                'name' => $billingAddress->company,
                'address' => $billingAddress->address1,
                'postal_code' => $billingAddress->postcode,
                'city' => $billingAddress->city,
                'country' => $country->iso_code,
            ];
        } else {
            $shopper['residence_address'] = $billingAddress->address1;
            $shopper['residence_postal_code'] = $billingAddress->postcode;
            $shopper['residence_city'] = $billingAddress->city;
            $shopper['residence_country'] = $country->iso_code;
        }

        return array_filter($shopper, function($value) {
            return $value !== null && $value !== '';
        });
    }
}
