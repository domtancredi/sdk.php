<?php

class GCOrders {
	
	public $orders;
	
	public function __construct($consumer_orders) 
	{
		$this->orders = $consumer_orders->data;
	}	
	
	public function get_order_item($id, $item)
	{
		return $this->orders[$id]->$item;
	}
	
	public function get_order_details_item($id, $order_id, $item)
	{
		return $this->orders[$id]->orderDetails[$order_id]->$item;
	}
	
	public function get_voucher_item($id, $order_id, $voucher_id, $item)
	{
		return $this->orders[$id]->orderDetails[$order_id]->vouchers[$voucher_id]->$item;
	}
	
	public function order_count()
	{
		return count($this->orders);
	}
	
	public function details_count($i)
	{
		return count($this->orders[$i]->orderDetails);
	}
	
	public function voucher_count($i, $j)
	{
		return count($this->orders[$i]->orderDetails[$j]->vouchers);
	}
	
	public function dump()
	{
		echo "<pre>";	
		var_dump($this->orders);
		echo "</pre>";
		die();
	}
	
}
