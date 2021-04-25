<?php
namespace Gama\NossasLojas\Block\Adminhtml\Stores\Edit\Tab;

use \Magento\Backend\Block\Widget\Form\Generic;
use \Magento\Backend\Block\Template\Context;
use \Magento\Framework\Registry;
use \Magento\Framework\Data\FormFactory;
use \Gama\NossasLojas\Model\System\Config\IsActive;

class Info extends Generic
{
    /**
     * @var IsActive
     */
    private $isActive;

    /**
     * Info constructor.
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param IsActive $isActive
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        IsActive $isActive,
        array $data = []
    ) {
        $this->isActive = $isActive;

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
            'base_fieldset',
            ['legend' => __('Info')]
        );

        if ($model->getId()) {
            $fieldset->addField(
                'store_id',
                'hidden',
                ['name' => 'store_id']
            );
        }


        $fieldset->addField(
            'name',
            'text',
            [
                'name'     => 'name',
                'label'    => __('Nome'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'address',
            'textarea',
            [
                'name'     => 'address',
                'label'    => __('Endereço'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'city',
            'text',
            [
                'name'     => 'city',
                'label'    => __('Cidade'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'postcode',
            'text',
            [
                'name'     => 'postcode',
                'label'    => __('CEP'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'email',
            'text',
            [
                'name'     => 'email',
                'label'    => __('E-mail'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'phone',
            'text',
            [
                'name'     => 'phone',
                'label'    => __('Telefone'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'label'   => __('Status'),
                'title'   => __('Status'),
                'name'    => 'is_active',
                'options' => $this->isActive->toOptionArray()
            ]
        );

        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }

        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
