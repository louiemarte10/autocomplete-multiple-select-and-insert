<?php 
 require "{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php";
 $conn = new mysqli(config::get_server_by_name('main'), "app_pipe", "a33-pipe", "callbox_pipeline2");

    $profileID=$_POST['profileID'];
    $job_order_profile_id=$_POST['job_order_profile_id'];
    $job_order_id=$_POST['job_order_id'];
    $getclientValue=$_POST['getclientValue']; 

   //  $int = filter_var($getclientValue.",", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);  
      
    $sql = " UPDATE client_job_orders SET profiles = '".$job_order_profile_id.$getclientValue."' WHERE client_job_order_id = '$job_order_id' ";
    $res = $conn->query($sql); 
      if ($res) {
        echo json_encode(array("statusCode"=>200));
      } 
      else {
        echo json_encode(array("statusCode"=>201));
      }
 


 ?>