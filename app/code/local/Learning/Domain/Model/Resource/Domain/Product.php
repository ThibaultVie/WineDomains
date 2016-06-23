<?php
class Learning_Domain_Model_Resource_Domain_Product extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function  _construct(){
        $this->_init('learning_domain/domain_product', 'rel_id');
    }

    public function saveDomainRelation($domain, $data){
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('domain_id=?', $domain->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $productId => $info) {
            $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                'domain_id'      => $domain->getId(),
                'product_id'     => $productId,
                'position'      => @$info['position']
            ));
        }
        return $this;
    }
}