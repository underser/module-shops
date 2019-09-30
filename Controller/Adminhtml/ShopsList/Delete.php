<?php
/**
 * Underser shops delete action.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */

namespace Underser\Shops\Controller\Adminhtml\ShopsList;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Underser\Shops\Controller\Adminhtml\AbstractAction;

class Delete extends AbstractAction implements HttpPostActionInterface
{
    /**
     * @return Redirect
     */
    public function execute()
    {
        if ($entityId = $this->getRequest()->getParam('entity_id')) {
            try {
                $shop = $this->shopsRepository->getById($entityId);
                $shopName = $shop->getName();
                $this->shopsRepository->delete($shop);

                $this->messageManager->addSuccessMessage(__('The shop %1 has been deleted', $shopName));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        $this->messageManager->addErrorMessage(__('Sorry we can\'t delete this shop'));

        return $this->resultRedirectFactory->create()->setPath('*/*');
    }
}
