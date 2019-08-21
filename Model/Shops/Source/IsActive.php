<?php
/**
 * Underser shops is active source model.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */

namespace Underser\Shops\Model\Shops\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Underser\Shops\Model\Shops;

class IsActive implements OptionSourceInterface
{
    /**
     * Shops model.
     *
     * @var Shops
     */
    protected $shops;

    /**
     * IsActive constructor.
     *
     * @param Shops $shops
     */
    public function __construct(Shops $shops)
    {
        $this->shops = $shops;
    }

    /**
     * Return array of options as value-label pairs.
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $options = [];

        foreach ($this->shops->getAvailableStatuses() as $value => $label) {
            $options[] = [
                'label' => $label,
                'value' => $value
            ];
        }

        return $options;
    }
}
