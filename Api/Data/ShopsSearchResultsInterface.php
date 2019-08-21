<?php
/**
 * Underser shops search results interface.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */
declare(strict_types=1);

namespace Underser\Shops\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ShopsSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get pages list.
     *
     * @return ShopsInterface[]
     */
    public function getItems();

    /**
     * Set pages list.
     *
     * @param ShopsInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}
