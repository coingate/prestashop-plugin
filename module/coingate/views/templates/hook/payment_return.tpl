{*
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
*  @author    CoinGate <info@coingate.com>
*  @copyright 2015-2016 CoinGate
*  @license   https://github.com/coingate/prestashop-plugin/blob/master/LICENSE  The MIT License (MIT)
*}
{if $state == $paid_state}
        <p>{l s='Your order on %s is complete.' mod='coingate'}
                <br /><br /> <strong>{l s='Your order will be sent as soon as your payment is confirmed.' mod='coingate'}</strong>
                <br /><br />{l s='If you have questions, comments or concerns, please contact our' mod='coingate'} <a href="{$link->getPageLink('contact', true)|escape:'html'}">{l s='customer support team. ' mod='coingate'}</a>
        </p>
{else}
      	<p class="warning">
                {l s='We noticed a problem with your order. If you think this is an error, feel free to contact our' mod='coingate'}
                <a href="{$link->getPageLink('contact', true)|escape:'html'}">{l s='customer support team. ' mod='coingate'}</a>.
        </p>
{/if}
