<?php
namespace Gama\NossasLojas\Block\Adminhtml\Stores\Edit;

use \Gama\NossasLojas\Block\Adminhtml\Stores\Edit\Tab\Info;
use \Gama\NossasLojas\Block\Adminhtml\Stores\Edit\Tab\Map;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('nossaslojas_stores_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Editar Loja'));
    }

    /**
     * {@inheritdoc}
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'store_info',
            [
                'label' => __('Dados da Loja'),
                'title' => __('Dados da Loja'),
                'content' => $this->getLayout()->createBlock(
                    Info::class
                )->toHtml(),
                'active' => true
            ]
        );

        $this->addTab(
            'map_info',
            [
                'label' => __('Geolocalização'),
                'title' => __('Geolocalização'),
                'content' => $this->getLayout()->createBlock(
                    Map::class
                )->toHtml(),
                'active' => false
            ]
        );

        return parent::_beforeToHtml();
    }
}
