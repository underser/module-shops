<?php
/**
 * Underser shops collection.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */

namespace Underser\Shops\Model\ResourceModel\Shops;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Underser\Shops\Api\Data\ShopsInterface;

class Collection extends AbstractCollection
{
    /**
     * Metadata pool.
     *
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * Store manager.
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Id field name.
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Event prefix.
     *
     * @var string
     */
    protected $_eventPrefix = 'underser_shops_collection';

    /**
     * Event object.
     *
     * @var string
     */
    protected $_eventObject = 'underser_shops';

    /**
     * Load data for preview flag
     *
     * @var bool
     */
    protected $_previewFlag;

    /**
     * Collection constructor.
     *
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param MetadataPool $metadataPool
     * @param StoreManagerInterface $storeManager
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        MetadataPool $metadataPool,
        StoreManagerInterface $storeManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        $this->metadataPool = $metadataPool;
        $this->storeManager = $storeManager;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     * Define resource model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Underser\Shops\Model\Shops::class, \Underser\Shops\Model\ResourceModel\Shops::class);
        $this->_map['fields']['entity_id'] = 'main_table.entity_id';
        $this->_map['fields']['store'] = 'store_table.store_id';
    }

    /**
     * Add field filter to collection
     *
     * @param array|string $field
     * @param string|int|array|null $condition
     * @return $this
     */
    public function addFieldToFilter($field, $condition = null)
    {
        if (is_array($field) && in_array('store_id', $field, false)) {
            return $this->addStoreFilter($condition, false);
        }

        if ($field === 'store_id') {
            return $this->addStoreFilter($condition, false);
        }

        return parent::addFieldToFilter($field, $condition);
    }

    /**
     * Add store filter.
     *
     * @param $store
     * @param bool $withAdmin
     *
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
        }

        return $this;
    }

    /**
     * Perform adding filter by store
     *
     * @param int|array|Store $store
     * @param bool $withAdmin
     * @return void
     */
    protected function performAddStoreFilter($store, $withAdmin = true)
    {
        if ($store instanceof Store) {
            $store = [$store->getId()];
        }

        if (!is_array($store)) {
            $store = [$store];
        }

        if ($withAdmin) {
            $store[] = Store::DEFAULT_STORE_ID;
        }

        $this->addFilter('store', ['in' => $store], 'public');
    }

    /**
     * Set first store flag.
     *
     * @param bool $flag
     *
     * @return $this
     */
    protected function setFirstStoreFlag($flag = false)
    {
        $this->_previewFlag = $flag;

        return $this;
    }

    /**
     * Perform operations after collection load
     *
     * @param string $tableName
     * @param string|null $linkField
     *
     * @return void
     */
    protected function performAfterLoad($tableName, $linkField)
    {
        $linkedIds = $this->getColumnValues($linkField);
        if (count($linkedIds)) {
            $connection = $this->getConnection();
            $select = $connection->select()->from(['underser_shops_store' => $this->getTable($tableName)])
                ->where('underser_shops_store.' . $linkField . ' IN (?)', $linkedIds);
            $result = $connection->fetchPairs($select);
            if ($result) {
                foreach ($this as $item) {
                    $entityId = $item->getData($linkField);
                    if (!isset($result[$entityId])) {
                        continue;
                    }
                    if ($result[$entityId] === 0) {
                        $stores = $this->storeManager->getStores(false, true);
                        $storeId = current($stores)->getId();
                        $storeCode = key($stores);
                    } else {
                        $storeId = $result[$item->getData($linkField)];
                        $storeCode = $this->storeManager->getStore($storeId)->getCode();
                    }
                    $item->setData('_first_store_id', $storeId);
                    $item->setData('store_code', $storeCode);
                    $item->setData('store_id', [$result[$entityId]]);
                }
            }
        }
    }

    /**
     * After load collection.
     *
     * @return AbstractCollection
     * @throws \Exception
     */
    protected function _afterLoad()
    {
        $entityMetaData = $this->metadataPool->getMetadata(ShopsInterface::class);
        $this->performAfterLoad('underser_shops_store', $entityMetaData->getLinkField());
        $this->_previewFlag = false;

        return parent::_afterLoad();
    }

    /**
     * Join store relation table if there is store filter
     *
     * @param string $tableName
     * @param string|null $linkField
     *
     * @return void
     */
    protected function joinStoreRelationTable($tableName, $linkField)
    {
        if ($this->getFilter('store')) {
            $this->getSelect()->join(
                ['store_table' => $this->getTable($tableName)],
                'main_table.' . $linkField . ' = store_table.' . $linkField,
                []
            )->group(
                'main_table.' . $linkField
            );
        }
        parent::_renderFiltersBefore();
    }

    /**
     * Render filters before.
     *
     * @throws \Exception
     */
    protected function _renderFiltersBefore()
    {
        $entityMetaData = $this->metadataPool->getMetadata(ShopsInterface::class);
        $this->joinStoreRelationTable('underser_shops_store', $entityMetaData->getLinkField());
    }
}
