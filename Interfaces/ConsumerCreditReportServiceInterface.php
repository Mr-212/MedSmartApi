<?php


interface ConsumerCreditReportServiceInterface
{
    public function createOrder($socialSecurityNumber, $firstName, $lastName);
    public function refreshOrder($orderNo,$socialSecurityNumber,$firstName,$lastName);    
}