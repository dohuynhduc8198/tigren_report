<?php

namespace Test\Banner\Model\System\Config;

use Magento\Framework\Option\ArrayInterface;

class Position implements ArrayInterface
{
    const sidebar_main_top = 1;
    const sidebar_main_bottom = 2;
    const sidebar_additional_top = 3;
    const sidebar_additional_bottom = 4;
    const content_top = 5;
    const page_bottom = 6;


    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            self::sidebar_main_top => __('1.Sidebar main top '),
            self::sidebar_main_bottom => __('2.Sidebar main bottom'),
            self::sidebar_additional_top => __('3.Sidebar additional top'),
            self::sidebar_additional_bottom => __('4.Sidebar additional bottom'),
            self::content_top => __('5.Content top'),
            self::page_bottom => __('6.Page bottom'),
        ];
        return $options;
    }

}

