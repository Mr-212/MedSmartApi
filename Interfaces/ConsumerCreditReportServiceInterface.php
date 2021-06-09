<?php


interface ConsumerCreditReportServiceInterface
{
    public function createOrder($socialSecurityNumber, $firstName, $lastName);
    public function refreshOrder($orderNo,$socialSecurityNumber,$firstName,$lastName);
    public function createOrderJoint($socialSecurityNumber, $socialSecurityNumber_2, $firstName, $firstName_2, $lastName, $lastName_2, $addressLine, $addressLine_2, $city, $city_2, $stateCode, $stateCode_2, $postalCode, $postalCode_2, $countryCode, $countryCode_2);
    public function refreshOrderJoint($orderNo,$socialSecurityNumber, $socialSecurityNumber_2, $firstName, $firstName_2, $lastName, $lastName_2);
}