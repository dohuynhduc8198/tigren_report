<?php
namespace Tigren\HelloWorldAdmin\Model;

class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'tigren_helloworldadmin_post';
    protected $_cacheTag = 'tigren_helloworldadmin_post';
    protected $_eventPrefix = 'tigren_helloworldadmin_post';
    protected function _construct()
    {
        $this->_init('Tigren\HelloWorldAdmin\Model\ResourceModel\Post');
    }
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
