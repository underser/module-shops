<?php
/**
 * Underser shops form save button block.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */
declare(strict_types=1);

namespace Underser\Shops\Block\Adminhtml\Shop\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Ui\Component\Control\Container;

class BackButton extends BaseButton implements ButtonProviderInterface
{
    /**
     * Retrieve button-specified settings
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Provide back url.
     *
     * @return string|null
     */
    protected function getBackUrl(): ?string
    {
        return $this->getUrl('*/*/');
    }
}
