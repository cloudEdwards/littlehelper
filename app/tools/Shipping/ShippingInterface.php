<?php namespace tools\Shipping;

interface ShippingInterface  {

	public function getRates($zipCode, $quantity);
}