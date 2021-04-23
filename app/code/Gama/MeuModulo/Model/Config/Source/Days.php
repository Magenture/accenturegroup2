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
        return [['value' => 1, 'label' => __('Segunda-Feira')], ['value' => 2, 'label' => __('Terça-Feira')],
            ['value' => 3, 'label' => __('Quarta-Feira')], ['value' => 4, 'label' => __('Quinta-Feira')],
            ['value' => 5, 'label' => __('Sexta-Feira')], ['value' => 6, 'label' => __('Sabado')],
            ['value' => 7, 'label' => __('Domingo')]];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [1 => __('Segunda-Feira'), 2 => __('Terça-Feira'), 3 => __('Quarta-Feira'),
            4 => __('Quinta-Feira'), 5 => __('Sexta-Feira'), 6 => __('Sabado'),
            7 => __('Domingo')];
    }
}
