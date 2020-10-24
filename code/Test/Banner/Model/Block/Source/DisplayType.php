<?php

namespace Test\Banner\Model\Block\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class DisplayType
 *
 * @package Tigren\Bannermanager\Model\Block\Source
 */
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
