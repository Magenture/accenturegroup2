<?php
namespace Gama\NossasLojas\Api;

use \Gama\NossasLojas\Api\Data\StoreInterface;

/**
 * Interface StoreRepositoryInterface
 * @package Gama\NossasLojas\Api
 */
interface StoreRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return \Gama\NossasLojas\Api\Data\StoreInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($id);

    /**
     * @param \Gama\NossasLojas\Api\Data\StoreInterface $model
     *
     * @return \Gama\NossasLojas\Api\Data\StoreInterface
     * @throws \Exception
     */
    public function save(StoreInterface $model);

    /**
     * @param \Gama\NossasLojas\Api\Data\StoreInterface $model
     *
     * @return bool
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(StoreInterface $model);

    /**
     * @param int $id
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($id);
}
