<?php

class Learning_Domain_Adminhtml_Domain_DomainController extends Mage_Adminhtml_Controller_Action
{

    /**
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction()
    {
        return $this->loadLayout()->_setActiveMenu('learning_domain');
    }

    /**
     * @return Mage_Core_Controller_Varien_Action
     */
    public function indexAction()
    {
        return $this->_initAction()->renderLayout();
    }

    /**
     * @return $this
     */
    public function newAction()
    {
        $this->_forward('edit');

        return $this;
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var Learning_Slider_Model_Slide $slide */
        $domain = Mage::getModel('learning_domain/domain')->load($id);

        if ($domain->getId() || $id == 0) {

            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $domain->setData($data);
            }
            Mage::register('domain_data', $domain);

            return $this->_initAction()->renderLayout();
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('learning_domain')->__('Domain does not exist'));

        return $this->_redirect('*/*/');
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {

            $delete = (!isset($data['image_url']['delete']) || $data['image_url']['delete'] != '1') ? false : true;
            $data['image_url'] = $this->_saveImage('image_url', $delete);

            /** @var Learning_Slider_Model_Slide $domain */
            $domain = Mage::getModel('learning_domain/domain');

            if ($id = $this->getRequest()->getParam('id')) {
                $domain->load($id);
            }

            try {
                $domain->addData($data);
                $products = $this->getRequest()->getPost('products', -1);
                if ($products != -1) {
                    $domain->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
                }
                $domain->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('learning_domain')->__('The domain has been saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array(
                        'id'       => $domain->getId(),
                        '_current' => true
                    ));

                    return;
                }

                $this->_redirect('*/*/');

                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $this->_getSession()->addException($e, Mage::helper('learning_domain')->__('An error occurred while saving the domain.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array(
                'id' => $this->getRequest()->getParam('id')
            ));

            return;
        }
        $this->_redirect('*/*/');
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                /** @var Learning_Slider_Model_Slide $domain */
                $domain = Mage::getModel('learning_domain/domain');
                $domain->load($id)->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('learning_domain')->__('Domain was successfully deleted'));
                $this->_redirect('*/*/');

                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));

                return;
            }
        }

        return $this->_redirect('*/*/');
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function massDeleteAction()
    {
        $domainIds = $this->getRequest()->getParam('domain');
        if (!is_array($domainIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('learning_domain')->__('Please select domain(s)'));
        } else {
            try {
                foreach ($domainIds as $domain) {
                    Mage::getModel('learning_domain/domain')->load($domain)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('learning_domain')->__('Total of %d domain(s) were successfully deleted', count($domainIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        return $this->_redirect('*/*/index');
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function massStatusAction()
    {
        $domainIds = $this->getRequest()->getParam('domain');
        if (!is_array($domainIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select domain(s)'));
        } else {
            try {
                foreach ($domainIds as $domain) {
                    Mage::getSingleton('learning_domain/domain')->load($domain)->setIsActive($this->getRequest()->getParam('is_active'))->setIsMassupdate(true)->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('learning_domain')->__('Total of %d domain(s) were successfully updated', count($domainIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        return $this->_redirect('*/*/index');
    }

    /**
     *
     */
    protected function _saveImage($imageAttr, $delete)
    {
        if ($delete) {
            $image = '';
        } elseif (isset($_FILES[$imageAttr]['name']) && $_FILES[$imageAttr]['name'] != '') {
            try {
                $uploader = new Varien_File_Uploader($imageAttr);
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'png'));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $path = Mage::getBaseDir('media') . DS . 'domain' . DS;
                $uploader->save($path, $_FILES[$imageAttr]['name']);
                $image = $_FILES[$imageAttr]['name'];
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                return $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        } else {
            $model = Mage::getModel('learning_domain/domain')->load((int)$this->getRequest()->getParam('id'));
            $image = $model->getData($imageAttr);
        }
        return $image;
    }

    public function productsAction(){
        $this->_initDomain(); //if you don't have such a method then replace it with something that will get you the entity you are editing.
        $this->loadLayout();
        $this->getLayout()->getBlock('domain.edit.tab.product')
            ->setDomainProducts($this->getRequest()->getPost('domain_products', null));
        $this->renderLayout();
    }

    /**
     *
     */
    public function productsgridAction(){
        $this->_initDomain();
        $this->loadLayout();
        $this->getLayout()->getBlock('domain.edit.tab.product')
            ->setDomainProducts($this->getRequest()->getPost('domain_products', null));
        $this->renderLayout();
    }

    /**
     * @param string $param
     * @return Mage_Core_Model_Abstract
     * @throws Mage_Core_Exception
     */
    public function _initDomain($param = 'id'){
        $domainEntity = Mage::getModel('learning_domain/domain');
        if ($entityId = $this->getRequest()->getParam($param)) {
            $domain = $domainEntity->load($entityId);
            if (!$domainEntity->getId()) {
                Mage::throwException($this->__('Wrong domain'));
            }
        }
        Mage::register('domain_data', $domain);
        return $domain;
    }

}