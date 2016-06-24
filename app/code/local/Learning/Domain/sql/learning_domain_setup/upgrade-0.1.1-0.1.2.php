<?php
$installer = $this;
$installer->startSetup();
$installer->getConnection()
    ->addColumn($installer->getTable('learning_domain/domain'), 'description', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'comment' => 'Sub title'
    ));
$installer->endSetup();