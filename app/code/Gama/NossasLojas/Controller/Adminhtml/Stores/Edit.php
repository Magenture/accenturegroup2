<?php
namespace Gama\NossasLojas\Controller\Adminhtml\Stores;

use \Gama\NossasLojas\Controller\Adminhtml\Stores;
use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use \Gama\NossasLojas\Api\StoreRepositoryInterface;
use \Gama\NossasLojas\Helper\Config as ConfigHelper;
use \Magento\Framework\Registry;
use \Gama\NossasLojas\Api\Data\StoreInterfaceFactory;

class Edit extends Stores
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param StoreRepositoryInterface $storeRepository
     * @param StoreInterfaceFactory $storeFactory
     * @param \Gama\NossasLojas\Helper\Config $configHelper
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        StoreRepositoryInterface $storeRepository,
        StoreInterfaceFactory $storeFactory,
        ConfigHelper $configHelper,
        Registry $registry
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $resultPageFactory, $storeRepository, $storeFactory, $configHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        if ($error = $this->checkGoogleApiKey()) {
            return $error;
        }

        $id = $this->getRequest()->getParam('store_id');
        $store = $this->storeFactory->create();

        if ($id) {
            try {
                $store = $this->storeRepository->get($id);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This store no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $store->setData($data);
        }

        $this->coreRegistry->register('nossaslojas_store', $store);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Editar Loja') : __('Adicionar Nova Loja'),
            $id ? __('Editar Loja') : __('Adicionar Nova Loja')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Nossas Lojas - Lista'));
        $resultPage->getConfig()->getTitle()
            ->prepend($store->getId() ? $store->getName() : __('Add New Store'));

        return $resultPage;
    }
}
