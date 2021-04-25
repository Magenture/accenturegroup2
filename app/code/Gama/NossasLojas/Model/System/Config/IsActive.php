<?php
namespace Gama\NossasLojas\Model\System\Config;

use \Magento\Framework\Option\ArrayInterface;
use \Gama\NossasLojas\Model\Source\IsActive as Source;

class IsActive implements ArrayInterface
{
    /**
     * @var \Gama\NossasLojas\Model\Source\IsActive
     */
    private $source;

    /**
     * @param \Gama\NossasLojas\Model\Source\IsActive $source
     */
    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return $this->source->getAvailableStatuses();
    }
}
