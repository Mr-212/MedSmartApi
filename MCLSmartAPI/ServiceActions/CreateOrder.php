<?php 
include_once dirname(__FILE__).'/BaseService.php';

class CreateOrder extends BaseService {

    public function __construct($productServiceType)
    {
        parent::__construct($productServiceType, get_called_class());
    }


    public function createXMLRequest()
    {
        return $this->getXmlFile();
    }

}