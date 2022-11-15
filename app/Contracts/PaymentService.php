<?php
namespace App\Contracts;
interface PaymentService{
    public function createLinkPayment($client,$amount,$description);
    public function makeReversePayment($paymentId);
}