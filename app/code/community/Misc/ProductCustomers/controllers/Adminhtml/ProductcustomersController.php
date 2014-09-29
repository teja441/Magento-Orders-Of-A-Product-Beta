<?php
 
require_once(Mage::getModuleDir('controllers','Mage_Adminhtml').DS.'Catalog'.DS.'ProductController.php');
 
class Misc_ProductCustomers_Adminhtml_ProductcustomersController extends Mage_Adminhtml_Catalog_ProductController
{
    /**
     * Get custom products grid and serializer block
     */
    public function customerslistAction()
    {
        $this->_initProduct();
        $this->loadLayout();
        $this->renderLayout();
    }
 
    /**
     * Get custom products grid
     */
    public function customerslistgridAction()
    {
        $this->_initProduct();
        $this->loadLayout();
        $this->renderLayout();
    }
     /**
     * Export customer grid to CSV format
     */
	public function exportCsvAction()
    {
        $fileName   = 'ordersbycustomer.csv';
        $content    = $this->getLayout()->createBlock('misc_productcustomers/adminhtml_catalog_product_edit_tab_customerslist')
            ->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Export customer grid to XML format
     */
    public function exportXmlAction()
    {
        $fileName   = 'ordersbycustomer.xml';
        $content    = $this->getLayout()->createBlock('misc_productcustomers/adminhtml_catalog_product_edit_tab_customerslist')
            ->getExcelFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }
}
