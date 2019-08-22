<?php
/**
 * Underser shops repository interface.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */
declare(strict_types=1);

namespace Underser\Shops\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Underser\Shops\Api\Data\ShopsInterface;
use Underser\Shops\Api\Data\ShopsSearchResultsInterface;

interface ShopsRepositoryInterface
{
    /**
     * Save shop.
     *
     * @param ShopsInterface $shop
     *
     * @return ShopsInterface
     * @throws CouldNotSaveException
     */
    public function save(ShopsInterface $shop): ShopsInterface;

    /**
     * Provide shop by id.
     *
     * @param int $entityId
     *
     * @return ShopsInterface
     * @throws NoSuchEntityException
     */
    public function getById($entityId): ShopsInterface;

    /**
     * Get list of shops by given criteria.
     *
     * @param SearchCriteriaInterface $criteria
     *
     * @return ShopsSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): ShopsSearchResultsInterface;

    /**
     * Delete shop.
     *
     * @param ShopsInterface $shop
     *
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ShopsInterface $shop): bool;

    /**
     * Delete shop by entity id.
     *
     * @param int $entityId
     *
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteByEntityId($entityId): bool;
}
