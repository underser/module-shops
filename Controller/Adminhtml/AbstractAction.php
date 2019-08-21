<?php
/**
 * Underser shops list base action.
 *
 * @category  Underser
 * @package   Underser\Shops
 * @author    Roman Sliusar <roman.slusar95@gmail.com>
 * @copyright 2019 Underser
 */

namespace Underser\Shops\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Underser\Shops\Api\Data\ShopsInterfaceFactory;
use Underser\Shops\Api\ShopsRepositoryInterface;

abstract class AbstractAction extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Underser_Shops::shops_list';

    /**
     * Page factory.
     *
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * Shops repository.
     *
     * @var ShopsRepositoryInterface
     */
    protected $shopsRepository;

    /**
     * Shops model.
     *
     * @var ShopsInterfaceFactory
     */
    protected $shopsFactory;

    /**
     * Index constructor.
     *
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     * @param ShopsInterfaceFactory $shopsModel
     * @param ShopsRepositoryInterface $shopsRepository
     */
    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory,
        ShopsInterfaceFactory $shopsFactory,
        ShopsRepositoryInterface $shopsRepository
    ) {
        $this->pageFactory = $pageFactory;
        $this->shopsFactory = $shopsFactory;
        $this->shopsRepository = $shopsRepository;
        parent::__construct($context);
    }

    /**
     * Action entry point.
     *
     * @return ResponseInterface|ResultInterface
     */
    abstract public function execute();
}
