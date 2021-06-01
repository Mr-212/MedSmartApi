<?php


class XMLResponseParser {
    
    private $xml;
    public $array = array(
        'error' => true,
        'StatusCode'=> null,
        'StatusDescription'=>null,
        'ProductService' => null,
         'OrderID' => null,
         'FileContent' => null,
         'FileType' => null,
    );
  
    public function __construct($xmlResponse)
    {
        $xmlResponse = preg_replace('/(xmlns|xsi)[^=]*="[^"]*" ?/i', '', $xmlResponse);
        $this->xml =  new SimpleXMLElement($xmlResponse);
        //ini_set('display_errors', 1);

    }


    public function parse(){

         $this->getRequestLeveError();
         $this->getProductLevelError();
         $this->getOrderStatus();
         $this->getServiceType();
         $this->getOrderID();
         $this->getFile();

         return $this->array;

    }


    private function getRequestLeveError(){
        $node = $this->xml->xpath('//DEAL_SET_SERVICES/DEAL_SET_SERVICE/ERRORS/ERROR/ERROR_MESSAGES/ERROR_MESSAGE');
        if($node && !empty($node)){
            $this->array['error'] =  true;
            $this->array['StatusCode'] = @(string) $node[0]->ErrorMessageCategoryCode;
            $this->array['StatusDescription'] = @(string) $node[0]->ErrorMessageText;
        }
    }


    private function getProductLevelError(){
        $errorNode = $this->xml->xpath("//SERVICE/STATUSES/STATUS/StatusCode[text()='Error']");
        if($errorNode  &&!empty($errorNode )){
            $status = $this->xml->xpath("//SERVICE/STATUSES/STATUS");
            if($status && !empty($status)){
                $this->array['error'] =  true;
                $this->array['StatusCode'] = @(string) $status[0]->StatusCode;
                $this->array['StatusDescription'] = @(string) $status[0]->StatusDescription;
            }
        }
    }


    private function getOrderStatus(){
        $node = $this->xml->xpath("//SERVICES/SERVICE/STATUSES/STATUS");
        if($node && !empty($node)){
            $this->array['error'] =  false;;
            $this->array['StatusCode'] = @(string) $node[0]->StatusCode;
            $this->array['StatusDescription'] = @(string) $node[0]->StatusDescription;
        }
    }


    private function getServiceType(){
        $service = $this->xml->xpath("//SERVICE_PRODUCT_DETAIL");
            if($service && !empty($service)){
                $this->array['ProductService'] = @(string) $service[0]->ServiceProductDescription;
            }
       
    }


    private function getOrderID(){

        // if($this->array['StatusCode'] == 'Completed'){
            $node = $this->xml->xpath("//SERVICE//SERVICE_PRODUCT_FULFILLMENT_DETAIL");
            if($node &&!empty($node)){
                $this->array['OrderID'] = @(string) $node[0]->VendorOrderIdentifier;
            }
        // }
    }


    private function getFile(){
        $node = $this->xml->xpath("//FOREIGN_OBJECT");
            if($node && !empty($node)){
                $this->array['FileContent'] = @(string)$node[0]->EmbeddedContentXML;
                $this->array['MIMETypeIdentifier'] = @(string) $node[0]->MIMETypeIdentifier;
                $this->array['ObjectEncodingType'] = @(string) $node[0]->ObjectEncodingType;
                $this->array['CharacterEncodingSetType'] = @(string) $node[0]->CharacterEncodingSetType;

            //     $data = base64_decode(@$node[0]->EmbeddedContentXML);
            //     $path = FCPATH.'uploads';

            //     header('Content-Type: application/pdf');
            //     echo $data;

            }
    }


}