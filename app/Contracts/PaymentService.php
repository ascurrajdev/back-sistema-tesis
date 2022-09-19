<?php
namespace App\Contracts;
interface PaymentService{
    public function createLinkPayment($amount,$description);
    public function makeReversePayment($paymentId);
}