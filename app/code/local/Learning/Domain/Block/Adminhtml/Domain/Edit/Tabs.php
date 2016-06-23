<?php

class Learning_Domain_Block_Adminhtml_Domain_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('domain_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('learning_domain')->__('Domain Information'));
    }

    public function _beforeToHtml()
    {
        $this->addTab('products', array(
                'label' => Mage::helper('learning_domain')->__('Associated products'),
            'url'   => $this->getUrl('*/*/products', array('_current' => true)),
            'class'    => 'ajax'
        ));

        return parent::_beforeToHtml();
    }
}