<?php

class Learning_Slider_Block_Slider extends Mage_Core_Block_Template
{
    public function getSlides()
    {
        $slides = Mage::getModel('learning_slider/slide')
            ->getCollection()
            ->addIsActiveFilter()
            ->addOrderByPosition();
        return $slides;
    }
}