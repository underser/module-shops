<?php

namespace Underser\Shops\Test\Unit\Block\Adminhtml\Shop\Edit;

use Magento\Backend\Block\Widget\Context;
use PHPUnit\Framework\TestCase;
use Underser\Shops\Block\Adminhtml\Shop\Edit\SaveButton;
use Underser\Shops\Model\ShopsFactory;

class SaveButtonTest extends TestCase
{
    /**
     * @var SaveButton
     */
    protected $saveButton;

    protected function setUp()
    {
        $context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();
        $shopsFactory = $this->getMockBuilder(ShopsFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->saveButton = new SaveButton($context, $shopsFactory);
    }

    /**
     * @covers SaveButton::getButtonData
     */
    public function testGetButtonData()
    {
        $requiredKeys = [
            'label',
            'class',
            'data_attribute',
            'class_name',
            'options',
            'sort_order'
        ];
        $providedArrayData = $this->saveButton->getButtonData();

        foreach ($requiredKeys as $key) {
            $this->assertArrayHasKey($key, $providedArrayData);
        }
    }
}
