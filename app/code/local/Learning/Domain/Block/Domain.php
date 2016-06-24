<?php

class Learning_Domain_Block_Domain extends Mage_Core_Block_Template
{
    /**
     * Déclaration du block
     * @return string
     */
    public function getDomains()
    {
        $domains = Mage::getModel('learning_domain/domain')
            ->getCollection()
            ->addIsActiveFilter();
        return $domains;
    }

    public function getAssociatedDomain()
    {
        $product_id = Mage::registry('current_product')->getId();
        $domainprod = Mage::getModel('learning_domain/domain_product')->load($product_id);
        $domain = Mage::getModel('learning_domain/domain')->load($domainprod->getId());
        return $domain->getDomainName();
    }
}