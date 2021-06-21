<?php

include_once __DIR__.'/../Constants/OrderTypeConstants.php';
include_once __DIR__.'/../Config/Config.php';

abstract class BaseService {
    private $productServiceType, $xmlRequestFileDir,$orderType, $config;
    public 
        $requestActionType,
        $firstName, 
        $lastName, 
        $middleName,
        $nameSuffix, 
        $addressLine,
        $city,
        $postalCode,
        $stateCode,
        $countryCode,
        $socialSecurityNumber,
       
        $enableExperianReport ,
        $enableEquifaxReport,
        $enableTransUnionReport,
        $enablePdfFormat ,
        $enableXmlFormat ,
        $enableHtmlFormat ;

    public function __construct($productServiceType, $orderType)
    {  
        $this->productServiceType = $productServiceType;
        $this->orderType =  $orderType;
        $this->setXmlRequestFileDir(dirname(__FILE__)."/../XMLRequests");
        $this->config = new Config($productServiceType);
        $this->resolveConfigServices();
        
        
    }

    public function getXmlRequestFileDir(){
        return  $this->xmlRequestFileDir;
    }

    private function getConfigPath(){
        return dirname(__FILE__).'/../Config';
    }
    

    public function setXmlRequestFileDir($path){
        $this->xmlRequestFileDir = $path;
    }
     
    public function getXmlFile(){
        return include "{$this->getXmlRequestFileDir()}/{$this->getProductServiceType()}/{$this->orderType}.php";
    }



    public function getProductServiceType(){
        return  $this->productServiceType;
    }

    

    private function getConfigFile(){
        return $this->config->getServiceByType();
    }

    private function resolveConfigServices(){
        $configFile = $this->getConfigFile();
        

        if(isset($configFile)){
            if(isset($configFile['services'])){
                    $this->enableExperianReport   = $configFile['services']['Experian'];
                    $this->enableEquifaxReport    = $configFile['services']['Equifax'];
                    $this->enableTransUnionReport = $configFile['services']['TransUnion'];
            }
            if(isset($configFile['responseType'])){
                    $this->enableXmlFormat    = $configFile['responseType']['xml'];
                    $this->enableHtmlFormat   = $configFile['responseType']['html'];
                    $this->enablePdfFormat    = $configFile['responseType']['pdf'];
            }
        
        }

   }

    public function getCreditRepositoryBlock(){
        $xml ='';
        if($this->enableEquifaxReport)
            $xml.='<CreditRepositoryIncludedEquifaxIndicator>true</CreditRepositoryIncludedEquifaxIndicator>';
        if($this->enableExperianReport)
            $xml.='<CreditRepositoryIncludedExperianIndicator>true</CreditRepositoryIncludedExperianIndicator>';
        if($this->enableTransUnionReport)
            $xml.='<CreditRepositoryIncludedTransUnionIndicator>true</CreditRepositoryIncludedTransUnionIndicator>';
       
        $xml.='<EXTENSION>
            <OTHER>
                <p3:RequestEquifaxScore>true</p3:RequestEquifaxScore>
                <p3:RequestExperianFraud>true</p3:RequestExperianFraud>
                <p3:RequestExperianScore>true</p3:RequestExperianScore>
                <p3:RequestTransUnionFraud>true</p3:RequestTransUnionFraud>
                <p3:RequestTransUnionScore>true</p3:RequestTransUnionScore>
            </OTHER>
        </EXTENSION>';
        

        return $xml;
    }


    public function getPrefferedServiceFormatBlock(){
        $xml = '';
            if($this->enableXmlFormat){
                $xml.='<p3:SERVICE_PREFERRED_RESPONSE_FORMAT>
                        <p3:SERVICE_PREFERRED_RESPONSE_FORMAT_DETAIL>
                            <p3:PreferredResponseFormatType>Xml</p3:PreferredResponseFormatType>
                        </p3:SERVICE_PREFERRED_RESPONSE_FORMAT_DETAIL>
                    </p3:SERVICE_PREFERRED_RESPONSE_FORMAT>';
            }
            if($this->enableHtmlFormat){
                $xml.='<p3:SERVICE_PREFERRED_RESPONSE_FORMAT>
                    <p3:SERVICE_PREFERRED_RESPONSE_FORMAT_DETAIL>
                        <p3:PreferredResponseFormatType>Html</p3:PreferredResponseFormatType>
                    </p3:SERVICE_PREFERRED_RESPONSE_FORMAT_DETAIL>
                </p3:SERVICE_PREFERRED_RESPONSE_FORMAT>';
            }
            if($this->enablePdfFormat){
                $xml.='<p3:SERVICE_PREFERRED_RESPONSE_FORMAT>
                    <p3:SERVICE_PREFERRED_RESPONSE_FORMAT_DETAIL>
                        <p3:PreferredResponseFormatType>Pdf</p3:PreferredResponseFormatType>
                    </p3:SERVICE_PREFERRED_RESPONSE_FORMAT_DETAIL>
                </p3:SERVICE_PREFERRED_RESPONSE_FORMAT>';
            }
        return $xml;
    }


    
    abstract function createXMLRequest();
    
}