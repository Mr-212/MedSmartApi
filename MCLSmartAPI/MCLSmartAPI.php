<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once dirname(__FILE__).'/MCLSmartAPIConnection.php';
include_once dirname(__FILE__).'/Interfaces/BaseServiceInterface.php';
include_once dirname(__FILE__).'/Services/ConsumerCreditReport.php';
include_once dirname(__FILE__).'/Config/Config.php';

// developed BY: Ali Raza :raza_997@hotmail.com 

class MCLSmartAPI implements BaseServiceInterface {


    
    private $connection,$config;

    public function __construct($user, $password, $url){
        $this->connection = new MCLSmartAPIConnection($user, $password, $url);
        $this->config =  new Config();
    }

    public function getConsumeCreditrReportService() {
        return new ConsumerCreditReport($this->connection);
    }


    public function getServicesList(){
         return $this->config->getServices();
    }
}



