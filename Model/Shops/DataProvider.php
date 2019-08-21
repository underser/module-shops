<?php
/**
 * Underser shops data provider
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */

namespace Underser\Shops\Model\Shops;

use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Underser\Shops\Model\ResourceModel\Shops\CollectionFactory;
use Underser\Shops\Model\ResourceModel\Shops\Collection;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * Shops resource model.
     *
     * @var Collection
     */
    protected $collection;

    /**
     * Loaded data.
     *
     * @var array
     */
    protected $loadedData;

    /**
     * DataProvider constructor.
     *
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data.
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        /** @var \Underser\Shops\Model\Shops $item */
        foreach ($items as $item) {
            $this->loadedData[$item->getEntityId()] = $item->getData();
        }

        return $this->loadedData;
    }
}
