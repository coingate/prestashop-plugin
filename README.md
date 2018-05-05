# PrestaShop CoinGate Plugin

Accept Bitcoin & Altcoins on your PrestaShop store.

Read the module installation instructions below to get started with CoinGate Bitcoin & Altcoin payment gateway on your shop.
Full setup guide with screenshots is also available on our blog: <https://blog.coingate.com/2017/04/install-prestashop-bitcoin/>

**Plugin is compatible with Prestashop 1.6 or greater version**

## Install

Sign up for CoinGate account at <https://coingate.com> for production and <https://sandbox.coingate.com> for testing (sandbox) environment.

Please note, that for "Test" mode you **must** generate separate API credentials on <https://sandbox.coingate.com>. API credentials generated on <https://coingate.com> will **not** work for "Test" mode.

Also note, that *Receive Currency* parameter in your module configuration window defines the currency of your settlements from CoinGate. Set it to BTC, EUR or USD, depending on how you wish to receive payouts. To receive settlements in **Euros** or **U.S. Dollars** to your bank, you have to verify as a merchant on CoinGate (login to your CoinGate account and click *Verification*). If you set your receive currency to **Bitcoin**, verification is not needed.

### via PrestaShop FTP Uploader

1. Download <https://github.com/coingate/prestashop-plugin/releases/download/v1.4.0/CoinGate_Prestashop-1.4.0.zip>

2. Go to your PrestaShop admin panel » **Modules and Services**.

3. Click **Add a new module**, then click **Choose a file**, find the file you just downloaded, select it and click **Open**. Click **Upload this module**.

4. In the **Modules list** choose **Payment and Gateways**.

5. Find **Cryptocurrency Payments via CoinGate** and click **Install** button to next to it, then click **Proceed with the installation**.

6. Enter your [API credentials](https://support.coingate.com/en/42/how-can-i-create-coingate-api-credentials) (*Auth Token*). Configure **Receive Currency** and click **Save**.
