<?php
namespace App\Contracts;
interface PaymentService{
    public function createLinkPayment($client,$amount,$description, $options = []);
    public function makeReversePayment($paymentId);
    public function getPaymentById($paymentId);
}