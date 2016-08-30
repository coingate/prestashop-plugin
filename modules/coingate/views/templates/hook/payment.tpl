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
<div class="row">
    <div class="col-xs-12">
        <p class="payment_module">
            <a class="cheque" style="background-image: url('{$this_path}../../img/bitcoin-logo.png'); padding-left:150px;  background-size: 100px; background-position: 20px; 50%; background-repeat: no-repeat;" href="{$link->getModuleLink('coingate', 'payment')|escape:'htmlall':'UTF-8'}">

                {l s='Pay with Bitcoin via CoinGate.com' mod='coingate'}
                <br><span>({l s='order processing will be faster' mod='coingate'})</span>
            </a>
        </p>
    </div>
</div>
