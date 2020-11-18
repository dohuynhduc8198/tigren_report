<?php


namespace Test\Banner\Ui\Component\Listing\Column;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Test\Banner\Helper\Databanner;


class Thumbnail extends Column
{
    /**
     *
     */
    const NAME = 'image';

    /**
     * @var Databanner
     */
    protected $databanner;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Databanner $databanner
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        Databanner $databanner,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->databanner = $databanner;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     * @throws NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $banner = new DataObject($item);

                $item[$fieldName . '_src'] = $this->databanner->getImageUrl($banner->getImage());
                $item[$fieldName . '_alt'] = $banner->getBannerImage();
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    'list/banner/edit',
                    ['id' => $banner->getId()]
                );
                $item[$fieldName . '_orig_src'] = $this->databanner->getImageUrl($banner->getBannerImage());
            }
        }

        return $dataSource;
    }
}
