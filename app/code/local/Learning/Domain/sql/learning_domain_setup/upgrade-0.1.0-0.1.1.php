<?php
$installer = $this;
$installer->startSetup();
$installer->getConnection()
    ->addColumn($installer->getTable('learning_domain/domain'), 'description', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'comment' => 'Sub title'
    ))
    ->newTable($installer->getTable('learning_domain/domain_product'))
    ->addColumn('rel_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Relation ID')
    ->addColumn('domain_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default' => '0',
    ), 'Domain ID')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default' => '0',
    ), 'Product ID')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false,
        'default' => '0',
    ), 'Position')
    ->addIndex($installer->getIdxName('learning_domain/domain_product', array('product_id')), array('product_id'))
    ->addForeignKey($installer->getFkName('learning_domain/domain_product', 'domain_id', 'learning_domain/domain', 'entity_id'), 'domain_id', $installer->getTable('learning_domain/domain'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('learning_domain/domain_product', 'product_id', 'catalog/product', 'entity_id'), 'product_id', $installer->getTable('catalog/product'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Domain to Product Linkage Table');

$installer->getConnection()->createTable($domainProductTable);
$installer->endSetup();