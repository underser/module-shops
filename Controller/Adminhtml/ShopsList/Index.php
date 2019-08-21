<?php
/**
 * Underser shops list action.
 *
 * @category  Underser
 * @package   underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */

namespace Underser\Shops\Controller\AdminHtml\ShopsList;

use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Underser\Shops\Controller\Adminhtml\AbstractAction;

class Index extends AbstractAction implements HttpGetActionInterface
{
    /**
     * Action entry point.
     *
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Underser_Shops::shops_list')
            ->addBreadcrumb(__('Shops'), __('Shops'))
            ->getConfig()->getTitle()->set(__('Shops'));

        return $resultPage;
    }
}
