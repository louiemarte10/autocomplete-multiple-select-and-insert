<?php
    require "{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php";
 px_login::init();
 $config= array();
$config['title'] = "Profile Tools";
$config['api_name'] = 'Profile Tools';
// $config['auth'] = true;
$gui = new px_gui($config);
$gui->head();
$gui->topnav();
 $conn = new mysqli(config::get_server_by_name('main'), "app_pipe", "a33-pipe", "callbox_pipeline2");
 
 


  $user_no = px_login::info("user_id");
 
$dateToday = date('M d, Y'); 
 

?>

