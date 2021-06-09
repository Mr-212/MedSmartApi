<?php
include __DIR__.'/../Interfaces/ConsumerCreditReportServiceInterface.php';
include __DIR__.'/Service.php';
include __DIR__.'/../ServiceActions/CreateOrder.php';
include __DIR__.'/../ServiceActions/CreateOrderJoint.php';
include __DIR__.'/../ServiceActions/RefreshOrder.php';
include __DIR__.'/../ServiceActions/RefreshOrderJoint.php';

// include dirname(__FILE__).'/../Constants/ServiceTypeConstants.php';


class ConsumerCreditReport extends Service implements ConsumerCreditReportServiceInterface {

    
    public function __construct($coneectionObject)
    {
       parent::__construct($coneectionObject);
    }

    public function createOrder($socialSecurityNumber, $firstName, $lastName, $middleName = null, $nameSuffix=null,$addressLine= null, $city=null, $stateCode = null, $postalCode =null,$countryCode = null)
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


    public function createOrderJoint($socialSecurityNumber, $socialSecurityNumber_2, $firstName, $firstName_2, $lastName, $lastName_2, $addressLine, $addressLine_2, $city, $city_2, $stateCode, $stateCode_2, $postalCode, $postalCode_2, $countryCode, $countryCode_2){
        
        $order = new CreateOrderJoint(static::class);
        
        $order->socialSecurityNumber = "{$socialSecurityNumber}";
        $order->socialSecurityNumber_2 = "{$socialSecurityNumber_2}";

        $order->firstName = "{$firstName}";
        $order->firstName_2 = "{$firstName_2}";

        // $order->middleName = "{$middleName}";
        // $order->middleName_2 = "{$middleName_2}";

        $order->lastName = "{$lastName}";
        $order->lastName_2 = "{$lastName_2}";

        // $order->nameSuffix = "{$nameSuffix}";

        $order->addressLine ="{$addressLine}";
        $order->addressLine_2 ="{$addressLine_2}";

        $order->city = "{$city}";
        $order->city_2 = "{$city_2}";

        $order->postalCode = "{$postalCode}";
        $order->postalCode_2 = "{$postalCode_2}";

       
        $order->stateCode = "{$stateCode}";
        $order->stateCode_2 = "{$stateCode_2}";

        $order->countryCode = "{$countryCode}";
        $order->countryCode_2 = "{$$countryCode_2}";

        $xml = $order->createXmlRequest();  
        return $this->getResponse($xml,'POST');
    }


    public function refreshOrderJoint($orderNo,$socialSecurityNumber, $socialSecurityNumber_2, $firstName, $firstName_2, $lastName, $lastName_2)
    {
        $order = new RefreshOrderJoint(static::class);

        $order->orderNumber = $orderNo;
        $order->socialSecurityNumber = "{$socialSecurityNumber}";
        $order->socialSecurityNumber_2 = "{$socialSecurityNumber_2}";

        $order->firstName = "{$firstName}";
        $order->firstName_2 = "{$firstName_2}";

        $order->lastName = "{$lastName}";
        $order->lastName_2 = "{$lastName_2}";

        $xml = $order->createXmlRequest();  
        return $this->getResponse($xml,'POST');

    }

}


