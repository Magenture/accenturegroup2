<?php

namespace Gama\MeuModulo\Model\Rule\Condition;

use Magento\Setup\Exception;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;

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
     * @var SearchCriteriaBuilderFactory
     */
    protected $searchBuilderFactory;

    /**
     * Cart constructor.
     * @param \Magento\Rule\Model\Condition\Context $context
     * @param \Gama\MeuModulo\Model\Config\Source\Days $sourceDays
     * @param \Magento\SalesRule\Model\RuleRepository $ruleRepository
     * @param SearchCriteriaBuilderFactory $searchBuilder
     * @param array $data
     */
    public function __construct(
        \Magento\Rule\Model\Condition\Context $context,
        \Gama\MeuModulo\Model\Config\Source\Days $sourceDays,
        \Magento\SalesRule\Model\RuleRepository $ruleRepository,
        SearchCriteriaBuilderFactory $searchBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->sourceDays = $sourceDays;
        $this->ruleRepository = $ruleRepository;
        $this->searchBuilderFactory = $searchBuilder;
    }

    /**
     * Load attribute options
     * @return $this
     */
    public function loadAttributeOptions()
    {
        return $this->setAttributeOption([
            'day_of_the_week' => __('Dia da Semana')
        ]);
    }

    /**
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
     * @param \Magento\Framework\Model\AbstractModel $model
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function validate(\Magento\Framework\Model\AbstractModel $model): bool
    {
        try {
            /**  @var \Magento\Framework\Api\SearchCriteriaInterface */
            $searchCriteriaBuilder = $this->searchBuilderFactory->create();
            /**
             * Criteria to search by attribute option, because by Id on a store with multiple rules,
             * the Id always will be different
            */
            $searchCriteriaBuilder->addFilter(
                'conditions_serialized',
                '%day_of_the_week%',
                'like'
            );

            $rules = $this->ruleRepository->getList($searchCriteriaBuilder->create());

            if($rules != null) {
                //Get value set for selected day on the rule, for example Monday => 1
                $value = $rules->getItems()[0]->getCondition()->getConditions()[0]->getValue();
                return date('w') == $value;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
