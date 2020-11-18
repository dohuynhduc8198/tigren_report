<?php

namespace Test\Banner\Model\Block\Source;

use Magento\Framework\Data\OptionSourceInterface;


class DisplayType implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['label' => '--Select type--', 'value' => ''],
            ['label' => __('All Images'), 'value' => 1],
            ['label' => __('Slider'), 'value' => 2],

        ];
    }
}
