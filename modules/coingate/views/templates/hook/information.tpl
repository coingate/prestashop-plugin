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
        <img src="{$module_dir}views/img/invoice.png" style="float:right; height: 580px; border-radius: 8px; box-shadow: 0 30px 40px rgba(0,0,0,.1)"/>
        <h2 class="coingate-information-header">
            {l s='Accept Crypto Payments with CoinGate’s PrestaShop Plugin'}
        </h2>
        <br/>
        <p>
            {l s='Easily accept cryptocurrency payments on your PrestaShop store using CoinGate. Our PrestaShop plugin provides fully automated payment processing and invoicing, making crypto payments simple, secure, and seamless for both you and your customers.' }
        </p>
        <p>
            {l s='With just a quick setup, your customers can pay using 15+ cryptocurrencies like Bitcoin, USDC, Ethereum, and Litecoin across multiple networks—including Layer 2 solutions like Polygon, Arbitrum, Base, Optimism, Solana, and more.'}
        </p>
        <p>
            {l s='You can receive settlements directly to your bank account in EUR, USD, or GBP—or choose to keep crypto.'}
        </p>
        <br/>
        <h3>{l s='Getting started' }</h3><br/>
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
        <br>
        <h3>{l s='Features' }</h3>
        <ul>
            <li>
                <strong>{l s='Fully automated gateway'}</strong> – {l s='no manual processing needed'}
            </li>
            <li>
                <strong>{l s='Real-time exchange rates'}</strong> – {l s='convert crypto to fiat instantly at checkout'}
            </li>
            <li>
                <strong>{l s='Multi-chain suppor'}</strong> – {l s='accept crypto on Ethereum, Polygon, Arbitrum, Solana, Base, Optimism, and'} <a href="https://coingate.com/supported-currencies" target="_blank">{l s='more'}</a>
            </li>
            <li>
                <strong>{l s='Customizable invoices'}</strong> – {l s='choose supported coins'}, <a href="https://coingate.com/blog/post/bitcoin-merchant-accept-underpaid-orders" target="_blank">{l s='accept underpaid or overpaid orders'}</a>, {l s='and adjust invoice settings'}
            </li>
            <li>
                <strong>{l s='Automatic order updates'}</strong> – {l s='payment confirmations trigger status changes'}
            </li>
            <li>
                <strong>{l s='Test mode available'}</strong> – {l s='experiment in a'} <a href="https://sandbox.coingate.com/" target="_blank">{l s='sandbox environment'}</a>
            </li>
            <li>
                <strong>{l s='Crypto refunds'}</strong> – {l s='issue full and partial'} <a href="https://coingate.com/blog/post/merchant-refund" target="_blank">{l s='refunds'}</a>
            </li>
            <li>
                <strong>{l s='Exportable reports'}</strong> – {l s='access accounting and payout data in just a few clicks'}
            </li>
            <li>
                <strong>{l s='Role-based account management'}</strong> – {l s='control'} <a href="https://coingate.com/blog/post/business-user-permissions" target="_blank">{l s='permissions'}</a> {l s='for team members'}
            </li>
            <li>
                <strong>{l s='Built-in AML/KYC tools'}</strong> – {l s='stay protected and compliant'}
            </li>
            <li>
                <strong>{l s='Flexible fees'}</strong> – {l s='starting at 1%, with lower'} <a href="https://coingate.com/pricing" target="_blank">{l s='rates'}</a> {l s='available for high-volume merchants'}
            </li>
            <li>
                <strong>{l s='No chargebacks'}</strong> – {l s='all crypto payments are final'}
            </li>
        </ul>
        <br>
        <h3>{l s='How It Works (Example)'}</h3>
        <ol>
            <li>{l s='A customer selects crypto as the payment method for a €100 order.'}</li>
            <li>{l s='Based on real-time rates, they’re shown the amount to pay in their chosen cryptocurrency.'}</li>
            <li>{l s='After payment confirmation, you receive ~€99 (minus fees) in your CoinGate account.'}</li>
            <li>{l s='You can withdraw funds to your bank in EUR, USD, or GBP—or hold them in crypto.'}</li>
        </ol>
    </div>
</div>

<div id="Configure Settings" class="tabcontent">
    {html_entity_decode($form|escape:'htmlall':'UTF-8')}
</div>

<script>
    document.getElementById("defaultOpen").click();
</script>
