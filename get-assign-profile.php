<?php
require('api/config.php');
require('api/query.php');

 ?>
 
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>  
 
 <style>
  #ui-id-1{
    width: 500px !important;


  }
  #tableEmails{
  width:100%;margin-bottom: 2%; margin-top: 0;
 
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
 <span id="test"></span>
<br>
  <div id="totalRecords">
   
   
    <div class="form-group col-md-12" style="padding-left: 0px; margin-bottom: 0.2rem;">
      <form id="profileForm" name="form1" method="POST">
        <div class="input-group">
          <div class="form-group">
              <input type="hidden" id="uri" value="<?php echo $uri ?>">
              <input type="hidden" id="getclientValue" value="0" style="width:400px;" >
              <input type="hidden" name="job_order_id" value="<?php echo $cjoid; ?>" id="job_order_id">
              <input type="hidden" name="job_order_profile_id" value="<?php echo $profileVal; ?>" id="job_order_profile_id">
              <input type="hidden"id="getQuery" value="" style="width:700px;">    
        <input type="text" id="profileID" class="profileID2"  autocomplete="off" class="form-control"  onchange="profileFunction()"  style="width: 500px;" />            
          </div>
         &nbsp; <button type="button" class="btn btn-primary btn-small" id="savebtn" name="save" style="background: #21A4F1; height: 2.5em; "><i class="fa fa-plus" aria-hidden="true" style="font-size: 1.3em; padding-bottom: 8px"></i></button>     

                  
                             
        </div>                   
      </form>        
    </div>
   

    <table class="table table-bordered table-hover" id="tableEmails" >
        <thead>
          <tr id="trEmails">
            <th>No</th>
            <th>Profiles</th>
            <th>Description</th>
          </tr>
        </thead>
      <?php if(!empty($result)){ ?>
        <tbody id="tbodyEmails">
      
       <?php 
       $i=1;
       while($rows = $result->fetch_array(MYSQLI_ASSOC)){ ?>
          <tr>
             <td> <?php  
                echo $i.".";
                  $i++; 
                  ?> 
             </td>
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
  var selected = document.querySelectorAll("#profileID");
  getclientValue.value = Array.prototype.map.call(selected, el => el.value).join(',');
    
}
 
 

$(document).ready(function() {
  $('#savebtn').on('click', function() {
    var getclientValue = $('#getclientValue').val();
    var profileID = $('#profileID').val();
    var job_order_id = $('#job_order_id').val(); 
    var job_order_profile_id = $('#job_order_profile_id').val(); 
    var getQuery = document.getElementById('getQuery').value =  getclientValue ;
    var uri = $('#uri').val(); 

      if(profileID!=""){
        $.ajax({
          url: "api/update_profile.php",
          type: "POST",
          data: {
            job_order_profile_id: job_order_profile_id,
            job_order_id: job_order_id,
            getQuery: getQuery     
          },
          cache: true,
          success: function(dataResult){
            var dataResults = JSON.parse(dataResult);
            if(dataResults.statusCode==200){
              $('#profileForm').find('input:text').val('');
              alert('added successfully')
              // console.log(dataResults+' 200 '+dataResult);
              location.href = uri;
                    
            }
            else if(dataResults.statusCode==201){
              alert("Error occured !");
              // console.log(dataResults+' 201 '+dataResult);
            }
            
          }

        });
        }
        else{
          alert('Please select one or more profile in textbox');
        }

  });


 
 

    $('#profileID').tokenfield({
      autocomplete :{
          source: function(request, response)
          {
                  $.ajax({
                  type: 'GET',
                  url: 'api/fetchdata2.php',
                
                  data: { get_param: request.term },
                  success: function (data ) {
                      data2 = JSON.parse(data);
                      response(data2);
                  }
              });  
          },
          delay: 100
      }
    });

 

});

 
</script>