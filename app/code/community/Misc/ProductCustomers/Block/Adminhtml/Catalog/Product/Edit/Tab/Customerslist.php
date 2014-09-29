<?php

class Misc_ProductCustomers_Block_Adminhtml_Catalog_Product_Edit_Tab_Customerslist extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Set grid params
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('custom_product_grid');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
   /*     if ($this->_getProduct()->getId()) {
            $this->setDefaultFilter(array('in_products' => 1));
        }*/

    }

  /**
     * Add filter
     *
     * @param object $column
     * @return Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Customerslist
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in product flag
        if ($column->getId() == 'in_products') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
            } else {
                if($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin' => $productIds));
                }
            }
        } else {
			
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
    /**
     * Retirve currently edited product model
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _getProduct()
    {
        return Mage::registry('current_product');
    }

    /**
     * Add filter
     *
     * @param object $column
     * @return Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Customerslist
     */

    /**
     * Prepare collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */

  protected function _getCollectionClass()
    {
        return 'sales/order_grid_collection';
    }

    protected function _prepareCollection()
    {
		$product=Mage::registry('current_product');
		$filter_orders=Mage::helper('misc_productcustomers')->getOrders($product->getId());
		Mage::log($filter_orders,3,'orders_id_products.log');
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $collection->addFieldToFilter('entity_id', array('in' =>array('in' => $filter_orders)));
		/* uncomment to add paytype to the collection and also uncomment the pay type in _prepareColumns() to display on the grid  */
		//$collection->join(array('payment'=>'sales/order_payment'),'main_table.entity_id=parent_id','method');

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('real_order_id', array(
            'header'=> Mage::helper('sales')->__('Order #'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'increment_id',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'    => Mage::helper('sales')->__('Purchased From (Store)'),
                'index'     => 'store_id',
                'type'      => 'store',
                'store_view'=> true,
                'display_deleted' => true,
            ));
        }

        $this->addColumn('created_at', array(
            'header' => Mage::helper('sales')->__('Purchased On'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));

        $this->addColumn('billing_name', array(
            'header' => Mage::helper('sales')->__('Bill to Name'),
            'index' => 'billing_name',
        ));

        $this->addColumn('shipping_name', array(
            'header' => Mage::helper('sales')->__('Ship to Name'),
            'index' => 'shipping_name',
        ));

        $this->addColumn('base_grand_total', array(
            'header' => Mage::helper('sales')->__('G.T. (Base)'),
            'index' => 'base_grand_total',
            'type'  => 'currency',
            'currency' => 'base_currency_code',
        ));

        $this->addColumn('grand_total', array(
            'header' => Mage::helper('sales')->__('G.T. (Purchased)'),
            'index' => 'grand_total',
            'type'  => 'currency',
            'currency' => 'order_currency_code',
        ));

		/*$this->addColumn('pay_type', array(
            'header'=> Mage::helper('sales')->__('Pay Type'),
            'width' => '80px',
            'type'  => 'options',
            'index' => 'method',
	//	    'filter'=>'false',
	    'options'=>array()  //add your payment types to the array 	
        ));*/
        
        $this->addColumn('status', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));

            
        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            $this->addColumn('action',
                array(
                    'header'    => Mage::helper('sales')->__('Action'),
                    'width'     => '50px',
                    'type'      => 'action',
                    'getter'     => 'getId',
                    'actions'   => array(
                        array(
                            'caption' => Mage::helper('sales')->__('View Customer'),
                            'url'     => array('base'=>'*/customer/edit'),
                            'field'   => 'customer_id',
                            'data-column' => 'action',
                        )
                    ),
					'target'=>'_blank',
                    'filter'    => false,
                    'sortable'  => false,
                    'index'     => 'customers',
                    'is_system' => true,
            ));
        }
//        $this->addRssList('rss/order/new', Mage::helper('sales')->__('New Order RSS'));

//        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
//        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    /**
     * Rerieve grid URL
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getData('grid_url')
            ? $this->getData('grid_url')
            : $this->getUrl('*/*/customerslistgrid', array('_current' => true));
    }

	public function getRowUrl($row)
    {
        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            return $this->getUrl('*/sales_order/view', array('order_id' => $row->getId()));
        }
        return false;
    }

	protected function _getSelectedCustomers()   // Used in grid to return selected customers values.
    {
        $customers = array_keys($this->getSelectedCustomers());
        return $customers;
    }
   /**
     * Retrieve custom products
     *
     * @return array
     */
    public function getProductOrders()
    {
        $products = array();
        foreach (Mage::registry('current_product')->getCustomProducts() as $product) {
            $products[$product->getId()] = array('position' => $product->getPosition());
        }
        return $products;
    }
}
