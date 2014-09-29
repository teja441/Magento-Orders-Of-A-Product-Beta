<?php
 
class Misc_ProductCustomers_Block_Adminhtml_Tabs extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs
{
    private $parent;
 
    protected function _prepareLayout()
    {
        //get all existing tabs
        $this->parent = parent::_prepareLayout();
        //add new tab
        $this->addTab('tabid', array(
                     'label'     => Mage::helper('catalog')->__('New Tab'),
                     'content'   => $this->getLayout()
             ->createBlock('productcustomers/adminhtml_tabs_customerlist')->toHtml(),
        ));
        return $this->parent;
    }
}
