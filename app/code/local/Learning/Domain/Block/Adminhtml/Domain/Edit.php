<?php

class Learning_Domain_Block_Adminhtml_Domain_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->_objectId   = 'id';
        $this->_blockGroup = 'learning_domain';
        $this->_controller = 'adminhtml_domain';

        $this->_updateButton('save', 'label', Mage::helper('learning_domain')->__('Save Domain'));
        $this->_updateButton('delete', 'label', Mage::helper('learning_domain')->__('Delete Domain'));
        $this->_removeButton('reset');

        $this->_addButton('saveandcontinue', array(
            'label'   => Mage::helper('learning_domain')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class'   => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Get header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('domain_data') && Mage::registry('domain_data')->getId()) {
            return Mage::helper('learning_domain')->__("Edit Domain '%s'", Mage::registry('domain_data')->getName());
        } else {
            return Mage::helper('learning_domain')->__('Add Domain');
        }
    }
}