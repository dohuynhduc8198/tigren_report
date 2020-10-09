<?php
namespace Tigren\WorldWar3\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class UpgradeData implements UpgradeDataInterface {

    public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
        $setup->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        if(version_compare($context->getVersion(), '1.1.3') < 0)
        {

            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY, 'custom_new_product', [
                    'type' => 'int',
                    'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                    'frontend' => '',
                    'label' => 'Show as New Product',
                    'input' => 'boolean',
                    'group' => 'Product Details',
                    'class' => 'custom_attribute_name',
                    'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => true,
                    'user_defined' => true,
                    'default' => '1',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => true,
                    'unique' => false
                ]
            );
        }
        $setup->endSetup();
    }

}

