<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once __DIR__.'/MCLSmartAPIConnection.php';
include_once __DIR__.'/Interfaces/BaseServiceInterface.php';
include_once __DIR__.'/Config/Config.php';

//services
include_once __DIR__.'/Services/ConsumerCreditReport.php';


// developed BY: Ali Raza

class MCLSmartAPI implements BaseServiceInterface {


    
    private 
        $connection,
        $config;

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



