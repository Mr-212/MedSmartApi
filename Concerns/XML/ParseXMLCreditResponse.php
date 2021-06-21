<?php 

class ParseXMLCreditResponse {
     

    private $xml,
    $colonPrefix = null,
    $label,
    $relationshipBaseurl = "urn:fdc:Meridianlink.com:2017:mortgage",
   
    $relatiojnshipArcRoleLabel,
    $relatiojnshipTo,
    $relatiojnshipArcRoleAssociationWithRole;


    // private $array = [
    //     'parties' => [],
    // ];

    public function __construct($xml)
    {
        $this->xml = $xml;

        $this->baseNmaespace = 'base';
        $this->xml->registerXPathNamespace($this->baseNmaespace, 'http://www.mismo.org/residential/2009/schemas');
        $this->label = "{$this->colonPrefix}:label";
        $this->relatiojnshipArcRoleLebal = "{$this->colonPrefix}:arcrole";
        $this->relatiojnshipTo =  "{$this->colonPrefix}:to";
        $this->relatiojnshipArcRoleAssociationWithRole= "{$this->relationshipBaseurl}/CREDIT_LIABILITY_IsAssociatedWith_ROLE";
        $this->relatiojnshipArcRoleAssociationWithCreditLiability= "{$this->relationshipBaseurl}/CREDIT_FILE_IsAssociatedWith_CREDIT_LIABILITY";
        $this->relatiojnshipArcRoleAssociationWithCreditScore= "{$this->relationshipBaseurl}/CREDIT_SCORE_IsAssociatedWith_ROLE";
        $this->relatiojnshipArcRoleAssociationWithCreditScoreModel= "{$this->relationshipBaseurl}/CREDIT_SCORE_MODEL_IsAssociatedWith_ROLE";



    }

    public function parse(){
        return $this->getParties();
        // $this->getRelationShip();
        // $this->getCreditScore();
        // $this->getCreditLiabilities();
    }


    public function getParties(){
        $nodes = $this->xml->xpath('//SERVICE//PARTIES/PARTY');
        $array = [];
        // print "<pre>";
        // print_r($this->xml);
        // print "</pre>";
        // die();
        if($nodes){
            foreach($nodes as $node){
                // $party_label = (string)$node->attributes()->{'label'};
                $data  = json_decode(json_encode($node), 1);

                    // print "<pre>";
                    // print_r($node->ROLES->ROLE[0]);
                    // print "</pre>";
                    // die();
                // var_dump($data);
                $temp = [];
                array_walk_recursive($data, function($v,$k) use(&$temp){
                    $temp[$k]=$v;
                });
                // $party_label= "ConsumerPC_1_2";
                $party_label= $temp['label'];
               
                // $temp['ROLE'] = (string)$node->ROLES->ROLE;
                // var_dump($party_label);
                $array[$party_label] = $temp;;
                
                $array = $this->getRelationShip($party_label,$array);
                // die();
                // $address= $this->getPartyAddress($party_label);
                // var_dump($address);
                // $this->array['parties'][$party_label]['address'] = $address;
            }
            // print "<pre>";
            // print_r($array);
            // print "<pre>";
            // die();

            return $array;

          
        }

    }


    private function getPartyAddress($party){
        return (array)$this->xml->xpath("//SERVICE//PARTIES/PARTY[@label='{$party}']//ADDRESS")[0];
    }

    public function getRelationShip($party, &$array){
        // $role = $this->relatiojnshipArcRoleAssociationWithRole;
        // $array = [];
        $nodes = $this->xml->xpath("//SERVICE//RELATIONSHIP[@to='{$party}']");
        // $nodes = $this->xml->xpath("//SERVICE//RELATIONSHIP[@arcrole='{$role}']");
        // $nodes = $this->xml->xpath("//SERVICE//RELATIONSHIP");

        if($nodes){
            foreach($nodes as $node){
                // $arcRole = $this->getAttributeValueString($node,'arcrole');
                // if($)
                $from = $this->getAttributeValueString($node,'from');
                $to = $this->getAttributeValueString($node,'to');
                $role  = $this->getAttributeValueString($node,'arcrole');
                if($role == $this->relatiojnshipArcRoleAssociationWithRole ){
                    $crdit_liability = $this->getCreditLiabilityByLabel($from);
                    if($crdit_liability){
                        // $array[$to][$from]['credit_liabilities'][] = $crdit_liability;
                        $array[$to]['credit_liabilities'][$from] = $crdit_liability;

                    }
                }
                if($role == $this->relatiojnshipArcRoleAssociationWithCreditScore ){
                    $crdit_liability = $this->getCreditScoreByLabel($from);
                    if($crdit_liability)
                        $array[$to]['credit_score'][$from] = $crdit_liability;
                }
                if($role == $this->relatiojnshipArcRoleAssociationWithCreditScoreModel ){
                    $crdit_liability = $this->getCreditScoreModelByLabel($from);
                    if($crdit_liability)
                        $array[$to]['credit_score_model'][$from] = $crdit_liability;
                }
            }
        }
        return $array;

        // print "<pre>";
        // print_r($array);
        // print "</pre>";
        // die();
        // if($node){
        //     //var_dump($node);die();
        // }
    }


