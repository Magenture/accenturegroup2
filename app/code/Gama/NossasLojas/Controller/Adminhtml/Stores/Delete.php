<?php
namespace Gama\NossasLojas\Controller\Adminhtml\Stores;

use \Gama\NossasLojas\Controller\Adminhtml\Stores;

class Delete extends Stores
{
    /**
     * Delete store
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('store_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $this->storeRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('The store has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['store_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a store to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
