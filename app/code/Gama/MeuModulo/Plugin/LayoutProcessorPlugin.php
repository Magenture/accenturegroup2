<?php
namespace Gama\MeuModulo\Plugin;

class LayoutProcessorPlugin
{
    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */

    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['street'] = [
            'component' => 'Magento_Ui/js/form/components/group',
            //'label' => __('Endereço'),
            'required' => false,
            'dataScope' => 'shippingAddress.street',
            'provider' => 'checkoutProvider',
            'sortOrder' => 0,
            'type' => 'group',
            'additionalClasses' => 'street',
            'children' => [
                [
                    'label' => __('Rua'),
                    'required' => true,
                    'component' => 'Magento_Ui/js/form/element/abstract',
                    'config' => [
                        'customScope' => 'shippingAddress',
                        'template' => 'ui/form/field',
                        'elementTmpl' => 'ui/form/element/input'
                    ],
                    'dataScope' => '0',
                    'provider' => 'checkoutProvider',
                    'validation' => ['required-entry' => true, "min_text_len‌​gth" => 1, "max_text_length" => 255],
                ],
                [
                    'label' => __('Número'),
                    'required' => true,
                    'component' => 'Magento_Ui/js/form/element/abstract',
                    'config' => [
                        'customScope' => 'shippingAddress',
                        'template' => 'ui/form/field',
                        'elementTmpl' => 'ui/form/element/input'
                    ],
                    'dataScope' => '1',
                    'provider' => 'checkoutProvider',
                    'validation' => ['required-entry' => true, "min_text_len‌​gth" => 1, "max_text_length" => 255],
                ],
                [
                    'label' => __('Bairro'),
                    'required' => true,
                    'component' => 'Magento_Ui/js/form/element/abstract',
                    'config' => [
                        'customScope' => 'shippingAddress',
                        'template' => 'ui/form/field',
                        'elementTmpl' => 'ui/form/element/input'
                    ],
                    'dataScope' => '2',
                    'provider' => 'checkoutProvider',
                    'validation' => ['required-entry' => true, "min_text_len‌​gth" => 1, "max_text_length" => 255],
                ],
                [
                    'label' => __('Complemento'),
                    'component' => 'Magento_Ui/js/form/element/abstract',
                    'config' => [
                        'customScope' => 'shippingAddress',
                        'template' => 'ui/form/field',
                        'elementTmpl' => 'ui/form/element/input'
                    ],
                    'dataScope' => '3',
                    'provider' => 'checkoutProvider',
                    'validation' => ['required-entry' => false, "min_text_len‌​gth" => 1, "max_text_length" => 255],
                ],
            ]
        ];
        return $jsLayout;
    }
}
