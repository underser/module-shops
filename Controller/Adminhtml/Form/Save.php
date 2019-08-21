<?php
/**
 * Underser shops form save action.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */
declare(strict_types=1);

namespace Underser\Shops\Controller\Adminhtml\Form;

use Exception;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Underser\Shops\Api\Data\ShopsInterface;
use Underser\Shops\Controller\Adminhtml\AbstractAction;
use Underser\Shops\Model\Shops;

class Save extends AbstractAction implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Underser_Shops::save';

    /**
     * Save action.
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            /** @TODO add data processor */
            /** @var ShopsInterface $shopsModel */
            $shopsModel = $this->shopsFactory->create();
            $entityId = $this->getRequest()->getParam(ShopsInterface::ENTITY_ID);

            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Shops::STATUS_ENABLED;
            }
            if (empty($data[ShopsInterface::ENTITY_ID])) {
                $data[ShopsInterface::ENTITY_ID] = null;
            }

            if ($entityId) {
                try {
                    $shopsModel = $this->shopsRepository->getById($entityId);
                } catch (NoSuchEntityException $e) {
                    $this->messageManager->addErrorMessage(__('This shop no more exists.'));
                    return $resultRedirect->setPath('*/shopslist/index');
                }
            }

            $shopsModel->setData($data);

            $this->_eventManager->dispatch(
                'underser_shops_prepare_save',
                ['shop' => $shopsModel, 'request' => $this->getRequest()]
            );

            try {
                $this->shopsRepository->save($shopsModel);
                $this->messageManager->addSuccessMessage(__('You saved shop.'));

                return $this->processResultRedirect($shopsModel, $resultRedirect, $data);
            } catch (CouldNotSaveException $e) {
                $this->messageManager->addExceptionMessage($e, __('Sorry we can\'t save shop.'));
            }

            return $resultRedirect->setPath('*/shopslist/edit', ['entity_id' => $shopsModel->getEntityId()]);
        }

        return $resultRedirect->setPath('*/shopslist/index');
    }

    /**
     * Process result redirect.
     *
     * @param ShopsInterface $shopsModel
     * @param Redirect $resultRedirect
     * @param array $data
     *
     * @return Redirect
     * @throws CouldNotSaveException
     */
    protected function processResultRedirect($shopsModel, $resultRedirect, $data): Redirect
    {
        if (isset($data['back'])) {
            if ($data['back'] === 'duplicate') {
                $newShop = $this->shopsFactory->create(['data' => $data]);
                $newShop->setEntityId(null);
                $newShop->setIsActive(false);
                $this->shopsRepository->save($newShop);
                $this->messageManager->addSuccessMessage(__('You duplicated shop.'));

                return $resultRedirect->setPath('*/shopslist/edit', ['entity_id' => $newShop->getEntityId()]);
            }

            return $resultRedirect->setPath('*/shopslist/edit', ['entity_id' => $shopsModel->getEntityId()]);
        }

        return $resultRedirect->setPath('*/shopslist/index');
    }
}
