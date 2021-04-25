<?php
namespace Gama\NossasLojas\Model\ResourceModel\Store;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use \Gama\NossasLojas\Model\Store as Model;
use \Gama\NossasLojas\Model\ResourceModel\Store as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'store_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
