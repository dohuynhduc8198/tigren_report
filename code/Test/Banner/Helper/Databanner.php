<?php

namespace Test\Banner\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;


class Databanner extends AbstractHelper
{
    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $_backendUrl;


    /**
     * @var Filesystem
     */
    protected $_fileSystem;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param Context $context
     * @param \Magento\Backend\Model\UrlInterface $backendUrl
     */
    public function __construct(
        Context $context,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        StoreManagerInterface $storeManager,
        Filesystem $fileSystem
    )
    {
        parent::__construct($context);
        $this->_fileSystem = $fileSystem;
        $this->_backendUrl = $backendUrl;
        $this->_storeManager = $storeManager;
    }

    /**
     * get products tab Url in admin
     * @return string
     */
    public function getBlockGridUrl()
    {
        return $this->_backendUrl->getUrl('list/banner/blockselect', ['_current' => true]);
    }

    /**
     * @param  $image
     * @return string
     * @throws NoSuchEntityException
     */
    public function getImageUrl($image)
    {
        $path = $this->_fileSystem->getDirectoryRead(
            DirectoryList::MEDIA
        )->getAbsolutePath(
            'test/banner/'
        );
        if (file_exists($path . $image)) {
            $path = $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            return $path . 'test/banner/' . $image;
        } else {
            return '';
        }
    }
}
