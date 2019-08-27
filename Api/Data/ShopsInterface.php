<?php
/**
 * Underser shops interface.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */
declare(strict_types=1);

namespace Underser\Shops\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface ShopsInterface
 *
 * @package Underser\Shops\Api\Data
 */
interface ShopsInterface extends ExtensibleDataInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    public const ENTITY_ID = 'entity_id';
    public const SHOP_ID = 'shop_id';
    public const NAME = 'name';
    public const IS_ACTIVE = 'is_active';
    public const CREATION_TIME = 'creation_time';
    public const UPDATE_TIME = 'update_time';
    public const DESCRIPTION = 'description';
    public const ADDRESS = 'address';
    public const ADDRESS_DESCRIPTION = 'address_description';
    public const META_TITLE = 'meta_title';
    public const META_KEYWORDS = 'meta_keywords';
    public const META_DESCRIPTION = 'meta_description';
    public const LON = 'lon';
    public const LAT = 'lat';

    /**
     * Provide entity id.
     *
     * @return int
     */
    public function getEntityId(): int;

    /**
     * Provide shop id.
     *
     * @return int
     */
    public function getShopId(): int;

    /**
     * Provide shop name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Provide shop status.
     *
     * @return int
     */
    public function getIsActive(): int;

    /**
     * Provide shop creation time.
     *
     * @return string
     */
    public function getCreationTime(): ?string;

    /**
     * Provide shop update time.
     *
     * @return string
     */
    public function getUpdateTime(): ?string;

    /**
     * Provide shop description.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Provide shop address.
     *
     * @return string
     */
    public function getAddress(): string;

    /**
     * Provide shop address description.
     *
     * @return string
     */
    public function getAddressDescription(): ?string;

    /**
     * Provide metaTitle.
     *
     * @return string
     */
    public function getMetaTitle(): string;

    /**
     * Provide meta keywords.
     *
     * @return string
     */
    public function getMetaKeywords(): string;

    /**
     * Provide meta description.
     *
     * @return string
     */
    public function getMetaDescription(): string;

    /**
     * Provide shop longitude.
     *
     * @return float
     */
    public function getLongitude(): float;

    /**
     * Provide shop latitude.
     *
     * @return float
     */
    public function getLatitude(): float;

    /**
     * Set entity id.
     *
     * @param int $entityId
     *
     * @return ShopsInterface
     */
    public function setEntityId($entityId): ShopsInterface;

    /**
     * Set shop id.
     *
     * @param int $id
     *
     * @return ShopsInterface
     */
    public function setShopId($id): ShopsInterface;

    /**
     * Set shop name.
     *
     * @param string $name
     *
     * @return ShopsInterface
     */
    public function setName($name): ShopsInterface;

    /**
     * Set shop status.
     *
     * @param int $isActive
     *
     * @return ShopsInterface
     */
    public function setIsActive($isActive): ShopsInterface;

    /**
     * Set shop creation time.
     *
     * @param int $time
     *
     * @return ShopsInterface
     */
    public function setCreationTime($time): ShopsInterface;

    /**
     * Set shop update time.
     *
     * @param int $time
     *
     * @return ShopsInterface
     */
    public function setUpdateTime($time): ShopsInterface;

    /**
     * Set shop description.
     *
     * @param string $description
     *
     * @return ShopsInterface
     */
    public function setDescription($description): ShopsInterface;

    /**
     * Set shop address.
     *
     * @param string $address
     *
     * @return ShopsInterface
     */
    public function setAddress($address): ShopsInterface;

    /**
     * Set shop address description.
     *
     * @param string $addressDescription
     *
     * @return ShopsInterface
     */
    public function setAddressDescription($addressDescription): ShopsInterface;

    /**
     * Set metaTitle.
     *
     * @param string $metaTitle
     *
     * @return ShopsInterface
     */
    public function setMetaTitle($metaTitle): ShopsInterface;

    /**
     * Set meta description.
     *
     * @param $metaDescription
     *
     * @return ShopsInterface
     */
    public function setMetaDescription($metaDescription): ShopsInterface;

    /**
     * Set meta keywords.
     *
     * @param string $metaKeywords
     *
     * @return ShopsInterface
     */
    public function setMetaKeywords($metaKeywords): ShopsInterface;

    /**
     * Set shop longitude.
     *
     * @param int $lon
     *
     * @return ShopsInterface
     */
    public function setLongitude($lon): ShopsInterface;

    /**
     * Set shop latitude.
     *
     * @param int $lat
     *
     * @return ShopsInterface
     */
    public function setLatitude($lat): ShopsInterface;

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Underser\Shops\Api\Data\ShopsExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Underser\Shops\Api\Data\ShopsExtensionInterface $extensionAttributes
     *
     * @return $this
     */
    public function setExtensionAttributes(
        ShopsExtensionInterface $extensionAttributes
    );
}
