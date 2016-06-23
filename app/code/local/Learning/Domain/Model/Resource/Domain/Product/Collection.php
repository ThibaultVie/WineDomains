<?php
class Learning_Domain_Model_Resource_Domain_Product_Collection extends Mage_Catalog_Model_Resource_Product_Collection
{
    protected $_joinedFields = false;

    public function joinFields(){
        if (!$this->_joinedFields){
            $this->getSelect()->join(
                array('related' => $this->getTable('learning_domain/domain_product')),
                'related.product_id = e.entity_id',
                array('position')
            );
            $this->_joinedFields = true;
        }
        return $this;
    }

    public function addDomainFilter($domain){
        if ($domain instanceof Learning_Domain_Model_Domain){
            $domain = $domain->getId();
        }
        if (!$this->_joinedFields){
            $this->joinFields();
        }
        $this->getSelect()->where('related.domain_id = ?', $domain);
        return $this;
    }
}
