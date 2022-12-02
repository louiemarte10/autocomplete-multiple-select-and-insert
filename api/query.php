<?php 

$dateNow = date('Y-m-d'); 
$cjoid = $_REQUEST['cjoid'];
$clid = $_REQUEST['clid'];
$uri =  'http://192.168.50.12'.$_SERVER[REQUEST_URI];
$sql = "SELECT * FROM client_job_orders as clo
          WHERE clo.client_job_order_id = '$cjoid'
         ";
 
$res = $conn->query($sql); 
 
$getProfiles = $res->fetch_array();
 
$profiles 	 = $getProfiles['profiles'];
$getJoborder = $getProfiles['job_order'];
$getProfiles = "SELECT * FROM profiles_lkp as plkp
                where plkp.profile_lkp_id IN($profiles) and plkp.x = 'active' ORDER BY plkp.profile ASC
               ";         
$result = $conn->query($getProfiles);
    
  
if($profiles == ''){
  $profileVal = '';
}else{
  $profileVal = $profiles.",";
}

 ?>