<?php
namespace Test\Banner\Model\Banner\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Test\Banner\Model\Banner;

class Status implements OptionSourceInterface
{
    /**
     * @var Banner
     */
    protected $banner;

    public function __construct(Banner $banner)
    {
        $this->banner = $banner;
    }

    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->banner->getStatus();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }

}
