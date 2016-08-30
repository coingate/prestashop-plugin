{*
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
* Do not edit or add to this file if you wish to upgrade CoinGate to newer
* versions in the future. If you wish to customize CoinGate for your
* needs please refer to http://www.coingate.com for more information.
*
*  @author CoinGate <support@coingate.com>
*  @copyright  2016 CoinGate
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}
{capture name=path}
    <a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html':'UTF-8'}" title="{l s='Go back to the Checkout' mod='coingate'}">
        {l s='Checkout' mod='coingate'}
    </a>
    <span class="navigation-pipe">{$navigationPipe|escape:'htmlall':'UTF-8'}</span>
    {l s='CoinGate payment' mod='coingate'}
{/capture}

<h1 class="page-heading">
    {l s='Order summary' mod='coingate'}
</h1>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <= 0}
    <p class="alert alert-warning">
        {l s='Your shopping cart is empty.' mod='coingate'}
    </p>
{else}
    <form action="{$link->getModuleLink('coingate', 'redirect', [], true)|escape:'html':'UTF-8'}" method="post">
        <div class="box cheque-box">
            <h3 class="page-subheading">
                {l s='CoinGate payment' mod='coingate'}
            </h3>

            <p class="cheque-indent">
                <strong class="dark">
                    {l s='You have chosen to pay by Bitcoin via CoinGate.' mod='coingate'} {l s='Here is a short summary of your order:' mod='coingate'}
                </strong>
            </p>

            <p>
                - {l s='The total amount of your order is' mod='coingate'}
                <span id="amount" class="price">{displayPrice price=$total}</span>
                {if $use_taxes == 1}
                    {l s='(tax incl.)' mod='coingate'}
                {/if}
            </p>

            <p>
                - {l s='You will be redirected to CoinGate for payment with Bitcoin.' mod='coingate'}
                <br/>
                - {l s='Please confirm your order by clicking "I confirm my order".' mod='coingate'}
            </p>
        </div>
        <p class="cart_navigation clearfix" id="cart_navigation">
            <a class="button-exclusive btn btn-default" href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html':'UTF-8'}">
                <i class="icon-chevron-left"></i>{l s='Other payment methods' mod='coingate'}
            </a>
            <button class="button btn btn-default button-medium" type="submit">
                <span>{l s='I confirm my order' mod='coingate'}<i class="icon-chevron-right right"></i></span>
            </button>
        </p>
    </form>
{/if}
