<?php

class Learning_Slider_Block_Adminhtml_Slide_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('slide_form', array('legend' => Mage::helper('learning_slider')->__('Slide information')));

        $fieldset->addType('image', 'Learning_Slider_Block_Adminhtml_Form_Renderer_Image');

        $fieldset->addField('name', 'text', array(
            'label'    => Mage::helper('learning_slider')->__('Name'),
            'name'     => 'name',
            'class'    => 'required-entry',
            'required' => true
        ));

        $fieldset->addField('image_url', 'image', array(
            'label'     => Mage::helper('learning_slider')->__('Image'),
            'required'  => false,
            'name'      => 'image_url',
            'directory' => 'slide/'
        ));

        $fieldset->addField('is_active', 'select', array(
            'label'    => Mage::helper('learning_slider')->__('Status'),
            'name'     => 'is_active',
            'class'    => 'required-entry',
            'values'   => Mage::getSingleton('adminhtml/system_config_source_enabledisable')->toOptionArray(),
            'required' => true
        ));

        $fieldset->addField('position', 'text', array(
            'label'    => Mage::helper('learning_slider')->__('Position'),
            'class'    => 'validate-number',
            'name'     => 'position',
            'required' => true,
            'value'    => 0
        ));

        if (Mage::getSingleton('adminhtml/session')->getSlideData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSlideData());
            Mage::getSingleton('adminhtml/session')->getSlideData(null);
        } elseif (Mage::registry('slide_data')) {
            $form->setValues(Mage::registry('slide_data')->getData());
        }

        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return Mage::helper('learning_slider')->__('Slide Information');
    }

    public function getTabTitle()
    {
        return Mage::helper('learning_slider')->__('Slide Information');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}