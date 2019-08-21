<?php
/**
 * Underser shops edit action.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */

namespace Underser\Shops\Controller\Adminhtml\ShopsList;

use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Underser\Shops\Api\Data\ShopsInterface;
use Underser\Shops\Controller\Adminhtml\AbstractAction;

class Edit extends AbstractAction implements HttpGetActionInterface
{
    /**
     * Action entry point.
     *
     * @return Page|Redirect
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->pageFactory->create();
        $entityId = $this->getRequest()->getParam('entity_id');
        /** @var ShopsInterface $model */
        $model = $this->shopsFactory->create();

        if ($entityId) {
            $model = $this->shopsRepository->getById($entityId);
            if (!$model->getEntityId()) {
                $this->messageManager->addErrorMessage(__('This shop no longer exists.'));
                return $this->resultRedirectFactory->create()->setPath('*/*');
            }
        }

        $resultPage->setActiveMenu('Underser_Shops::shops_list')
            ->addBreadcrumb(__('Shops'), __('Shops'))
            ->addBreadcrumb(__('Manage Shops'), __('Manage Shops'))
            ->addBreadcrumb(
                ($entityId ? __('Edit Shop') : __('New Shop')),
                ($entityId ? __('Edit Shop') : __('New Shop'))
            );
        $resultPage->getConfig()->getTitle()->prepend(
            ($model->getEntityId() ? $model->getName() : __('New Shop'))
        );

        return $resultPage;
    }
}
