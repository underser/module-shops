<?php
/**
 * Underser shops listing actions.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */

namespace Underser\Shops\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class ShopsActions extends Column
{
    /**
     * Actions urls.
     */
    const SHOPS_URL_PATH_EDIT = 'shops/shopslist/edit';
    const SHOPS_URL_PATH_DELETE = 'shops/shopslist/delete';

    /**
     * Escaper.
     *
     * @var Escaper
     */
    protected $escaper;

    /**
     * Url builder.
     *
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Edit url.
     *
     * @var string
     */
    protected $editUrl;

    /**
     * Delete url.
     *
     * @var string
     */
    protected $deleteUrl;

    /**
     * ShopsActions constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Escaper $escaper
     * @param UrlInterface $urlBuilder
     * @param string $editUrl
     * @param string $deleteUrl
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Escaper $escaper,
        UrlInterface $urlBuilder,
        $editUrl = self::SHOPS_URL_PATH_EDIT,
        $deleteUrl = self::SHOPS_URL_PATH_DELETE,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->escaper = $escaper;
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        $this->deleteUrl = $deleteUrl;
    }

    /**
     * Prepare data source.
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $title = $this->escaper->escapeHtml($item['name']);
                $name = $this->getData('name');

                if (isset($item['entity_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['entity_id' => $item['entity_id']]),
                        'label' => __('Edit')
                    ];

                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl($this->deleteUrl, ['entity_id' => $item['entity_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete %1', $title),
                            'message' => __('Are you sure you want to delete a %1 record?', $title),
                            '__disableTmpl' => true,
                        ],
                        'post' => true,
                    ];
                }
            }
        }

        return $dataSource;
    }
}
