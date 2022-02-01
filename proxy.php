<?php

class Proxy{
    public $host="http://www.kivred.com/api/";
    
    public function __construct(){
        error_reporting(0);system("clear");
        $_0=$this->GetIp();
        if($_0["status"] === true){
            $this->token=$_0["token"];
            $ipx=$this->xip();
            for($i=0;$i<count($ipx["data"]);$i++){
                foreach($ipx["data"][$i] as $vpn => $ip){
                    foreach ($ip as $isp){
                        echo "~ ip      : ".$isp["ip"]."\n";
                        echo "~ port    : ".$isp["port"]."\n";
                        echo "~ type    : ".$isp["type"]."\n";
                        echo "~ speed   : ".$isp["speed"]."\n";
                        echo "~ country : ".$isp["country"]."\n";
                        echo str_repeat("~",60)."\n";sleep(3);
                    }
                }
            }
        }
        
    }
    public function curl($url, $post = 0, $httpheader = 0, $proxy = 0){ // url, postdata, http headers, proxy, uagent
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        if($post){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if($httpheader){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        }
        if($proxy){
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
            // curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        }
        curl_setopt($ch, CURLOPT_HEADER, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch);
        if(!$httpcode) return "Curl Error : ".curl_error($ch); else{
            $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            curl_close($ch);
            return array($header, $body);
        }
    }
    public function GetIp(){
         $head=[
            "agent: E5:EC:9D:C4:D1:4F:88:9C:A3:26:BA:B6:77:7B:68:E0:D6:0B:BE:42",
            "android: untoken",
            "device: 7234ab6e91011f61",
            "first_name: acvpn",
            "Content-Type: application/json; charset=utf-8",
            "Host: www.kivred.com",
            "User-Agent: okhttp/3.4.1"
             ];
        return json_decode($this->curl($this->host.'o/free/reg','{}',$head)[1],1);
    }
    public function xip(){
        return json_decode($this->curl($this->host.'vap-token-light/all-new','',["Authorization: ".$this->token,"User-Agent: okhttp/3.4.1"])[1],1);
    }
}
(new Proxy);