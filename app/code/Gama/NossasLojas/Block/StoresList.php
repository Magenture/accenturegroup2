<?php
namespace Gama\NossasLojas\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\DataObject\IdentityInterface;
use \Gama\NossasLojas\Model\ResourceModel\Store\CollectionFactory as StoreCollectionFactory;
use \Magento\Framework\Json\Helper\Data as DataHelper;
use \Gama\NossasLojas\Helper\Config as ConfigHelper;
use \Gama\NossasLojas\Api\Data\StoreInterface;
use \Gama\NossasLojas\Model\ResourceModel\Store\Collection as StoreCollection;
use \Gama\NossasLojas\Model\Store;

class StoresList extends Template implements IdentityInterface
{
    /**
     * @var \Gama\NossasLojas\Model\ResourceModel\Store\CollectionFactory
     */
    private $storeCollectionFactory;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    private $dataHelper;

    /**
     * @var \Gama\NossasLojas\Helper\Config
     */
    private $configHelper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Gama\NossasLojas\Model\ResourceModel\Store\CollectionFactory $storeCollectionFactory
     * @param \Magento\Framework\Json\Helper\Data $dataHelper
     * @param ConfigHelper $configHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        StoreCollectionFactory $storeCollectionFactory,
        DataHelper $dataHelper,
        ConfigHelper $configHelper,
        array $data = []
    ) {
        $this->storeCollectionFactory = $storeCollectionFactory;
        $this->dataHelper = $dataHelper;
        $this->configHelper = $configHelper;
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {
        $this->_addBreadcrumbs();

        return parent::_prepareLayout();
    }

    private function _addBreadcrumbs()
    {
        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb(
                'home',
                [
                    'label' => __('Home'),
                    'title' => __('Go to Home Page'),
                    'link' => $this->_storeManager->getStore()->getBaseUrl()
                ]
            );

            $breadcrumbsBlock->addCrumb(
                'nossaslojas',
                [
                    'label' => __('Nossas Lojas'),
                ]
            );
        }
    }

    /**
     * @return string
     */
    public function getStoresJson()
    {
        if (!$this->hasData('stores_0')) {
            $stores = [];

            $storesCollection = $this->storeCollectionFactory
                ->create();

            $storesCollection->addFilter('is_active', 1)
                ->addOrder(
                    StoreInterface::NAME,
                    StoreCollection::SORT_ORDER_DESC
                );

            if ($storesCollection->getSize() > 0) {
                /**
                 * @var \Gama\NossasLojas\Model\Store $store
                 */
                foreach ($storesCollection as $store) {
                    $elem = $store->getData();
                    $stores[] = $elem;
                }
            }

            $this->setData('stores_0', base64_encode($this->dataHelper->jsonEncode($stores)));
        }

        return $this->getData('stores_0');
    }

    /**
     * @return string
     */
    public function getStoresGroupedJson()
    {
        if (!$this->hasData('stores_0')) {
            $stores = [];

            $storesCollection = $this->storeCollectionFactory
                ->create();

            $storesCollection->addFilter('is_active', 1)
                ->addFieldToSelect(['store_id']);

            if ($storesCollection->getSize() > 0) {
                $stores = false;
            }

            $this->setData('stores_0', base64_encode($this->dataHelper->jsonEncode($stores)));
        }

        return $this->getData('stores_0');
    }

    /**
     * @return string|null
     */
    public function getGoogleApiKey()
    {
        return $this->configHelper->getGoogleApiKeyFrontend();
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentities()
    {
        return [Store::CACHE_TAG . '_' . 'list'];
    }

}
