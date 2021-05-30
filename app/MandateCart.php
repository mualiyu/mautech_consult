<?php

namespace App;

class MandateCart
{
    public $voucher;
    public $vouchersQuantity;
    public $totalAmount;

    public function __construct($prevVoucher)
    {
        
        if($prevVoucher != null) {

            $this->vouchers = $prevVoucher->vouchers;
            $this->vouchersQuantity = $prevVoucher->vouchersQuantity;
            $this->totalAmount = $prevVoucher->totalAmount;

        }else{

            $this->voucher =[];
            $this->couchersQuantity = 0;
            $this->totalAmount = 0;

        }
    }

    public function addToPayment($id, $product)
    {
        $price = $product['amount'];
        //$price = gettype($price);

        if(array_key_exists($id, $this->payments) ) {
            $productToAdd = $this->payments[$id];
            $productToAdd["quantity"] = $productToAdd["quantity"] + 1;
        }else{
            $productToAdd = ["quantity"=> 1, "data" => $product];
        }
    
        $this->payments[$id] = $productToAdd;
        $this->paymentsQuantity = $this->paymentsQuantity + 1;
        $this->totalAmount = $this->totalAmount + $price;
    }

    public function deleteFromSingleCart($id, $product)
    {
        $price = $product['amount'];
        //$price = gettype($price);

        if(array_key_exists($id, $this->payments)) {
            $productToAdd = $this->payments[$id];
            $productToAdd["quantity"] = $productToAdd["quantity"] - 1;
        }
    
        $this->payments[$id] = $productToAdd;
        $this->paymentsQuantity = $this->paymentsQuantity - 1;
        $this->totalAmount = $this->totalAmount - $price;
    }

    public function updateTotalAmount()
    {
        $paymentsQuantity = 0;
        $totalAmount = 0;

        foreach ($this->payments as $payment) {
            $totalAmount = $totalAmount + $payment['data']['amount'];
            $paymentsQuantity = $paymentsQuantity + $payment['quantity'];
        }

        $this->totalAmount = $totalAmount;
        $this->paymentsQuantity = $paymentsQuantity;

    }
 
   

}
