<?php
/**
 * Underser shops form base button block.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */
declare(strict_types=1);

namespace Underser\Shops\Block\Adminhtml\Shop\Edit;

use Magento\Backend\Block\Widget\Context;
use Underser\Shops\Model\ShopsFactory;
use Underser\Shops\Model\Shops;
use Magento\Framework\Exception\NoSuchEntityException;

class BaseButton
{
    /**
     * widget context.
     *
     * @var Context
     */
    protected $context;

    /**
     * Shops factory.
     *
     * @var ShopsFactory
     */
    protected $shopsFactory;

    public function __construct(
        Context $context,
        ShopsFactory $shopsFactory
    ) {
        $this->context = $context;
        $this->shopsFactory = $shopsFactory;
    }

    /**
     * Get shop id.
     *
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        /** @var Shops $model */
        $model = $this->shopsFactory->create();

        try {
            return $model->load(
                $this->context->getRequest()->getParam('entity_id')
            )->getEntityId();
        } catch (NoSuchEntityException $e) {
            // Shop can't be loaded.
        }

        return null;
    }

    /**
     * Get url.
     *
     * @param string $route
     * @param array $params
     *
     * @return string
     */
    public function getUrl($route = '', $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
