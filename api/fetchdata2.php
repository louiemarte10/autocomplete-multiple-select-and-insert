<?php
require ("{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php");

px_login::init();
$conn = new mysqli(config::get_server_by_name('main'), "app_pipe", "a33-pipe", "callbox_pipeline2");
$data = array();
 
if(isset($_GET["get_param"]))
{
 

 $query = "SELECT profile_lkp_id, profile FROM profiles_lkp as plkp
           where plkp.profile LIKE '".$_GET["get_param"]."%' AND plkp.x = 'active' 
           ORDER BY plkp.profile_lkp_id ASC
       	   LIMIT 15
          ";

 $statement = $conn->query($query);

 
 while($row = $statement->fetch_array(MYSQLI_ASSOC)){
	$data[$row["profile_lkp_id"]] =  $row["profile"];
 }
 echo json_encode($data);
}
 
 
 


?>
 