<?php

include_once __DIR__.'/BaseService.php';
class RefreshOrderJoint extends BaseService
{

    public
        $orderNumber,
        $socialSecurity_number_2,
        $lastName_2,
        $firstName_2;

    public function __construct($productServiceType)
    {
      parent::__construct($productServiceType, get_called_class());
   }

    public function createXMLRequest()
    {
       return $this->getXmlFile();
    }

}
