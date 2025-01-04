{**
* Copyright since 2007 PrestaShop SA and Contributors
* PrestaShop is an International Registered Trademark & Property of PrestaShop SA
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License version 3.0
* that is bundled with this package in the file LICENSE.md.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/AFL-3.0
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* @author    PrestaShop SA and Contributors <contact@prestashop.com>
* @copyright Since 2007 PrestaShop SA and Contributors
* @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
*}
{capture name=path}
    <a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html':'UTF-8'}" title="{l s='Go back to the Checkout' d='Modules.Coingate.Shop'}">
        {l s='Checkout' d='Modules.Coingate.Shop'}
    </a>
    <span class="navigation-pipe">{$navigationPipe|escape:'htmlall':'UTF-8'}</span>
    {l s='CoinGate payment' d='Modules.Coingate.Shop'}
{/capture}

<h1 class="page-heading">
    {l s='Order summary' d='Modules.Coingate.Shop'}
</h1>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <= 0}
    <p class="alert alert-warning">
        {l s='Your shopping cart is empty.' d='Modules.Coingate.Shop'}
    </p>
{else}
    <form action="{$link->getModuleLink('coingate', 'redirect', [], true)|escape:'html':'UTF-8'}" method="post">
        <div class="box cheque-box">
            <h3 class="page-subheading">
                {l s='CoinGate payment' d='Modules.Coingate.Shop'}
            </h3>

            <p class="cheque-indent">
                <strong class="dark">
                    {l s='You have chosen to pay with Cryptocurrency via CoinGate.' d='Modules.Coingate.Shop'} {l s='Here is a short summary of your order:' d='Modules.Coingate.Shop'}
                </strong>
            </p>

            <p>
                - {l s='The total amount of your order is' d='Modules.Coingate.Shop'}
                <span id="amount" class="price">{displayPrice price=$total}</span>
                {if $use_taxes == 1}
                    {l s='(tax incl.)' d='Modules.Coingate.Shop'}
                {/if}
            </p>

            <p>
                - {l s='You will be redirected to CoinGate for payment with Cryptocurrency.' d='Modules.Coingate.Shop'}
                <br/>
                - {l s='Please confirm your order by clicking "I confirm my order".' d='Modules.Coingate.Shop'}
            </p>
        </div>
        <p class="cart_navigation clearfix" id="cart_navigation">
            <a class="button-exclusive btn btn-default" href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html':'UTF-8'}">
                <i class="icon-chevron-left"></i>{l s='Other payment methods' d='Modules.Coingate.Shop'}
            </a>
            <button class="button btn btn-default button-medium" type="submit">
                <span>{l s='I confirm my order' d='Modules.Coingate.Shop'}<i class="icon-chevron-right right"></i></span>
            </button>
        </p>
    </form>
{/if}
