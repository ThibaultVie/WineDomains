<?php

/**
 * Algolia custom sort order field
 */
class Algolia_Algoliasearch_Block_System_Config_Form_Field_Custompages extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    protected $selectFields = array();

    /**
     * Creates and populates a select block to represent each column in the configuration property.
     *
     * @param $columnId String The name of the column defined in addColumn
     * @return Algolia_Algoliasearch_Block_System_Config_Form_Field_Select
     * @throws Exception
     */
    protected function getRenderer($columnId) {
        if (!array_key_exists($columnId, $this->selectFields) || !$this->selectFields[$columnId]) {
            $aOptions = array();
            switch($columnId) {
                case 'pages': // Populate the attribute column with a list of searchable attributes
                    $magento_pages = Mage::getModel('cms/page')->getCollection()->addFieldToFilter('is_active',1);

                    $ids = $magento_pages->toOptionArray();

                    foreach ($ids as $id)
                        $aOptions[$id['value']] = $id['value'];

                    break;
                default:
                    throw new Exception('Unknown attribute id ' . $columnId);
            }

            $selectField = Mage::app()->getLayout()->createBlock('algoliasearch/system_config_form_field_select')->setIsRenderToJsTemplate(true);
            $selectField->setOptions($aOptions);
            $selectField->setExtraParams('style="width:160px;"');
            $this->selectFields[$columnId] = $selectField;
        }

        return $this->selectFields[$columnId];
    }

    public function __construct()
    {
        $this->addColumn('pages', array(
            'label' => Mage::helper('adminhtml')->__('Pages'),
            'renderer'=> $this->getRenderer('pages'),
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add Excluded Page');
        parent::__construct();
    }

    protected function _prepareArrayRow(Varien_Object $row)
    {
        $row->setData(
            'option_extra_attr_' . $this->getRenderer('pages')->calcOptionHash(
                $row->getPages()),
            'selected="selected"'
        );
    }
}
