<?php

namespace Gama\MeuModulo\Helper;

/**
 * Class Data
 * @package Gama\MeuModulo\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getWAPhone()
    {
        return $this->scopeConfig->getValue(
            'wa_chat/general/phone_number',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
