<?php

include_once __DIR__.'/XMLReponseParser.php';

class Service {
    private 
        $connectionObject,
        $xmlParser;
    
    public function __construct($connection)
    {
        $this->connectionObject = $connection;
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