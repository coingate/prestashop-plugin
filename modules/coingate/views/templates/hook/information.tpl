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
    <button class="tablinks" onclick="changeTab(event, 'Information')" id="defaultOpen">{l s='Information' mod='coingate'}</button>
    <button class="tablinks" onclick="changeTab(event, 'Configure Settings')">{l s='Configure Settings' mod='coingate'}</button>
</div>

<!-- Tab content -->
<div id="Information" class="tabcontent">
    <div class="wrapper">
        <img src="../modules/coingate/views/img/invoice.png" style="float:right;"/>
        <h2 class="coingate-information-header">
            {l s='Accept Bitcoin, Litecoin, Ethereum and other digital currencies on your PrestaShop store with CoinGate' mod='coingate'}
        </h2><br/>
        <strong>{l s='What is CoinGate?' mod='coingate'}</strong> <br/>
        <p>
            {l s='We offer a fully automated cryptocurrency processing platform and invoice system. Accept any cryptocurrency and get paid in Euros or
       U.S. Dollars directly to your bank account (for verified merchants), or just keep bitcoins!' mod='coingate'}
        </p><br/>
        <strong>{l s='Getting started' mod='coingate'}</strong><br/>
        <p>
        <ul>
            <li>{l s='Install the CoinGate module on PrestaShop' mod='coingate'}</li>
            <li>
                {l s='Visit ' mod='coingate'}<a href="https://coingate.com" target="_blank">{l s='coingate.com' mod='coingate'}</a>
                {l s='and create an account' mod='coingate'}
            </li>
            <li>{l s='Get your API credentials and copy-paste them to the Configuration page in CoinGate module' mod='coingate'}</li>
            <li>{l s='Read our ' mod='coingate'}
                <a href="https://blog.coingate.com/2017/04/install-prestashop-bitcoin/" target="_blank">
                    {l s='detailed guide' mod='coingate'}
                </a> {l s='for assistance' mod='coingate'}</li>
        </ul>
        </p>
        <p class="sign-up"><br/>
            <a href="https://dashboard.coingate.com/register" target="_blank" class="sign-up-button">{l s='Sign up on CoinGate' mod='coingate'}</a>
        </p><br/>
        <strong>{l s='Features' mod='coingate'}</strong>
        <p>
        <ul>
            <li>{l s='The gateway is fully automatic - set and forget it.' mod='coingate'}</li>
            <li>{l s='Payment amount is calculated using real-time exchange rates' mod='coingate'}</li>
            <li>{l s='Your customers can select to pay with Bitcoin, Litecoin, Ethereum and 40+ other cryptocurrencies at checkout, while your payouts are in single currency of your choice.' mod='coingate'}</li>
            <li>
                <a href="https://sandbox.coingate.com" target="_blank">
                    {l s='Sandbox environment' mod='coingate'}
                </a> {l s='for testing with Testnet Bitcoin.' mod='coingate'}
            </li>
            <li>{l s='Transparent pricing: flat 1% processing fee, no setup or recurring fees.' mod='coingate'}</li>
            <li>{l s='No chargebacks - guaranteed!' mod='coingate'}</li>
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
