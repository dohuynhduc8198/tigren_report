<?php

namespace Test\Banner\Model\System\Config;

use Magento\Framework\Option\ArrayInterface;

class Display implements ArrayInterface
{
    const IMAGE = 1;
    const SLIDER = 2;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            self::IMAGE => __('1.Image'),
            self::SLIDER => __('2.Slider'),
        ];
        return $options;
    }

}

