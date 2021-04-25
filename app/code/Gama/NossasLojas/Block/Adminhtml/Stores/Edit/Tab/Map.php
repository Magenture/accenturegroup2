<?php
namespace Gama\NossasLojas\Block\Adminhtml\Stores\Edit\Tab;

use \Magento\Backend\Block\Widget\Form\Generic;
use \Magento\Backend\Block\Template\Context;
use \Magento\Framework\Registry;
use \Magento\Framework\Data\FormFactory;
use \Gama\NossasLojas\Block\Adminhtml\Stores\Helper\GoogleMap;

class Map extends Generic
{

    /**
     * Map constructor.
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * View URL getter
     *
     * @param int $storeId
     *
     * @return string
     */
    public function getViewUrl($storeId)
    {
        return $this->getUrl('nossaslojas/*/*', ['store_id' => $storeId]);
    }

    /**
     * @return $this
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('nossaslojas_store');

        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset(
            'map_fieldset',
            ['legend' => __('Localization informations')]
        );

        $fieldset->addType('google_map', GoogleMap::class);

        $fieldset->addField(
            'lat',
            'text',
            [
                'name'     => 'lat',
                'label'    => __('Latitude'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'lng',
            'text',
            [
                'name'     => 'lng',
                'label'    => __('Longitude'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'zoom',
            'text',
            [
                'name'     => 'zoom',
                'label'    => __('Zoom'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'store_location',
            'google_map',
            [
                'name'  => 'store_location',
                'label' => __('Store Location'),
                'title' => __('Store Location')
            ]
        );

        $fieldset->addField(
            'store_search_by_address',
            'button',
            [
                'name' => 'store_search_by_address'
            ]
        );

        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
