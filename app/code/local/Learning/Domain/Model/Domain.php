<?php

class Learning_Domain_Model_Domain extends Mage_Core_Model_Abstract
{

    /**
     * Name of object id field
     * Pour le getId : methode magique
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    protected $_productInstance = null;

    /**
     * Magento class constructor
     */
    protected function _construct()
    {
        $this->_init('learning_domain/domain');
    }

    public function getProductInstance(){
        if (!$this->_productInstance) {
            $this->_productInstance = Mage::getSingleton('learning_domain/domain_product');
        }
        return $this->_productInstance;
    }

    protected function _afterSave() {
        $this->getProductInstance()->saveDomainRelation($this);
        return parent::_afterSave();
    }

    public function getSelectedProducts(){
        if (!$this->hasSelectedProducts()) {
            $products = array();
            foreach ($this->getSelectedProductsCollection() as $product) {
                $products[] = $product;
            }
            $this->setSelectedProducts($products);
        }
        return $this->getData('selected_products');
    }

    public function getSelectedProductsCollection(){
        $collection = $this->getProductInstance()->getProductCollection($this);
        return $collection;
    }
}