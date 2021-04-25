<?php
namespace Gama\NossasLojas\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    /**
     * @return string|null
     */
    public function getGoogleApiKeyFrontend()
    {
        return $this->scopeConfig->getValue('nossaslojas/google_api_key/frontend', ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }

    /**
     * @return string|null
     */
    public function getGoogleApiKeyBackend()
    {
        return $this->scopeConfig->getValue('nossaslojas/google_api_key/backend', ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }
}
