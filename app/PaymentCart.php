<?php

namespace App;

class PaymentCart
{
    public $payments;
    public $paymentsQuantity;
    public $totalAmount;

    public function __construct($prevPayment)
    {
        
        if($prevPayment != null) {

            $this->payments = $prevPayment->payments;
            $this->paymentsQuantity = $prevPayment->paymentsQuantity;
            $this->totalAmount = $prevPayment->totalAmount;

        }else{

            $this->payments =[];
            $this->paymentsQuantity = 0;
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
