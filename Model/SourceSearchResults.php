<?php
/**
 * Underser shops search results source.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */
declare(strict_types=1);

namespace Underser\Shops\Model;

use Magento\Framework\Api\SearchResults;
use Underser\Shops\Api\Data\ShopsSearchResultsInterface;

/**
 * SourceSearchResults.
 *
 * Created to solve strict type validation when realization returned instead of interface.
 */
class SourceSearchResults extends SearchResults implements ShopsSearchResultsInterface
{
}
