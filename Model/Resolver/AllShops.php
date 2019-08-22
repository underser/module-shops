<?php
/**
 * Underser shops resolver.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */
declare(strict_types=1);

namespace Underser\Shops\Model\Resolver;

use Exception;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Underser\Shops\Model\Resolver\DataProvider\AllShops as AllShopsProvider;

class AllShops implements ResolverInterface
{
    /**
     * Shop data provider.
     *
     * @var AllShopsProvider
     */
    protected $shopsProvider;

    /**
     * Shop constructor.
     *
     * @param AllShopsProvider $shopsProvider
     */
    public function __construct(AllShopsProvider $shopsProvider)
    {
        $this->shopsProvider = $shopsProvider;
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
        return $this->shopsProvider->getData();
    }
}
