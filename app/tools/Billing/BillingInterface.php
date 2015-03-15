<?php namespace tools\Billing;

interface BillingInterface  {

	public function charge(array $data);
}