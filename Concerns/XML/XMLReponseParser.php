<?php


include __DIR__.'/ParseXMLCreditResponse.php';

class XMLResponseParser {
    
    private $xml,
    $mimeType = [
        'pdf' => 'application/pdf',
        'html'=>'text/html',
    ];


    public $array = array(
        'error' => true,
        'StatusCode'=> null,
        'StatusDescription'=>null,
        'ProductService' => null,
        'OrderID' => null,
        'FileContent' => null,
        'FileType' => null,
        'data' => null,
        'rawXMLResponse' => null,
    );
  
    public function __construct($xmlResponse)
    {
        $xmlResponse = preg_replace('/(xmlns|xsi)[^=]*="[^"]*" ?/i', '', $xmlResponse);
        $xmlResponse = preg_replace("/(d7p1:|d5p1:)/", "", $xmlResponse); 
        $this->xml =  new SimpleXMLElement($xmlResponse);
        $this->array['rawXMLResponse'] = $this->xml->asXML();
    }


    public function parse(){

         $this->getRequestLeveError();
         $this->getProductLevelError();
         $this->getOrderStatus();
         $this->getServiceType();
         $this->getOrderID();
         $this->getHTMLOrPDF();
         $this->parseXMLCreditResponse();
        
         return $this->array;

    }


    private function getRequestLeveError(){
        // print "<pre>";
        // print_r($this->xml);
        // print "<pre>";
        $node = $this->xml->xpath("//DEAL_SET_SERVICES/DEAL_SET_SERVICE/ERRORS/ERROR/ERROR_MESSAGES/ERROR_MESSAGE");
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
            $this->array['error'] = false;;
            $this->array['StatusCode'] = @(string) $node[0]->StatusCode;
            $this->array['StatusDescription'] = @(string)$node[0]->StatusDescription;
        }
    }


    private function getServiceType(){
        $service = $this->xml->xpath("//SERVICE_PRODUCT_DETAIL");
            if($service && !empty($service)){
                $this->array['ProductService'] = @(string)$service[0]->ServiceProductDescription;
            }
       
    }


    private function getOrderID(){
            $node = $this->xml->xpath("//SERVICE//SERVICE_PRODUCT_FULFILLMENT_DETAIL");
            if($node &&!empty($node)){
                $this->array['OrderID'] = @(string) $node[0]->VendorOrderIdentifier;
            }
    }


    private function getHTMLOrPDF(){
        $nodes = $this->xml->xpath("//FOREIGN_OBJECT");
        // print "<pre>";
        // print_r($nodes);
        // print "</pre>";
        // die();
        if($nodes && !empty($nodes)){
            foreach($nodes as $k=>$node){
                if($node->MIMETypeIdentifier == $this->mimeType['pdf']){
                    $this->array['FileContent'] = @$node->EmbeddedContentXML;
                    $this->array['MIMETypeIdentifier'] = @(string) $node->MIMETypeIdentifier;
                    $this->array['ObjectEncodingType'] = @(string) $node->ObjectEncodingType;
                    $this->array['CharacterEncodingSetType'] = @(string) $node->CharacterEncodingSetType;
                    break;

                }
            }
           

        }
    }


    public function parseXMLCreditResponse(){
        $nodes = $this->xml->xpath("//SERVICE//CREDIT_RESPONSE");
        if(!empty($nodes)){
            $object = new ParseXMLCreditResponse($this->xml);
            $this->array['data'] = json_encode($object->parse(),1);
            // print "<pre>";
            // print_r($this->array);
            // print "</pre>";
            // die();
        }
        
    }




}