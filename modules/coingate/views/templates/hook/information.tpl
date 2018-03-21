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
  <button class="tablinks" onclick="changeTab(event, 'Information')" id="defaultOpen">Information</button>
  <button class="tablinks" onclick="changeTab(event, 'Configure Settings')">Configure Settings</button>
</div>

<!-- Tab content -->
<div id="Information" class="tabcontent">
	<div class="wrapper">
	  <img src="../modules/coingate/views/img/invoice.png" style="float:right;"/>
	  <h2 class="coingate-information-header">Accept Bitcoin, Litecoin, Ethereum and other digital currencies on your PrestaShop store with CoinGate</h2><br/>
	  <strong> What is CoinGate? </strong> <br/>
	  <p>We offer a fully automated cryptocurrency processing platform and invoice system. Accept any cryptocurrency and get paid in Euros or U.S. Dollars directly to your bank account (for verified merchants), or just keep bitcoins!</p><br/>
	  <strong>Getting started</strong><br/>
	  <p>
	  	<ul>
	  		<li>Install the CoinGate module on PrestaShop</li>
	  		<li>Visit <a href="https://coingate.com" target="_blank">coingate.com</a> and create an account</li>
	  		<li>Get your API credentials and copy-paste them to the Configuration page in CoinGate module</li>
	  		<li>Read our <a href="https://blog.coingate.com/2017/04/install-prestashop-bitcoin/" target="_blank">detailed guide</a> for assistance</li>
	  	</ul>
	  </p>
	  <img src="../modules/coingate/views/img/currencies.png" style="float:right;"/>
	  <p class="sign-up"><br/>
	  	<a href="https://coingate.com/sign_up" class="sign-up-button">Sign up on CoinGate</a>
	  </p><br/>
	  <strong>Features</strong>
	  <p>
	  	<ul>
	  		<li>The gateway is <strong>fully automatic</strong> - set and forget it.</li>
	  		<li>Payment amount is calculated using <strong> real-time exchange rates</strong>.</li>
	  		<li>Your customers can select to <strong> pay with Bitcoin, Litecoin, Ethereum and 40+ other cryptocurrencies </strong> at checkout, while your payouts are in single currency of your choice.</li>
	  		<li><a href="https://sandbox.coingate.com" target="_blank">Sandbox environment</a> for testing with Testnet Bitcoin.</li>
	  		<li><strong>Transparent pricing:</strong> flat 1% processing fee, no setup or recurring fees.</li>
	  		<li><strong> No chargebacks</strong> - guaranteed!</li>
	  	</ul>
	  </p>

	  <p><i> Questions? Contact support@coingate.com ! </i></p>
	</div>
</div>

<div id="Configure Settings" class="tabcontent">
  {html_entity_decode($form|escape:'htmlall':'UTF-8')}
</div>

<script>
	document.getElementById("defaultOpen").click();
</script>