<?php

namespace Underser\Shops\Test\Unit\Block\Adminhtml\Shop\Edit;

use Magento\Backend\Block\Widget\Context;
use PHPUnit\Framework\TestCase;
use Underser\Shops\Block\Adminhtml\Shop\Edit\DeleteButton;
use Underser\Shops\Model\Shops;
use Underser\Shops\Model\ShopsFactory;

class DeleteButtonTest extends TestCase
{
    /**
     * @var DeleteButton
     */
    protected $deleteButton;

    protected function setUp()
    {
        $shopModelMock = $this->getMockBuilder(Shops::class)
            ->disableOriginalConstructor()
            ->getMock();
        $shopModelMock->method('load')
            ->willReturnSelf();
        $shopModelMock->method('getEntityId')
            ->willReturn(1);

        $contextMock = $this->getMockBuilder(Context::class)
            ->setMethods([
                'getRequest',
                'getParam',
                'getUrlBuilder',
                'getUrl'
            ])
            ->disableOriginalConstructor()
            ->getMock();
        $contextMock->method('getRequest')
            ->willReturnSelf();
        $contextMock->method('getParam')
            ->willReturn(false);
        $contextMock->method('getUrlBuilder')
            ->willReturnSelf();
        $contextMock->method('getUrl')
            ->willReturn('test/url');

        $shopsFactoryMock = $this->getMockBuilder(ShopsFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $shopsFactoryMock->method('create')
            ->willReturn($shopModelMock);

        $this->deleteButton = new DeleteButton($contextMock, $shopsFactoryMock);
    }

    /**
     * @covers DeleteButton::getButtonData
     */
    public function testGetButtonData()
    {
        $requiredKeys = ['label', 'class', 'on_click', 'sort_order'];
        $providedArrayData = $this->deleteButton->getButtonData();

        foreach ($requiredKeys as $key) {
            $this->assertArrayHasKey($key, $providedArrayData);
        }
    }
}
