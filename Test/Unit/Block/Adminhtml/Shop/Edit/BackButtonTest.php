<?php

namespace Underser\Shops\Test\Unit\Block\Adminhtml\Shop\Edit;

use Magento\Backend\Block\Widget\Context;
use PHPUnit\Framework\TestCase;
use Underser\Shops\Block\Adminhtml\Shop\Edit\BackButton;
use Underser\Shops\Model\ShopsFactory;

class BackButtonTest extends TestCase
{
    /**
     * @var BackButton
     */
    protected $backButton;

    protected $this;

    protected function setUp()
    {
        $contextMock = $this->getMockBuilder(Context::class)
            ->setMethods([
                'getUrl',
                'getUrlBuilder'
            ])
            ->disableOriginalConstructor()
            ->getMock();
        $contextMock->expects($this->atLeastOnce())
            ->method('getUrlBuilder')
            ->willReturnSelf();
        $contextMock->expects($this->atLeastOnce())
            ->method('getUrl')
            ->willReturn('some/test');
        $shopsFactoryMock = $this->getMockBuilder(ShopsFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->backButton = new BackButton($contextMock, $shopsFactoryMock);
    }

    /**
     * @covers BackButton::getButtonData
     */
    public function testGetButtonData()
    {
        $requiredKeys = ['label', 'on_click', 'class', 'sort_order'];
        $providedArrayData = $this->backButton->getButtonData();

        foreach ($requiredKeys as $key) {
            $this->assertArrayHasKey($key, $providedArrayData);
        }
    }
}
