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

use Magento\Framework\Exception\NoSuchEntityException;
use Underser\Shops\Api\Data\ShopsInterface;
use Underser\Shops\Api\ShopsRepositoryInterface;

class Shop
{
    /**
     * Shops repository.
     *
     * @var ShopsRepositoryInterface
     */
    protected $shopsRepository;

    /**
     * Shop constructor.
     *
     * @param ShopsRepositoryInterface $shopsRepository
     */
    public function __construct(ShopsRepositoryInterface $shopsRepository)
    {
        $this->shopsRepository = $shopsRepository;
    }

    /**
     * Provide data array with info about shop.
     *
     * @param int $entityId
     *
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData($entityId): array
    {
        $shop = $this->shopsRepository->getById($entityId);

        if ($shop->getIsActive() === false) {
            throw new NoSuchEntityException();
        }

        return [
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
}
