<?php
/**
 * Underser shops repository.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */
declare(strict_types=1);

namespace Underser\Shops\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\TemporaryState\CouldNotSaveException;
use Magento\Store\Model\StoreManagerInterface;
use Underser\Shops\Api\Data;
use Underser\Shops\Api\ShopsRepositoryInterface;
use Underser\Shops\Model\ResourceModel\Shops as ShopsResource;
use Underser\Shops\Model\ResourceModel\Shops\Collection;
use Underser\Shops\Model\ResourceModel\Shops\CollectionFactory;

class ShopsRepository implements ShopsRepositoryInterface
{
    /**
     * Store manager.
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Shops resource model.
     *
     * @var ShopsResource
     */
    protected $resource;

    /**
     * Shops factory.
     *
     * @var Data\ShopsInterfaceFactory
     */
    protected $shopsFactory;

    /**
     * Shops collection factory.
     *
     * @var CollectionFactory
     */
    protected $shopsCollectionFactory;

    /**
     * Collection processor.
     *
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * Search result factory.
     *
     * @var Data\ShopsSearchResultsInterfaceFactory
     */
    protected $searchResultFactory;

    /**
     * ShopsRepository constructor.
     *
     * @param StoreManagerInterface $storeManager
     * @param ShopsResource $resource
     * @param Data\ShopsInterfaceFactory $shopsFactory
     * @param CollectionFactory $shopsCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param Data\ShopsSearchResultsInterfaceFactory $searchResultFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ShopsResource $resource,
        Data\ShopsInterfaceFactory $shopsFactory,
        CollectionFactory $shopsCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        Data\ShopsSearchResultsInterfaceFactory $searchResultFactory
    ) {
        $this->storeManager = $storeManager;
        $this->resource = $resource;
        $this->shopsFactory = $shopsFactory;
        $this->shopsCollectionFactory = $shopsCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * Save shop.
     *
     * @param ShopsInterface $shop
     *
     * @return Data\ShopsInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\ShopsInterface $shop): Data\ShopsInterface
    {
        if($shop->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $shop->setStoreId($storeId);
        }

        try {
            $this->resource->save($shop);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save shop: %1', $e->getMessage()), $e);
        }

        return $shop;
    }

    /**
     * Provide shop by id.
     *
     * @param $entityId
     *
     * @return Data\ShopsInterface
     * @throws NoSuchEntityException
     */
    public function getById($entityId): Data\ShopsInterface
    {
        /** @var Shops $shopsModel */
        $shopsModel = $this->shopsFactory->create();
        $shopsModel->load($entityId);

        if(!$shopsModel->getEntityId()) {
            throw new NoSuchEntityException(__('Could not load shop by id: %1', $entityId));
        }

        return $shopsModel;
    }

    /**
     * Get list of shops by given criteria.
     *
     * @param SearchCriteriaInterface $criteria
     *
     * @return ShopsSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): Data\ShopsSearchResultsInterface
    {
        /** @var Collection $shopsCollection */
        $shopsCollection = $this->shopsCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $shopsCollection);

        /** @var ShopsSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($shopsCollection->getItems());
        $searchResults->setTotalCount($shopsCollection->getSize());

        return $searchResults;
    }

    /**
     * Delete shop.
     *
     * @param ShopsInterface $shop
     *
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\ShopsInterface $shop): bool
    {
        try {
            $this->resource->delete($shop);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete shop: %1', $e->getMessage()));
        }

        return true;
    }

    /**
     * Delete shop by entity id.
     *
     * @param $entityId
     *
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteByEntityId($entityId): bool
    {
        try {
            $this->resource->delete($this->getById($entityId));
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete shop: %1', $e->getMessage()));
        }

        return true;
    }
}
