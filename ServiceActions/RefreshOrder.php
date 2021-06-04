<?php

include_once __DIR__.'/BaseService.php';
class RefreshOrder extends BaseService
{

    public
        $orderNumber;

    public function __construct($productServiceType)
    {
      parent::__construct($productServiceType, get_called_class());
   }

    public function createXMLRequest()
    {
       return $this->getXmlFile();
    }

}
