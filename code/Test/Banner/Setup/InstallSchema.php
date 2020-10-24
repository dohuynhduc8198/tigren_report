<?php

namespace Test\Banner\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;


class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

//         CREATE TABLE BLOCK

        if (!$installer->tableExists('test_banner_block')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable("test_banner_block")
            )->addColumn(
                'block_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                ],
                'block id'
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable => false'],
                'block Name'
            )->addColumn(
                'position',
                Table::TYPE_INTEGER,
                255,
                [
                    'nullable' => false,
                    'default' => '0'
                ],
                'block position'
            )->addColumn(
                'display_type',
                Table::TYPE_TEXT,
                255,
                ['nullable => false'],
                'block display'
            )->addColumn(
                'from',
                Table::TYPE_DATE,
                null,
                ['nullable' => true, 'default' => null],
                'From'
            )->addColumn(
                'to',
                Table::TYPE_DATE,
                null,
                ['nullable' => true, 'default' => null],
                'To'
            )->addColumn(
                'sort',
                Table::TYPE_INTEGER,
                255,
                ['default' => '0'],
                'block sort'
            )->addColumn(
                'status',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '0'],
                'block status'
            )->addColumn('created_at', Table::TYPE_TIMESTAMP, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT], 'Block Created At')
                ->addColumn('updated_at', Table::TYPE_TIMESTAMP, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE], 'Block Updated At')
                ->addIndex(
                    $installer->getIdxName('test_banner_block', ['block_id', 'name'],
                        AdapterInterface::INDEX_TYPE_FULLTEXT
                    ),
                    ['block_id', 'name'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                )->setComment('Block Table');

            $installer->getConnection()->createTable($table);
        }
//            CREATE TABLE BANNER

        if (!$installer->tableExists('test_banner_banner')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('test_banner_banner')
            )->addColumn(
                'banner_id',
                Table::TYPE_INTEGER,
                null, [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
                'Banner ID'
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'banner name'
            )->addColumn(
                'image',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'banner image'
            )->addColumn(
                'url',
                Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'banner url'
            )->addColumn(
                'from',
                Table::TYPE_DATE,
                null,
                ['nullable' => true, 'default' => null],
                'From'
            )->addColumn(
                'to',
                Table::TYPE_DATE,
                null,
                ['nullable' => true, 'default' => null],
                'to'
            )->addColumn('created_at', Table::TYPE_TIMESTAMP, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT], 'Block Created At'
            )->addColumn('updated_at', Table::TYPE_TIMESTAMP, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE], 'Block Updated At'
            )->addColumn(
                'sort',
                Table::TYPE_INTEGER,
                255,
                ['default' => '0'],
                'banner sort'
            )->addColumn(
                'status',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '0'],
                'banner status'
            )->addIndex(
                $installer->getIdxName('test_banner_banner', ['banner_id', 'name'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['banner_id', 'name'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            )->setComment('Banner Table');
            $installer->getConnection()->createTable($table);
        }

//        CREATE TABLE BANNER ID + BLOCK ID

        if (!$installer->tableExists('test_banner_id_block_banner')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('test_banner_id_block_banner')
                )->addColumn(
                    'block_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                        'primary' => true
                    ],
                    'block id'
                )->addColumn(
                    'banner_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                        'primary' => true
                    ],
                    'banner id'
                )->addForeignKey(
                    $installer->getFkName(
                        'test_banner_id_block_banner',
                        'block_id',
                        'test_banner_block',
                        'block_id'
                    ),
                    'block_id',
                    $installer->getTable('test_banner_block'),
                    'block_id',
                    Table::ACTION_CASCADE
                )->addForeignKey(
                    $installer->getFkName(
                        'test_banner_id_block_banner',
                        'banner_id',
                        'test_banner_banner',
                        'banner_id'
                    ),
                    'banner_id',
                    $installer->getTable('test_banner_banner'),
                    'banner_id',
                    Table::ACTION_CASCADE
                )->addIndex(
                    $installer->getIdxName(
                        'test_banner_id_block_banner',
                        [
                            'block_id',
                            'banner_id'
                        ],
                        AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    [
                        'block_id',
                        'banner_id'
                    ],
                    [
                        'type' => AdapterInterface::INDEX_TYPE_UNIQUE

                    ]
                )->setComment('Block to Banner link table');
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
