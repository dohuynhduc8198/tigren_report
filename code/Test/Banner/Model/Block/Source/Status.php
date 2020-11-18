<?php
namespace Test\Banner\Model\Block\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Test\Banner\Model\Block;

class Status implements OptionSourceInterface
{
    /**
     * @var Block
     */
    protected $block;

    public function __construct(Block $block)
    {
        $this->block = $block;
    }

    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->block->getStatus();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }

}
