<?php

class Learning_Slider_Model_Resource_Slide extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Magento class constructor
     */
    protected function _construct()
    {
        $this->_init('learning_slider/slide', 'entity_id');
    }

}