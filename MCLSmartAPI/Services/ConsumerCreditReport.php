<?php
include dirname(__FILE__).'/../Interfaces/ConsumerCreditReportServiceInterface.php';
include dirname(__FILE__).'/../ServiceActions/CreateOrder.php';
include dirname(__FILE__).'/../ServiceActions/RefreshOrder.php';
include dirname(__FILE__).'/Service.php';
// include dirname(__FILE__).'/../Constants/ServiceTypeConstants.php';


class ConsumerCreditReport extends Service implements ConsumerCreditReportServiceInterface {

    
    public function __construct($coneectionObject)
    {
       parent::__construct($coneectionObject);
    }

    public function createOrder($socialSecurityNumber, $firstName, $lastName, $middleName = null, $nameSuffix=null,$addressLine= null, $city=null,$countryCode = null, $stateCode = null, $postalCode =null)
    {

        $order = new CreateOrder(static::class);
        $order->socialSecurityNumber = "{$socialSecurityNumber}";
        $order->firstName = "{$firstName}";
        $order->middleName = "{$middleName}";
        $order->lastName = "{$lastName}";
        $order->nameSuffix = "{$nameSuffix}";
        $order->addressLine ="{$addressLine}";
        $order->city = "{$city}";
        $order->postalCode = "{$postalCode}";
        $order->countryCode = "{$$countryCode}";
        $order->stateCode = "{$stateCode}";
        
        $xml = $order->createXmlRequest();  
        return $this->getResponse($xml,'POST');
       
    }


    public function refreshOrder($orderNo,$socialSecurityNumber,$firstName,$lastName)
    {
        $order = new RefreshOrder(static::class);
        $order->orderNumber = $orderNo;
        $order->socialSecurityNumber = "{$socialSecurityNumber}";
        $order->firstName = "{$firstName}";
        // $order->middleName = "{$middleName}";
        $order->lastName = "{$lastName}";
        $xml = $order->createXmlRequest();  

        $xml = $order->createXmlRequest();  
        return $this->getResponse($xml,'POST');
       
    }

}


