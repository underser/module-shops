<?php
/**
 * Underser shop resolver.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */
declare(strict_types=1);

namespace Underser\Shops\Model\Resolver;

use Exception;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Underser\Shops\Model\Resolver\DataProvider\Shop as ShopProvider;

class Shop implements ResolverInterface
{
    /**
     * Shop data provider.
     *
     * @var ShopProvider
     */
    protected $shopProvider;

    /**
     * Shop constructor.
     *
     * @param ShopProvider $shopProvider
     */
    public function __construct(ShopProvider $shopProvider)
    {
        $this->shopProvider = $shopProvider;
    }

    /**
     * Fetches the data from persistence models and format it according to the GraphQL schema.
     *
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws Exception
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ): array {
        $entityId = $this->getEntityId($args);

        return $this->getShopData($entityId);
    }

    /**
     * Exclude entity id from request arguments.
     *
     * @param array $args
     *
     * @return int
     * @throws GraphQlInputException
     */
    protected function getEntityId(array $args): int
    {
        if(!isset($args['entity_id'])) {
            throw new GraphQlInputException(__('Entity id should be specified.'));
        }

        return (int)$args['entity_id'];
    }

    /**
     * Get shop data.
     *
     * @param int $entityId
     *
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    protected function getShopData($entityId): array
    {
        try {
            $shopData = $this->shopProvider->getData($entityId);
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }

        return $shopData;
    }
}
