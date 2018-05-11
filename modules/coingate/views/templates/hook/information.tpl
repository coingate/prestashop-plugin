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
	  <img src="../modules/coingate/views/img/currencies.png" style="float:right;"/>
	  <p class="sign-up"><br/>
	  	<a href="https://coingate.com/sign_up" class="sign-up-button">{l s='Sign up on CoinGate' mod='coingate'}</a>
	  </p><br/>
	  <strong>{l s='Features' mod='coingate'}</strong>
	  <p>
	  	<ul>
	  		<li>
          {l s='The gateway is ' mod='coingate'}
          <strong>{l s='fully automatic'}</strong>
          {l s=' - set and forget it.' mod='coingate'}
        </li>
	  		<li>{l s='Payment amount is calculated using' mod='coingate'}<strong> {l s='real-time exchange rates' mod='coingate'}</strong>.</li>
	  		<li>
          {l s='Your customers can select to
          <strong>{l s=' pay with Bitcoin, Litecoin, Ethereum and 40+ other cryptocurrencies' mod='coingate'} </strong>
          {l s=' at checkout, while your payouts are in single currency of your choice.' mod='coingate'}
         </li>
	  		<li>
          <a href="https://sandbox.coingate.com" target="_blank">
            {l s='Sandbox environment' mod='coingate'}
          </a> {l s='for testing with Testnet Bitcoin.' mod='coingate'}
        </li>
	  		<li><strong>{l s='Transparent pricing:' mod='coingate'}</strong>
          {l s=' flat 1% processing fee, no setup or recurring fees.' mod='coingate'}</li>
	  		<li><strong>{l s='No chargebacks' mod='coingate'}</strong>{l s=' - guaranteed!' mod='coingate'}</li>
	  	</ul>
	  </p>

	  <p><i>{l s='Questions? Contact support@coingate.com !' mod='coingate'}</i></p>
	</div>
</div>

<div id="Configure Settings" class="tabcontent">
  {html_entity_decode($form|escape:'htmlall':'UTF-8')}
</div>

<script>
	document.getElementById("defaultOpen").click();
</script>
