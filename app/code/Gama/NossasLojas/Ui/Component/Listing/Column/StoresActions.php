<?php
namespace Gama\NossasLojas\Ui\Component\Listing\Column;

use \Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Framework\UrlInterface;

class StoresActions extends Column
{
    /** Url path */
    const NOSSASLOJAS_URL_PATH_EDIT = 'nossaslojas/stores/edit';
    const NOSSASLOJAS_URL_PATH_DELETE = 'nossaslojas/stores/delete';

    /** @var UrlInterface */
    private $urlBuilder;

    /**
     * @var string
     */
    private $viewUrl;

    /**
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     * @param string             $viewUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $viewUrl = self::NOSSASLOJAS_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->viewUrl = $viewUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['store_id'])) {
                    $item[$name]['view'] = [
                        'href' => $this->urlBuilder->getUrl($this->viewUrl, ['store_id' => $item['store_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::NOSSASLOJAS_URL_PATH_DELETE, ['store_id' => $item['store_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "${ $.$data.title }"'),
                            'message' => __('Are you sure you wan\'t to delete a "${ $.$data.title }" store?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
