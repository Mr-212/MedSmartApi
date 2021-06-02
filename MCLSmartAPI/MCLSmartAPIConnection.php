<?php


 class MCLSmartAPIConnection {


    private $user, $password, $url, $headers;
    public function __construct($user, $password, $url = null)
    {
        $this->user = $user;
        $this->password  = $password;
        $this->url = $url;
        $this->setHeaders();    
    }

    private function setHeaders($array = null){
        if(!empty($array) && is_array(($array))) 
            $this->headers = $array;
        else
          $this->headers = array(
            // "Content-Type: application/xml",
            'MCL-Interface: SmartAPITestingIdentifier',
            'Authorization: Basic '.base64_encode($this->user.':'.$this->password),
        );
     }

    private function getHeaders(){
        return $this->headers;
    }


    public function curl_request($request = array(), $type = 'GET')
    {
        $url = $this->url;
        $ch = curl_init($url);
        if ($type == 'POST' || $type == 'PUT') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        if (!empty($request)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, ($this->headers));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

}