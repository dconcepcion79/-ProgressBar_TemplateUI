<?php
//file to write the url
$location_url = '';
$path = 'location.txt';
if(file_exists($path)){
   $location_url=file_get_contents($path); 
}

if(isset($_GET['location_url'])){
    if($_GET['location_url']!=$location_url){
        $location_url = $_GET['location_url'];
        file_put_contents($path, $location_url);
    }
}

//echo $location_url;