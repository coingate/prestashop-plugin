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
<div class="tab">
    <button class="tablinks" onclick="changeTab(event, 'Information')" id="defaultOpen">{l s='Information' d='Modules.Coingate.Admin'}</button>
    <button class="tablinks" onclick="changeTab(event, 'Configure Settings')">{l s='Configure Settings' d='Modules.Coingate.Admin'}</button>
</div>

<!-- Tab content -->
<div id="Information" class="tabcontent">
    <div class="wrapper">
        <img src="../modules/coingate/views/img/invoice.png" style="float:right; height: 580px; border-radius: 8px; box-shadow: 0 30px 40px rgba(0,0,0,.1)"/>
        <h2 class="coingate-information-header">
            {l s='Accept Bitcoin, Litecoin, Ethereum and other digital currencies on your PrestaShop store with CoinGate'}
        </h2><br/>
        <strong>{l s='What is CoinGate?'}</strong> <br/>
        <p>
            {l s='We offer a fully automated cryptocurrency processing platform and invoice system. Accept 70+ cryptocurrencies and get paid in EUR, USD or GBP directly to your bank account, or just keep bitcoins!' }
        </p>
        <br/>
        <strong>{l s='Getting started' }</strong><br/>
        <p>
            <ul>
                <li>{l s='Install the CoinGate module on PrestaShop' }</li>
                <li>
                    {l s='Visit ' }<a href="https://coingate.com" target="_blank">{l s='coingate.com' }</a>
                    {l s='and create an account' }
                </li>
                <li>{l s='Get your API credentials and copy-paste them to the Configuration page in CoinGate module' }</li>
                <li>{l s='Read our ' }
                    <a href="https://coingate.com/blog/post/install-prestashop-bitcoin" target="_blank">
                        {l s='detailed guide' }
                    </a> {l s='for assistance' }</li>
            </ul>
        </p>
        <p class="sign-up">
            <br/>
            <a href="https://dashboard.coingate.com/register" target="_blank" class="sign-up-button">{l s='Sign up on CoinGate' }</a>
        </p>
        <br/>
        <strong>{l s='Features' }</strong>
        <p>
            <ul>
                <li>{l s='A simple, one-time setup with little-to-no maintenance needed;' }</li>
                <li>{l s='Instant payment confirmations and order status updates;' }</li>
                <li>{l s='Pricing of merchandise in any local fiat currency;' }</li>
                <li>{l s='Issuing full and partial refunds manually and automatically;' }</li>
                <li>{l s='Permission-based account management tools;' }</li>
                <li>{l s='Accept +70 cryptocurrencies and tokens at once;' }</li>
                <li>{l s='Bitcoin Lightning Network support;' }</li>
                <li>{l s='Payouts in stablecoins, BTC, other cryptos, or fiat currencies (EUR/USD/GBP);' }</li>
                <li>{l s='Mitigation of cryptocurrency market volatility;' }</li>

                <li>{l s='The gateway is fully automatic - set and forget it.' }</li>
                <li>{l s='Payment amount is calculated using real-time exchange rates' }</li>
                <li>{l s='Your customers can select to pay with Bitcoin, Litecoin, Ethereum and 40+ other cryptocurrencies at checkout, while your payouts are in single currency of your choice.' }</li>
                <li>
                    <a href="https://sandbox.coingate.com" target="_blank">
                        {l s='Sandbox environment' }
                    </a> {l s='for testing the gateway\'s functionality;' }
                </li>
            </ul>
        </p>
    </div>
</div>

<div id="Configure Settings" class="tabcontent">
    {html_entity_decode($form|escape:'htmlall':'UTF-8')}
</div>

<script>
    document.getElementById("defaultOpen").click();
</script>
