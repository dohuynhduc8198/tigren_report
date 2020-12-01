<?php
/**
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2019 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Bannermanager\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.1.0', '<')) {
            $setup->getConnection();
            $setup->getConnection()->addColumn(
                $setup->getTable('tigren_bannermanager_block'),
                'min_images',
                [
                    'type' => Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '1',
                    'comment' => 'Min Images'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('tigren_bannermanager_block'),
                'max_images',
                [
                    'type' => Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '1',
                    'comment' => 'Max Images'
                ]
            );
        }
        if (version_compare($context->getVersion(), '1.1.4', '<')) {
            $setup->getConnection();
            $setup->getConnection()->addColumn(
                $setup->getTable('tigren_bannermanager_block_banner_entity'),
                'position',
                [
                    'type' => Table::TYPE_INTEGER,
                    'comment' => 'Position'
                ]
            );
        }
        $setup->endSetup();
    }
}
