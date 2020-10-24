<?php

namespace Test\Banner\Model\System\Config;

use Magento\Framework\Option\ArrayInterface;

class Status implements ArrayInterface
{
    const ENABLED = 2;
    const DISABLED = 1;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            self::ENABLED => __('1.Enabled'),
            self::DISABLED => __('2.Disabled'),
        ];
        return $options;
    }

}

