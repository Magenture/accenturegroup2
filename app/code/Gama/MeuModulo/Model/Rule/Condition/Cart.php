<?php

namespace Gama\MeuModulo\Model\Rule\Condition;

use Magento\Setup\Exception;

/**
 * Class Customer
 */
class Cart extends \Magento\Rule\Model\Condition\AbstractCondition
{
    /**
     * @var \Gama\MeuModulo\Model\Config\Source\Days
     */
    protected $sourceDays;

    /**
     * @var \Magento\SalesRule\Model\RuleRepository
     */
    protected $ruleRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchBuilder;

    /**
     * Cart constructor.
     * @param \Magento\Rule\Model\Condition\Context $context
     * @param \Gama\MeuModulo\Model\Config\Source\Days $sourceDays
     * @param \Magento\SalesRule\Model\RuleRepository $ruleRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Rule\Model\Condition\Context $context,
        \Gama\MeuModulo\Model\Config\Source\Days $sourceDays,
        \Magento\SalesRule\Model\RuleRepository $ruleRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->sourceDays = $sourceDays;
        $this->ruleRepository = $ruleRepository;
        $this->searchBuilder = $searchBuilder;
    }

    /**
     * Load attribute options
     * @return $this
     */
    public function loadAttributeOptions()
    {
        $this->setAttributeOption([
            'day_of_the_week' => __('Day of the week')
        ]);
        return $this;
    }

    /**
     * Get input type
     * @return string
     */
    public function getInputType()
    {
        return 'select';
    }

    /**
     * Get value element type
     * @return string
     */
    public function getValueElementType()
    {
        return 'select';
    }

    /**
     * Get value select options
     * @return array|mixed
     */
    public function getValueSelectOptions()
    {
        if (!$this->hasData('value_select_options')) {
            $this->setData(
                'value_select_options',
                $this->sourceDays->toOptionArray()
            );
        }
        return $this->getData('value_select_options');
    }

    /**
     * Validate Cart Day of the Week Condition
     * @param \Magento\Framework\Model\AbstractModel $model
     * @return bool
     */
    public function validate(\Magento\Framework\Model\AbstractModel $model)
    {
        try {
            /**
             * Criteria to search by attribute option, because by Id on a store with multiple rules,
             * the Id always will be different
            */
            $searchCriteria = $this->searchBuilder->addFilter(
                'conditions_serialized',
                '%day_of_the_week%',
                'like'
            )->create();

            $rules = $this->ruleRepository->getList($searchCriteria);

            if($rules != null) {
                //Get value set for selected day on the rule, for example Monday => 1
                $value = $rules->getItems()[0]->getCondition()->getConditions()[0]->getValue();
                return date('w') == $value ? true : false;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
