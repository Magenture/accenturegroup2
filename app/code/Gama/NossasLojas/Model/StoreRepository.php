<?php
namespace Gama\NossasLojas\Model;

use \Gama\NossasLojas\Api\StoreRepositoryInterface;
use \Gama\NossasLojas\Model\ResourceModel\Store as ResourceModel;
use \Gama\NossasLojas\Api\Data\StoreInterface;
use \Magento\Framework\Exception\NoSuchEntityException;
use \Magento\Framework\Exception\StateException;

class StoreRepository implements StoreRepositoryInterface
{
    /**
     * @var \Gama\NossasLojas\Model\ResourceModel\Store
     */
    private $resourceModel;

    /**
     * @var \Gama\NossasLojas\Model\StoreFactory
     */
    private $modelFactory;

    /**
     * @var Store[]
     */
    private $instances = [];

    /**
     * StoreRepository constructor.
     * @param ResourceModel $resourceModel
     * @param StoreFactory $modelFactory
     */
    public function __construct(
        ResourceModel $resourceModel,
        StoreFactory $modelFactory
    ) {
        $this->resourceModel = $resourceModel;
        $this->modelFactory = $modelFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        if (!isset($this->instances[$id])) {
            $model = $this->modelFactory->create();

            $model->load($id);

            if (!$model->getId()) {
                throw NoSuchEntityException::singleField('store_id', $id);
            }

            $this->instances[$id] = $model;
        }

        return $this->instances[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function save(StoreInterface $model)
    {
        try {
            $existingModel = $this->get($model->getId());
        } catch (NoSuchEntityException $e) {
            $existingModel = null;
        }

        if ($existingModel !== null) {
            foreach ($existingModel->getData() as $key => $value) {
                if (!$model->hasData($key)) {
                    $model->setData($key, $value);
                }
            }
        }

        $this->resourceModel->save($model);
        unset($this->instances[$model->getId()]);

        return $this->get($model->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(StoreInterface $model)
    {
        $name = $model->getName();
        try {
            unset($this->instances[$model->getId()]);
            $this->resourceModel->delete($model);
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove store %1', $name)
            );
        }
        unset($this->instances[$model->getId()]);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id)
    {
        $model = $this->get($id);

        return $this->delete($model);
    }
}
