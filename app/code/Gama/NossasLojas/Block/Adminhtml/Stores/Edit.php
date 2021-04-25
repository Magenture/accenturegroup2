<?php
namespace Gama\NossasLojas\Block\Adminhtml\Stores;

use \Magento\Backend\Block\Widget\Form\Container;
use \Magento\Backend\Block\Widget\Context;
use \Magento\Framework\Registry;

class Edit extends Container
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize store edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'store_id';
        $this->_blockGroup = 'Gama_NossasLojas';
        $this->_controller = 'adminhtml_stores';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Salvar Loja'));
        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ]
                ]
            ],
            -100
        );
        $this->buttonList->update('delete', 'label', __('Deletar Loja'));
    }

    /**
     * Retrieve text for header element depending on loaded post
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->coreRegistry->registry('nossaslojas_store')->getId()) {
            return __("Edit Store '%1'", $this->escapeHtml($this->coreRegistry->registry('nossaslojas_store')->getName()));
        } else {
            return __('Add Store');
        }
    }
}
