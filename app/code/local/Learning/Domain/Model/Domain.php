<?php

class Learning_Domain_Model_Domain extends Mage_Core_Model_Abstract
{

    /**
     * Name of object id field
     * Pour le getId : methode magique
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Magento class constructor
     */
    protected function _construct()
    {
        $this->_init('learning_domain/domain');
    }

}