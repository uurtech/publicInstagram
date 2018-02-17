<?php 

namespace KazdalInstagram;

/**
*  Instagram Public HTML String Crawler
*
*  @author Uğur KAZDAL
*/
class Feed{

    /** 
     * Call getImages(['user' => 'USERNAME' , 'type' => 'json'])
     */
   public function getImages(array $args){
			
        $fileName = date("dmy") . ".txt";

        if(!file_exists($fileName)){
            $veri = $this->Connect("https://www.instagram.com/".$args['user']);

            $e = explode('window._sharedData = ',$veri);
            $e = explode(';</script>',$e[1]);
    
            $obj = json_decode($e[0]);
    
    
            $images = $obj->entry_data->ProfilePage[0]->user->media->nodes;
    
            $myfile = fopen($fileName, "w");
    
            fwrite($myfile, json_encode($images));
            fclose($myfile);
        }
        $images = file_get_contents($fileName);

        
        return $args['type'] == 'json' ? $images : json_decode($images);
   }
   public function Connect($Url, $TimeOut = 10, $UserAgent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0'){
    $Curl = curl_init(); 
    curl_setopt($Curl, CURLOPT_URL, $Url);
    curl_setopt($Curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($Curl, CURLOPT_USERAGENT, $UserAgent);
    curl_setopt($Curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($Curl, CURLOPT_TIMEOUT, $TimeOut);
    curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, false);
    $Sonuc = curl_exec($Curl);
    curl_close($Curl);
    return $Sonuc;
    }
}

