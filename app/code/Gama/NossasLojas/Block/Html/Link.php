<?php
namespace Gama\NossasLojas\Block\Html;

/**
 * Class Link
 *
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Link extends \Magento\Framework\View\Element\Html\Link
{
    /**
     * {@inheritdoc}
     */
    public function getHref()
    {
        return $this->_urlBuilder->getUrl('nossaslojas');
    }

    /**
     * @return bool
     */
    public function isCurrent()
    {
        return $this->getData('current') || $this->_urlBuilder->getCurrentUrl() === $this->getHref();
    }
}
