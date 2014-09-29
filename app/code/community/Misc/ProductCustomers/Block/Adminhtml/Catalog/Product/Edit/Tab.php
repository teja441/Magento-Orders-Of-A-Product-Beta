<?php
 
class Misc_ProductCustomers_Block_Adminhtml_Catalog_Product_Edit_Tab
extends Mage_Adminhtml_Block_Widget
implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
	
	/*public function __construct()
    {
   //     $this->setTemplate('misc/test.phtml');
     }*/
    
    public function canShowTab() 
    {
        return true;
    }
 
    public function getTabLabel() 
    {
        return $this->__('Orders By Customers');
    }
 
    public function getTabTitle()        
    {
        return $this->__('Orders By Customers');
    }
 
    public function isHidden()
    {
        return false;
    }
 
    public function getTabUrl() 
    {
        return $this->getUrl('adminhtml/productcustomers/customerslist', array('_current' => true));
    }
 
    public function getTabClass()
    {
        return 'ajax';
    }
 
}