    private function getAttributeValueString($node, $attribute){
       return  (string)$node->attributes()->{$attribute};
    }


    public function getCreditScoreByLabel($label){
        $node = $this->xml->xpath("//SERVICE//CREDIT_SCORE[@label='{$label}']");
        $array = [];
        if(isset($node[0])){
            $node = $node[0];
            $data  = json_decode(json_encode($node),1);
            array_walk_recursive($data, function($v,$k) use(&$array){
                $array[$k]=$v;
            });
            // $array = (array)$node->CREDIT_SCORE_DETAIL;
        }
       
        // print "<pre>";
        // print_r($node);
        // print "</pre>";
        // die();
        return $array;
    }

    public function getCreditScoreModelByLabel($label){
        $node = $this->xml->xpath("//SERVICE//CREDIT_SCORE_MODEL[@label='{$label}']");
        // var_dump($node);
        $array = [];
        if(isset($node[0])){
            $node = $node[0];
            $data  = json_decode(json_encode($node),1);
            array_walk_recursive($data, function($v,$k) use(&$array){
                $array[$k]=$v;
            });
            // $array = (array)$node->CREDIT_SCORE_DETAIL;
        }
       
        // print "<pre>";
        // print_r($node);
        // print "</pre>";
        // die();
        return $array;
    }

    public function getCreditLiabilityByLabel($label){
        //  $node1 = $this->xml->xpath("//SERVICE//CREDIT_LIABILITIES/CREDIT_LIABILITY");
        $node = $this->xml->xpath("//SERVICE//CREDIT_LIABILITIES/CREDIT_LIABILITY[@label='{$label}']");
        // print "<pre>";
        // print_r($node[0]);
        // print "</pre>";
        // die();
        $array = [];
        if($node){
            if(isset($node[0])){
                $node = $node[0];

                $data  = json_decode(json_encode($node),1);
                array_walk_recursive($data, function($v,$k) use(&$array){
                    $array[$k]=$v;
                });
                    // if(isset($node->CREDIT_LIABILITY_CREDITOR)){
                    //     // $this->array['accounts'][$i]['AccountName'] = (string)$node->CREDIT_LIABILITY_CREDITOR->NAME->FullName;
                    //     $array['AccountName'] = (string)$node->CREDIT_LIABILITY_CREDITOR->NAME->FullName;
                    //     $array = array_merge($array, (array)$node->CREDIT_LIABILITY_DETAIL);

                    // }
                    // if(isset($node->CREDIT_LIABILITY_DETAIL)){
                    //     // $this->array['accounts'][$i]['AccountType'] = (string)$node->CREDIT_LIABILITY_DETAIL->CreditBusinessType;
                    //     //  print_r((array)$node->CREDIT_LIABILITY_DETAIL);
                    //      $array = array_merge($array, (array)$node->CREDIT_LIABILITY_DETAIL);
                    //     // array_merge($array,(array)$node->CREDIT_LIABILITY_DETAIL->CreditBusinessType;

                    // } 

                    // if(isset($node->CREDIT_LIABILITY_LATE_COUNT)){
                    //     $array = array_merge($array, (array)$node->CREDIT_LIABILITY_LATE_COUNT->CREDIT_LIABILITY_LATE_COUNT_DETAIL);

                    // }

                    // if(isset($node->CREDIT_LIABILITY_PAYMENT_PATTERN)){
                    //     $array = array_merge($array, (array)$node->CREDIT_LIABILITY_PAYMENT_PATTERN);

                    // }
                    // if(isset($node->CREDIT_REPOSITORIES->CREDIT_REPOSITORY)){
                    //     $array = array_merge($array, (array)$node->CREDIT_REPOSITORIES->CREDIT_REPOSITORY);

                    // }

                    
            }
    }
    // var_dump($array);
    // die();
    return $array;
    }

    public function getCreditFile($label){
        //  $node1 = $this->xml->xpath("//SERVICE//CREDIT_LIABILITIES/CREDIT_LIABILITY");
        $node = $this->xml->xpath("//SERVICE//CREDIT_LIABILITIES/CREDIT_LIABILITY[@label='{$label}']");
        // print "<pre>";
        // var_dump($node[0]->CREDIT_LIABILITY);
        // print "</pre>";
        // die();
        $array = [];
        if($node){
            if(isset($node[0])){
                $node = $node[0];
                    if(isset($node->CREDIT_LIABILITY_CREDITOR)){
                        // $this->array['accounts'][$i]['AccountName'] = (string)$node->CREDIT_LIABILITY_CREDITOR->NAME->FullName;
                        $array['AccountName'] = (string)$node->CREDIT_LIABILITY_CREDITOR->NAME->FullName;

                    }
                    if(isset($node->CREDIT_LIABILITY_DETAIL)){
                        // $this->array['accounts'][$i]['AccountType'] = (string)$node->CREDIT_LIABILITY_DETAIL->CreditBusinessType;
                        $array['AccountType'] = (string)$node->CREDIT_LIABILITY_DETAIL->CreditBusinessType;

                    } 
            }
    }
    // var_dump($array);
    // die();
    return $array;
    }








}