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
        <img src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/invoice.png" style="float:right; height: 580px; border-radius: 8px; box-shadow: 0 30px 40px rgba(0,0,0,.1)"/>
        <h2 class="coingate-information-header">
            {l s='Accept Crypto Payments with CoinGate’s PrestaShop Plugin' d='Modules.Coingate.Admin'}
        </h2>
        <br/>
        <p>
            {l s='Easily accept cryptocurrency payments on your PrestaShop store using CoinGate. Our PrestaShop plugin provides fully automated payment processing and invoicing, making crypto payments simple, secure, and seamless for both you and your customers.' d='Modules.Coingate.Admin'}
        </p>
        <p>
            {l s='With just a quick setup, your customers can pay using 15+ cryptocurrencies like Bitcoin, USDC, Ethereum, and Litecoin across multiple networks—including Layer 2 solutions like Polygon, Arbitrum, Base, Optimism, Solana, and more.' d='Modules.Coingate.Admin'}
        </p>
        <p>
            {l s='You can receive settlements directly to your bank account in EUR, USD, or GBP—or choose to keep crypto.' d='Modules.Coingate.Admin'}
        </p>
        <br/>
        <h3>{l s='Getting started' d='Modules.Coingate.Admin'}</h3><br/>
        <ul>
            <li>{l s='Install the CoinGate module on PrestaShop' d='Modules.Coingate.Admin'}</li>
            <li>
                {l s='Visit ' d='Modules.Coingate.Admin'}<a href="https://coingate.com" target="_blank">{l s='coingate.com' d='Modules.Coingate.Admin'}</a>
                {l s='and create an account' d='Modules.Coingate.Admin'}
            </li>
            <li>{l s='Get your API credentials and copy-paste them to the Configuration page in CoinGate module' d='Modules.Coingate.Admin'}</li>
            <li>{l s='Read our ' d='Modules.Coingate.Admin'}
                <a href="https://coingate.com/blog/post/install-prestashop-bitcoin" target="_blank">
                    {l s='detailed guide' d='Modules.Coingate.Admin'}
                </a> {l s='for assistance' d='Modules.Coingate.Admin'}</li>
        </ul>
        <br>
        <h3>{l s='Features' d='Modules.Coingate.Admin'}</h3>
        <ul>
            <li>
                <strong>{l s='Fully automated gateway' d='Modules.Coingate.Admin'}</strong> – {l s='no manual processing needed' d='Modules.Coingate.Admin'}
            </li>
            <li>
                <strong>{l s='Real-time exchange rates' d='Modules.Coingate.Admin'}</strong> – {l s='convert crypto to fiat instantly at checkout' d='Modules.Coingate.Admin'}
            </li>
            <li>
                <strong>{l s='Multi-chain suppor' d='Modules.Coingate.Admin'}</strong> – {l s='accept crypto on Ethereum, Polygon, Arbitrum, Solana, Base, Optimism, and' d='Modules.Coingate.Admin'} <a href="https://coingate.com/supported-currencies" target="_blank">{l s='more' d='Modules.Coingate.Admin'}</a>
            </li>
            <li>
                <strong>{l s='Customizable invoices' d='Modules.Coingate.Admin'}</strong> – {l s='choose supported coins' d='Modules.Coingate.Admin'}, <a href="https://coingate.com/blog/post/bitcoin-merchant-accept-underpaid-orders" target="_blank">{l s='accept underpaid or overpaid orders' d='Modules.Coingate.Admin'}</a>, {l s='and adjust invoice settings' d='Modules.Coingate.Admin'}
            </li>
            <li>
                <strong>{l s='Automatic order updates' d='Modules.Coingate.Admin'}</strong> – {l s='payment confirmations trigger status changes' d='Modules.Coingate.Admin'}
            </li>
            <li>
                <strong>{l s='Test mode available' d='Modules.Coingate.Admin'}</strong> – {l s='experiment in a' d='Modules.Coingate.Admin'} <a href="https://sandbox.coingate.com/" target="_blank">{l s='sandbox environment' d='Modules.Coingate.Admin'}</a>
            </li>
            <li>
                <strong>{l s='Crypto refunds' d='Modules.Coingate.Admin'}</strong> – {l s='issue full and partial' d='Modules.Coingate.Admin'} <a href="https://coingate.com/blog/post/merchant-refund" target="_blank">{l s='refunds' d='Modules.Coingate.Admin'}</a>
            </li>
            <li>
                <strong>{l s='Exportable reports' d='Modules.Coingate.Admin'}</strong> – {l s='access accounting and payout data in just a few clicks' d='Modules.Coingate.Admin'}
            </li>
            <li>
                <strong>{l s='Role-based account management' d='Modules.Coingate.Admin'}</strong> – {l s='control' d='Modules.Coingate.Admin'} <a href="https://coingate.com/blog/post/business-user-permissions" target="_blank">{l s='permissions' d='Modules.Coingate.Admin'}</a> {l s='for team members' d='Modules.Coingate.Admin'}
            </li>
            <li>
                <strong>{l s='Built-in AML/KYC tools' d='Modules.Coingate.Admin'}</strong> – {l s='stay protected and compliant' d='Modules.Coingate.Admin'}
            </li>
            <li>
                <strong>{l s='Flexible fees' d='Modules.Coingate.Admin'}</strong> – {l s='starting at 1%, with lower' d='Modules.Coingate.Admin'} <a href="https://coingate.com/pricing" target="_blank">{l s='rates' d='Modules.Coingate.Admin'}</a> {l s='available for high-volume merchants' d='Modules.Coingate.Admin'}
            </li>
            <li>
                <strong>{l s='No chargebacks' d='Modules.Coingate.Admin'}</strong> – {l s='all crypto payments are final' d='Modules.Coingate.Admin'}
            </li>
        </ul>
        <br>
        <h3>{l s='How It Works (Example)' d='Modules.Coingate.Admin'}</h3>
        <ol>
            <li>{l s='A customer selects crypto as the payment method for a €100 order.' d='Modules.Coingate.Admin'}</li>
            <li>{l s='Based on real-time rates, they’re shown the amount to pay in their chosen cryptocurrency.' d='Modules.Coingate.Admin'}</li>
            <li>{l s='After payment confirmation, you receive ~€99 (minus fees) in your CoinGate account.' d='Modules.Coingate.Admin'}</li>
            <li>{l s='You can withdraw funds to your bank in EUR, USD, or GBP—or hold them in crypto.' d='Modules.Coingate.Admin'}</li>
        </ol>
    </div>
</div>

<div id="Configure Settings" class="tabcontent">
    {html_entity_decode($form|escape:'htmlall':'UTF-8')}
</div>

<script>
    document.getElementById("defaultOpen").click();
</script>
