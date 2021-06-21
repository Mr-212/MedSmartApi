<?php

include __DIR__.'/../Concerns/XML/XMLReponseParser.php';

class Service {
    private 
        $connectionObject,
        $xmlParser,
        $orderObject;
    
    public function __construct($connection, $orderObject = null)
    {
        $this->connectionObject = $connection;
        $this->orderObject =  $orderObject;
    }

    public function getConnectionObject(){
        return $this->connectionObject;
    }


    public function getResponse($request = array(), $type = 'GET'){
         $resXML = $this->getConnectionObject()->curl_request($request, $type);
         $this->xmlParser = new XMLResponseParser($resXML);
         return $this->xmlParser->parse();

    }

   

}