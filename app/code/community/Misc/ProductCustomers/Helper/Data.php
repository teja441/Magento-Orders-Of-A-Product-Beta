<?php
class Misc_ProductCustomers_Helper_Data extends Mage_Core_Helper_Abstract {

public function getOrders($id){
	
$tableName = Mage::getSingleton('core/resource')->getTableName('sales_flat_order_item');
$connection = Mage::getSingleton('core/resource')->getConnection('core_read');		
$query="select order_id from {$tableName} where product_id='{$id}'";
$resp= $connection->fetchAll($query); 


$orderid=array();
foreach($resp as $order_ids):

$orderid[].=$order_ids['order_id'];

endforeach;

return $orderid;
	}

}
