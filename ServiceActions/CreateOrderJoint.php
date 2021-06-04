<?php 
include_once __DIR__.'/BaseService.php';

class CreateOrderJoint extends BaseService {


    public
        $socialSecurityNumber_2,
        $firstName_2,
        $lastName_2,
        $middleName_2,
        $addressLine_2,
        $city_2,
        $stateCode_2,
        $countryCode_2,
        $postalCode_2;




    public function __construct($productServiceType)
    {
        parent::__construct($productServiceType, get_class());
    }


    public function createXMLRequest()
    {
        return $this->getXmlFile();
    }

}