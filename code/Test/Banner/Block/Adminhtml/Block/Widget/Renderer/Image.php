<?php

namespace Test\Banner\Block\Adminhtml\Block\Widget\Renderer;

use Magento\Backend\Block\Context;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;


class Image extends AbstractRenderer
{
    /**
     * @var StoreManagerInterface
     */
    private $_storeManager;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storemanager
     * @param array $data
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storemanager,
        array $data = []
    )
    {
        $this->_storeManager = $storemanager;
        parent::__construct($context, $data);
        $this->_authorization = $context->getAuthorization();
    }

    /**
     * Renders grid column
     *
     * @param DataObject $row
     * @return string
     * @throws NoSuchEntityException
     */
    public function render(DataObject $row)
    {
        $mediaDirectory = $this->_storeManager->getStore()->getBaseUrl(
            UrlInterface::URL_TYPE_MEDIA
        );
        $imageUrl = $mediaDirectory . '/test/banner/' . $this->_getValue($row);
        return '<img src="' . $imageUrl . '" width="100px"/>';
    }
}
