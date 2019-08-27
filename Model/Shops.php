<?php
/**
 * Underser shops model.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */
declare(strict_types=1);

namespace Underser\Shops\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;
use Underser\Shops\Api\Data\ShopsExtensionInterface;
use Underser\Shops\Api\Data\ShopsInterface;

/**
 * Class Shops
 *
 * @method Shops setStoreId(array $storeId)
 * @method array getStoreId()
 *
 * @package Underser\Shops\Model
 */
class Shops extends AbstractExtensibleModel implements IdentityInterface, ShopsInterface
{
    /**#@+
     * Shops Statuses
     */
    public const STATUS_ENABLED = 1;
    public const STATUS_DISABLED = 0;
    /**#@-*/

    /**
     * Model cache tag.
     *
     * @var string
     */
    protected const CACHE_TAG = 'u_shops';

    /**
     * Model cache tag.
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model event name.
     *
     * @var string
     */
    protected $_eventPrefix = 'underser_shops';

    /**
     * Initialize resource model.
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(\Underser\Shops\Model\ResourceModel\Shops::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get default values.
     *
     * @return array
     */
    public function getDefaultValues(): array
    {
        $values = [];

        return $values;
    }

    /**
     * Provide available shops statuses.
     *
     * @return array
     */
    public function getAvailableStatuses(): array
    {
        return [
            self::STATUS_ENABLED => __('Enabled'),
            self::STATUS_DISABLED => __('Disabled')
        ];
    }

    /**
     * Provide entity id.
     *
     * @return int
     */
    public function getEntityId(): int
    {
        return (int)$this->getData(self::ENTITY_ID);
    }

    /**
     * Provide shop id.
     *
     * @return int
     */
    public function getShopId(): int
    {
        return (int)$this->getData(self::SHOP_ID);
    }

    /**
     * Provide shop name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * Provide shop status.
     *
     * @return int
     */
    public function getIsActive(): int
    {
        return (int)$this->getData(self::IS_ACTIVE);
    }

    /**
     * Provide shop creation time.
     *
     * @return string
     */
    public function getCreationTime(): ?string
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Provide shop update time.
     *
     * @return string
     */
    public function getUpdateTime(): ?string
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Provide shop description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Provide shop address.
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * Provide shop address description.
     *
     * @return string
     */
    public function getAddressDescription(): ?string
    {
        return $this->getData(self::ADDRESS_DESCRIPTION);
    }

    /**
     * Provide metaTitle.
     *
     * @return string
     */
    public function getMetaTitle(): string
    {
        return $this->getData(self::META_TITLE);
    }

    /**
     * Provide meta keywords.
     *
     * @return string
     */
    public function getMetaKeywords(): string
    {
        return $this->getData(self::META_KEYWORDS);
    }

    /**
     * Provide meta description.
     *
     * @return string
     */
    public function getMetaDescription(): string
    {
        return $this->getData(self::META_DESCRIPTION);
    }

    /**
     * Provide shop longitude.
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return (float)$this->getData(self::LON);
    }

    /**
     * Provide shop latitude.
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return (float)$this->getData(self::LAT);
    }

    /**
     * Set entity id.
     *
     * @param int $entityId
     *
     * @return ShopsInterface
     */
    public function setEntityId($entityId): ShopsInterface
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Set shop id.
     *
     * @param int $id
     *
     * @return ShopsInterface
     */
    public function setShopId($id): ShopsInterface
    {
        return $this->setData(self::SHOP_ID, $id);
    }

    /**
     * Set shop name.
     *
     * @param string $name
     *
     * @return ShopsInterface
     */
    public function setName($name): ShopsInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Set shop status.
     *
     * @param int $isActive
     *
     * @return ShopsInterface
     */
    public function setIsActive($isActive): ShopsInterface
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Set shop creation time.
     *
     * @param int $time
     *
     * @return ShopsInterface
     */
    public function setCreationTime($time): ShopsInterface
    {
        return $this->setData(self::CREATION_TIME, $time);
    }

    /**
     * Set shop update time.
     *
     * @param int $time
     *
     * @return ShopsInterface
     */
    public function setUpdateTime($time): ShopsInterface
    {
        return $this->setData(self::UPDATE_TIME, $time);
    }

    /**
     * Set shop description.
     *
     * @param string $description
     *
     * @return ShopsInterface
     */
    public function setDescription($description): ShopsInterface
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Set shop address.
     *
     * @param string $address
     *
     * @return ShopsInterface
     */
    public function setAddress($address): ShopsInterface
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * Set shop address description.
     *
     * @param string $addressDescription
     *
     * @return ShopsInterface
     */
    public function setAddressDescription($addressDescription): ShopsInterface
    {
        return $this->setData(self::ADDRESS_DESCRIPTION, $addressDescription);
    }

    /**
     * Set metaTitle.
     *
     * @param string $metaTitle
     *
     * @return ShopsInterface
     */
    public function setMetaTitle($metaTitle): ShopsInterface
    {
        return $this->setData(self::META_TITLE, $metaTitle);
    }

    /**
     * Set meta description.
     *
     * @param $metaDescription
     *
     * @return ShopsInterface
     */
    public function setMetaDescription($metaDescription): ShopsInterface
    {
        return $this->setData(self::META_DESCRIPTION, $metaDescription);
    }

    /**
     * Set meta keywords.
     *
     * @param string $metaKeywords
     *
     * @return ShopsInterface
     */
    public function setMetaKeywords($metaKeywords): ShopsInterface
    {
        return $this->setData(self::META_KEYWORDS, $metaKeywords);
    }

    /**
     * Set shop longitude.
     *
     * @param int $lon
     *
     * @return ShopsInterface
     */
    public function setLongitude($lon): ShopsInterface
    {
        return $this->setData(self::LON, $lon);
    }

    /**
     * Set shop latitude.
     *
     * @param int $lat
     *
     * @return ShopsInterface
     */
    public function setLatitude($lat): ShopsInterface
    {
        return $this->setData(self::LAT, $lat);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return ShopsExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     *
     * @param ShopsExtensionInterface $extensionAttributes
     *
     * @return $this
     */
    public function setExtensionAttributes(ShopsExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
