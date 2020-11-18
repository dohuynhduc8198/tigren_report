<?php

namespace Test\Banner\Model\System\Config;

use Magento\Framework\Option\ArrayInterface;

class Status implements ArrayInterface
{
    const ENABLED = 1;
    const DISABLED = 0;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            self::ENABLED => __('Enable'),
            self::DISABLED => __('Disable'),
        ];
        return $options;
    }

}

