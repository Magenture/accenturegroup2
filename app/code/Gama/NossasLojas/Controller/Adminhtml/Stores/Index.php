<?php
namespace Gama\NossasLojas\Controller\Adminhtml\Stores;

use \Gama\NossasLojas\Controller\Adminhtml\Stores;

class Index extends Stores
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Nossas Lojas - Lista de Lojas'));

        return $resultPage;
    }
}
