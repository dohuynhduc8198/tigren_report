<?php
/**
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2019 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Bannermanager\Model\Banner\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Tigren\Bannermanager\Model\Banner;

/**
 * Class IsActive
 *
 * @package Tigren\Bannermanager\Model\Banner\Source
 */
class IsActive implements OptionSourceInterface
{
    /**
     * @var Banner
     */
    protected $_banner;

    /**
     * Constructor
     *
     * @param Banner $banner
     */
    public function __construct(Banner $banner)
    {
        $this->_banner = $banner;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->_banner->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
