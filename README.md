Magento-Orders-Of-A-Product-Beta
========================================================

DESCRIPTION

Orders Of A Product displayed in a custom tab in the manage products page

![Screenshot](http://i.imgur.com/DUFpZfF.png)

![Screenshot](http://i.imgur.com/g0PHPH2.png)

![Screenshot](http://i.imgur.com/Jv29fCX.png)
========================================================================

How it Works?

<adminhtml_catalog_product_edit>
        <reference name="product_tabs">
            <action method="addTab">
                <name>custom</name>
                <block>misc_productcustomers/adminhtml_catalog_product_edit_tab</block>
            </action>
        </reference>
</adminhtml_catalog_product_edit>

The above part in the admin layout calls for the block when ever a adminhtml_catalog_product_edit is triggered
which creates a custom tab at the products management page by the name 'Orders By Customers'
    
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

when the tab is selected the tab action loads the layout

public function customerslistAction()
    {
        $this->_initProduct();
        $this->loadLayout();
        $this->renderLayout();
    }

the layout part which loads the order grid block

A breif explanation is found here about serializing grids in admin tabs

http://excellencemagentoblog.com/magento-grid-serializer-admin-tabs-grid

============

