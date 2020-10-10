<?php
namespace Tigren\WorldWar3\Plugin;

class NewProductFlag
{
    protected $request;

    public function __construct(\Magento\Framework\App\RequestInterface $request)
    {
        $this->request = $request;
    }

    public function afterGetName(\Magento\Catalog\Api\Data\ProductInterface $subject, $result)
    {
        $page = ['catalog_product_view', 'catalog_category_view'];

        if (in_array($this->request->getFullActionName(), $page))
        {
            $new_att = $subject->getCustomNewProduct();
            if ($new_att==1)
            {
                return __('[ NEW ] ').$result;
            }
            else
            {
                return __('').$result;
            }
        }
        return $result;
    }
}
