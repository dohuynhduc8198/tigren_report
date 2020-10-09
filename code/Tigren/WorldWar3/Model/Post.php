<?php
namespace Tigren\WorldWar3\Model;

class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'tigren_worldwar3_post';
    protected $_cacheTag = 'tigren_worldwar3_post';
    protected $_eventPrefix = 'tigren_worldwar3_post';
    protected function _construct()
    {
        $this->_init('Tigren\WorldWar3\Model\ResourceModel\Post');
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
