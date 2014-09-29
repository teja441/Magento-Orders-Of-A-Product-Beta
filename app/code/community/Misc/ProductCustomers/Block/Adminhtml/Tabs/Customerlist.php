<?php
 
class Misc_ProductCustomers_Block_Adminhtml_Tabs_Customerlist extends Mage_Adminhtml_Block_Widget
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('modulename/productcustomerslist.phtml');
    }
}
