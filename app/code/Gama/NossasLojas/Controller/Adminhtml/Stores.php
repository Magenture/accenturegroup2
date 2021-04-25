<?php
namespace Gama\NossasLojas\Controller\Adminhtml;

use \Magento\Backend\App\Action;
use \Magento\Framework\View\Result\PageFactory;
use \Gama\NossasLojas\Api\StoreRepositoryInterface;
use \Gama\NossasLojas\Api\Data\StoreInterfaceFactory;
use \Gama\NossasLojas\Helper\Config as ConfigHelper;

abstract class Stores extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Gama\NossasLojas\Api\StoreRepositoryInterface
     */
    protected $storeRepository;

    /**
     * @var \Gama\NossasLojas\Api\Data\StoreInterfaceFactory
     */
    protected $storeFactory;

    /**
     * @var \Gama\NossasLojas\Helper\Config
     */
    private $configHelper;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Gama\NossasLojas\Api\StoreRepositoryInterface $storeRepository
     * @param StoreInterfaceFactory $storeFactory
     * @param \Gama\NossasLojas\Helper\Config $configHelper
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        StoreRepositoryInterface $storeRepository,
        StoreInterfaceFactory $storeFactory,
        ConfigHelper $configHelper
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->storeRepository = $storeRepository;
        $this->storeFactory = $storeFactory;
        $this->configHelper = $configHelper;
        parent::__construct($context);
    }

    /**
     * Init layout, menu and breadcrumb
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Gama_NossasLojas::stores_list');
        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Gama_NossasLojas::stores');
    }

    /**
     * @return $this|bool
     */
    protected function checkGoogleApiKey()
    {
        if ($this->configHelper->getGoogleApiKeyBackend() === null) {
            $this->messageManager->addErrorMessage(__('Google Api Key is not set!'));
            /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();

            return $resultRedirect->setPath('*/*/index');
        }
        return false;
    }
}
