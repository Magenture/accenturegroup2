<?php

namespace Gama\MeuModulo\Observer;

use Magento\Framework\Event\Observer;

/**
 * Class CartConditionObserver
 */
class CartConditionObserver implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * Execute observer.
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        $additional = $observer->getAdditional();
        $conditions = (array) $additional->getConditions();

        $conditions = array_merge_recursive($conditions, [
            $this->getCustomerFirstOrderCondition()
        ]);

        $additional->setConditions($conditions);
        return $this;
    }

    /**
     * Get condition for day of the week.
     * @return array
     */
    private function getCustomerFirstOrderCondition()
    {
        return [
            'label'=> __('Dia da Semana'),
            'value'=> \Gama\MeuModulo\Model\Rule\Condition\Cart::class
        ];
    }
}
