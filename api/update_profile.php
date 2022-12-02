<?php 
 require "{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php";
 $conn = new mysqli(config::get_server_by_name('main'), "app_pipe", "a33-pipe", "callbox_pipeline2");
  $getQuery = array();
  $job_order_profile_id=$_POST['job_order_profile_id'];
  $job_order_id=$_POST['job_order_id'];
  $getQuery[] = $_POST['getQuery'];
  $jsonQuery = json_encode($getQuery);
  $jsonString = str_replace(array('["','"]'),'',$jsonQuery);
  $getProfileVal='"'.str_replace(', ','", "',$jsonString).'"';
 
  $sql_query = "SELECT * FROM profiles_lkp as plkp WHERE plkp.profile IN($getProfileVal)";
  $results = $conn->query($sql_query); 
  $count = $results->num_rows;

  $arr = array();
  $getProfileID = array();
    while($row1 = $results->fetch_assoc()){
      $arr[] = $row1;
      $getProfileID[] = $row1['profile_lkp_id'];
    }

  $rowJson = json_encode($getProfileID);
  $rowReplace = str_replace('"', '', $rowJson);
  $insertProfileID = str_replace(array('[',']'),'',$rowReplace);

  $sql = " UPDATE client_job_orders SET profiles = '".$job_order_profile_id.$insertProfileID."' WHERE client_job_order_id = '".$job_order_id."' ";
   
  $res = $conn->query($sql); 
    if ($res) {
      echo json_encode(array("statusCode"=>200));
    } 
    else {
      echo json_encode(array("statusCode"=>201));
    }




//  echo  $jsonQuery."<br>";
// echo $getProfileVal."<br>";
// echo $jsonString."<br>";
// echo  $sql_query."<br>";
// echo  $rowReplace."<br>";
// echo $insertProfileID;
 ?>
 
