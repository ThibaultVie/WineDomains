<?php
class Learning_Domain_Model_Domain_Product extends Mage_Core_Model_Abstract
{

    protected function _construct(){
        $this->_init('learning_domain/domain_product');
    }

    public function saveDomainRelation($domain){
    $data = $domain->getProductsData();
        if (!is_null($data)) {
            $this->_getResource()->saveDomainRelation($domain, $data);
        }
        return $this;
    }

    public function getProductCollection($domain){
        $collection = Mage::getResourceModel('learning_domain/domain_product_collection')
            ->addDomainFilter($domain);
        return $collection;
    }
}