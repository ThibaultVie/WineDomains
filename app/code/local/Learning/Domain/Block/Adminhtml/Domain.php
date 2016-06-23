<?php

class Learning_Domain_Block_Adminhtml_Domain extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller     = 'adminhtml_domain';
        $this->_blockGroup     = 'learning_domain';
        $this->_headerText     = Mage::helper('learning_domain')->__('Manage Domains');
        $this->_addButtonLabel = Mage::helper('learning_domain')->__('Add Domain');
        parent::__construct();
    }
}