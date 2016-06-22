<?php

class Learning_Slider_Block_Adminhtml_Slide extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller     = 'adminhtml_slide';
        $this->_blockGroup     = 'learning_slider';
        $this->_headerText     = Mage::helper('learning_slider')->__('Manage Slides');
        $this->_addButtonLabel = Mage::helper('learning_slider')->__('Add Slide');
        parent::__construct();
    }
}