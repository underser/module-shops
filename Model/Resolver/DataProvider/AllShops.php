<?php
/**
 * Underser shop data provider.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */
declare(strict_types=1);

namespace Underser\Shops\Model\Resolver\DataProvider;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Underser\Shops\Api\Data\ShopsInterface;
use Underser\Shops\Api\ShopsRepositoryInterface;

class AllShops
{
    /**
     * Shops repository.
     *
     * @var ShopsRepositoryInterface
     */
    protected $shopsRepository;

    /**
     * Search criteria builder.
     *
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * Shop constructor.
     *
     * @param ShopsRepositoryInterface $shopsRepository
     */
    public function __construct(
        ShopsRepositoryInterface $shopsRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->shopsRepository = $shopsRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Provide data array with info about shop.
     *
     * @return array
     */
    public function getData(): array
    {
        $itemsResult = [];
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('is_active', 1)->create();
        $searchResult = $this->shopsRepository->getList($searchCriteria);

        /** @var ShopsInterface $shop */
        foreach ($searchResult->getItems() as $shop) {
            $itemsResult[] = [
                ShopsInterface::ENTITY_ID => $shop->getEntityId(),
                ShopsInterface::SHOP_ID => $shop->getShopId(),
                ShopsInterface::NAME => $shop->getName(),
                ShopsInterface::IS_ACTIVE => $shop->getIsActive(),
                ShopsInterface::CREATION_TIME => $shop->getCreationTime(),
                ShopsInterface::UPDATE_TIME => $shop->getUpdateTime(),
                ShopsInterface::DESCRIPTION => $shop->getDescription(),
                ShopsInterface::ADDRESS => $shop->getAddress(),
                ShopsInterface::ADDRESS_DESCRIPTION => $shop->getAddressDescription(),
                ShopsInterface::META_TITLE => $shop->getMetaTitle(),
                ShopsInterface::META_KEYWORDS => $shop->getMetaKeywords(),
                ShopsInterface::META_DESCRIPTION => $shop->getMetaDescription(),
                ShopsInterface::LON => $shop->getLongitude(),
                ShopsInterface::LAT => $shop->getLatitude()
            ];
        }

        return [
            'items' => $itemsResult,
            'total_count' => $searchResult->getTotalCount()
        ];
    }
}
