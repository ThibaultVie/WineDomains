<?php

class Learning_Domain_Model_Resource_Domain extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Magento class constructor
     */
    protected function _construct()
    {
        $this->_init('learning_domain/domain', 'entity_id');
    }

    public function getInstanceByProductId(Learning_Domain_Model_Domain $entity, $id){
        $reader = $this->_getReadAdapter();
        $select = $reader->select()
            ->from($this->getMainTable())
            ->join($this->getTable('learning_domain/domain_product'),'entity_id = domain_id')
            ->where('product_id = ?', $id)
            ->limit(1);
        $data = $reader->fetchRow($select);
        if($data != null){
            $entity->setData($data);
        }
        return $this;
    }

}