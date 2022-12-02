<?php
require('api/config.php');
require('api/query.php');
$cjoid = $_REQUEST['cjoid'];
$uri =  'http://192.168.50.12'.$_SERVER[REQUEST_URI];

if($profiles == ''){
  $profileVal = '';
}else{
  $profileVal = $profiles.",";
}
 ?>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css" rel="stylesheet">  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

 
 <style>
  #tableEmails{
  width:100%;margin-bottom: 2%; margin-top: 0;
  /*background-color: red;*/
  }
  #trEmails{
  background-color: #E6E6E6;
   
  }
  #tbodyEmails{
    background-color: #ffffff;
  }
   #tbodyEmails td{
    color:black;
   }
.topbar, #cb_subheader{
  display: none!important;
}

.header-fixed.subheader-fixed.subheader-enabled .wrapper{
  padding-top: 70px;
}
 
 
</style>
<div class="container-panel">  
 <div>
  <center>
    <h4> Any changes made to the Metatags/Profiles setting in this page <br> will apply for all lists under this Job Order "<?php echo $getJoborder; ?>" </h4>
  </center>
 </div>
<br>
  <div id="totalRecords">
   
   
    <div class="form-group col-md-12" style="padding-left: 0px; margin-bottom: 0.2rem;">
      <form id="profileForm" name="form1" method="POST">
        <div class="input-group">
          <div class="form-group">
              <input type="hidden" id="uri" value="<?php echo $uri ?>">
              <input type="hidden" id="getclientValue" value="0"    >
              <input type="hidden" name="job_order_id" value="<?php echo $cjoid; ?>" id="job_order_id">
              <input type="hidden" name="job_order_profile_id" value="<?php echo $profileVal; ?>" id="job_order_profile_id">
               <select multiple placeholder="Choose Profile" data-allow-clear="1" class="form-control" name="profiles" id="profileID" onchange="profileFunction()"   style="width: 500px;">
                <?php // while($rows = $results->fetch_array()){
                  foreach ($data as $datas) {
                 ?>
                  <option value="<?php echo $datas['profile_lkp_id']; ?>"><?php echo $datas['profile']; ?></option>
                <?php } ?>                        
              </select>  
          </div>
         &nbsp; <button type="button" class="btn btn-primary btn-small" id="savebtn" name="save" style="background: #21A4F1; height: 2.5em; "><i class="fa fa-plus" aria-hidden="true" style="font-size: 1.3em; padding-bottom: 8px"></i></button>                   
                             
        </div>                   
      </form>        
    </div>
   

    <table class="table table-bordered table-hover" id="tableEmails" >
        <thead>
          <tr id="trEmails">
            <th>Id  </th>
            <th>Profiles</th>
            <th>Description</th>
          </tr>
        </thead>
    <?php if(!empty($result)){ ?>
        <tbody id="tbodyEmails">
      
       <?php while($rows = $result->fetch_array(MYSQLI_ASSOC)){ ?>
          <tr>
           <td> <?php echo $rows['profile_lkp_id']; ?> </td>
           <td> <?php echo $rows['profile']; ?></td>
           <td> <?php echo $rows['description']; ?>  </td>
          </tr>  
        <?php } ?>
        </tbody>
    <?php }else{ ?>
          <tr>
           <td colspan="3" style="text-align: center;"> No Data Available.</td>
          </tr>  
    <?php } ?>  
    </table>
   
  </div>

</div>
 

 

<script type="text/javascript">

function profileFunction(){
  var getclientValue = document.getElementById("getclientValue");
  var selected = document.querySelectorAll("#profileID option:checked");
      getclientValue.value = Array.prototype.map.call(selected, el => el.value).join(',');

}

$(document).ready(function() {
    $('#savebtn').on('click', function() {
      var getclientValue = $('#getclientValue').val();
      var profileID = $('#profileID').val();
      var job_order_id = $('#job_order_id').val(); 
      var job_order_profile_id = $('#job_order_profile_id').val(); 
      var uri = $('#uri').val(); 
        if(profileID!=""){
          $.ajax({
            url: "api/update_profile.php",
            type: "POST",
            data: {
              job_order_profile_id: job_order_profile_id,
              job_order_id: job_order_id,
              profileID: profileID,
              getclientValue: getclientValue     
            },
            cache: false,
            success: function(dataResult){
              var dataResult = JSON.parse(dataResult);
              if(dataResult.statusCode==200){
                $('#profileForm').find('input:text').val('');
                alert('added successfully')
                location.href = uri;
                          
              }
              else if(dataResult.statusCode==201){
                alert("Error occured !");
              }
              
            }

          });
          }
          else{
            alert('Please select one or more profile');
          }
    });


      $('select').each(function () {
        $(this).select2({
          theme: 'bootstrap4',
          width: 'style',
          placeholder: $(this).attr('placeholder'),
          allowClear: Boolean($(this).data('allow-clear')),
        });
      });
});

 
</script>