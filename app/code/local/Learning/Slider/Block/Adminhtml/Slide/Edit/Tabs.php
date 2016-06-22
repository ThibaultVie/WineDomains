<?php

class Learning_Slider_Block_Adminhtml_Slide_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('slide_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('learning_slider')->__('Slide Information'));
    }
}