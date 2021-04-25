<?php
namespace Gama\NossasLojas\Controller\Index;

class Index extends \Gama\NossasLojas\Controller\Index
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Nossas Lojas'));

        return $resultPage;
    }
}
