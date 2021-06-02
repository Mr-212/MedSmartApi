<?php



class Config{
     
    private 
        $productServiceType, 
        $services;

    public function __construct($serviceType = null)
    {
        $this->productServiceType = $serviceType;
        $this->setServices();
    }


    private function getConfigPath(){
        return dirname(__FILE__).'/';
    }


    private function getConfigFile(){
        return  include "{$this->getConfigPath()}/{$this->productServiceType}.php";
    }
    


    private function setServices(){
        $this->services = include dirname(__FILE__).'/Services.php';
    }


    public function getServices(){
        return $this->services;
    }


    public function getServiceByType(){
        $service = null;
        if(array_key_exists( $this->productServiceType, $this->services)){
               $service = $this->getConfigFile();
        }
        return $service;
    }
}