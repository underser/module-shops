<?php

namespace Underser\Shops\Test\Unit\Block\Adminhtml\Shop\Edit;

use PHPUnit\Framework\TestCase;
use Underser\Shops\Block\Adminhtml\Shop\Edit\BaseButton;
use Underser\Shops\Block\Adminhtml\Shop\Edit\BackButton;
use Underser\Shops\Block\Adminhtml\Shop\Edit\DeleteButton;
use Underser\Shops\Block\Adminhtml\Shop\Edit\SaveButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;
use Underser\Shops\Model\ShopsFactory;

class CommonButtonTest extends TestCase
{
    /**
     * @var BaseButton
     */
    protected $baseButton;

    /**
     * @var BackButton
     */
    protected $backButton;

    /**
     * @var DeleteButton
     */
    protected $deleteButton;

    /**
     * @var SaveButton
     */
    protected $saveButton;

    protected function setUp()
    {
        $contextMock = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();
        $shopsFactoryMock = $this->getMockBuilder(ShopsFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->baseButton = new BaseButton($contextMock, $shopsFactoryMock);
        $this->backButton = new BackButton($contextMock, $shopsFactoryMock);
        $this->deleteButton = new DeleteButton($contextMock, $shopsFactoryMock);
        $this->saveButton = new SaveButton($contextMock, $shopsFactoryMock);
    }

    public function testButtonsInstance()
    {
        $this->assertInstanceOf(BaseButton::class, $this->baseButton);
        $this->assertInstanceOf(BackButton::class, $this->backButton);
        $this->assertInstanceOf(DeleteButton::class, $this->deleteButton);
        $this->assertInstanceOf(SaveButton::class, $this->saveButton);
    }

    public function testImplementsButtonProviderInterface()
    {
        $this->assertInstanceOf(ButtonProviderInterface::class, $this->backButton);
        $this->assertInstanceOf(ButtonProviderInterface::class, $this->deleteButton);
        $this->assertInstanceOf(ButtonProviderInterface::class, $this->saveButton);
    }
}
