<?php

require_once(_PS_MODULE_DIR_ . '/coingate/vendor/version.php');

function coingate_log($name, $config, $coingate, $customData) {
  $logger = new FileLogger(0);
  $logger->setFilename(_PS_ROOT_DIR_."/log/coingate.log");
  $logger->logDebug($name
              . ' - App ID: ' . $config['app_id']
              . '; Mode: ' . ($config['test'] == '1' ? 'sandbox' : 'live')
              . '; HTTP Status: ' . $coingate->status_code
              . '; Response: ' . $coingate->response
              . '; cURL Error: ' . json_encode($coingate->curl_error)
              . '; PHP Version: ' . phpversion()
              . '; cURL Version: ' . json_encode(curl_version())
              . '; Prestashop Version: ' . _PS_VERSION_
              . '; Plugin Version: ' . COINGATE_PRESTASHOP_EXTENSION_VERSION
              . $customData
              . "\n");
}
