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
{if $state == $paid_state}
    <p>{l s='Your order on %s is complete.' sprintf=[$shop_name] d='Modules.Coingate.Shop'}
        <br/><br/> <strong>{l s='Your order will be sent as soon as your payment is confirmed.' d='Modules.Coingate.Shop'}</strong>
        <br/><br/>{l s='If you have questions, comments or concerns, please contact our' d='Modules.Coingate.Shop'} <a href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}">{l s='customer support team. ' d='Modules.Coingate.Shop'}</a>
    </p>
{else}
    <p class="warning">
        {l s='We noticed a problem with your order. If you think this is an error, feel free to contact our' d='Modules.Coingate.Shop'}
        <a href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}">{l s='customer support team. ' d='Modules.Coingate.Shop'}</a>.
    </p>
{/if}
