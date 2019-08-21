<?php
/**
 * Underser shops resource model.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */

namespace Underser\Shops\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Model\AbstractModel;

class Shops extends AbstractDb
{
    /**
     * Shops constructor.
     *
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * Init main table.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('underser_shops', 'entity_id');
    }

    /**
     * After load.
     *
     * @param AbstractModel $object
     *
     * @return AbstractDb
     */
    protected function _afterLoad(AbstractModel $object)
    {
        if($object->getEntityId()) {
            $stores = $this->lookupStoreIds($object->getEntityId());

            $object->setData('store_id', $stores);
        }

        return parent::_afterLoad($object);
    }

    /**
     * After model save.
     *
     * @param AbstractModel $object
     *
     * @return AbstractDb
     */
    protected function _afterSave(AbstractModel $object)
    {
        $oldStores = $this->lookupStoreIds($object->getEntityId());
        $newStores = (array)$object->getStores();
        $table = $this->getTable('underser_shops_store');

        if(empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }

        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);

        if($delete) {
            $where = ['entity_id = ?' => (int)$object->getEntityId(), 'store_id IN (?)' => $delete];

            $this->getConnection()->delete($table, $where);
        }

        if($insert) {
            $data = [];

            foreach ($insert as $storeId) {
                $data[] = ['entity_id' => (int)$object->getEntityId(), 'store_id' => (int)$storeId];
            }

            $this->getConnection()->insertMultiple($table, $data);
        }

        return parent::_afterSave($object);
    }

    /**
     * Load stores to witch entity is specified.
     *
     * @param $entityId
     *
     * @return array
     */
    protected function lookupStoreIds($entityId)
    {
        $connection = $this->getConnection();

        $select = $connection->select()->from(
            $this->getTable('underser_shops_store'),
            'store_id'
        )->where('entity_id = ?', (int)$entityId);

        return $connection->fetchCol($select);
    }
}
