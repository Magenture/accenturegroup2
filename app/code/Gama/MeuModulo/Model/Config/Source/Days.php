<?php
namespace Gama\MeuModulo\Model\Config\Source;

/**
 * Class Days
 * @package Gama\MeuModulo\Model\Config\Source
 */
class Days implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 1, 'label' => __('Monday')], ['value' => 2, 'label' => __('Tuesday')],
                ['value' => 3, 'label' => __('Wednesday')], ['value' => 4, 'label' => __('Thursday')],
                ['value' => 5, 'label' => __('Friday')], ['value' => 6, 'label' => __('Saturday')],
                ['value' => 7, 'label' => __('Sunday')]];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [1 => __('Monday'), 2 => __('Tuesday'), 3 => __('Wednesday'),
                4 => __('Thursday'), 5 => __('Friday'), 6 => __('Saturday'),
                7 => __('Sunday')];
    }
}
