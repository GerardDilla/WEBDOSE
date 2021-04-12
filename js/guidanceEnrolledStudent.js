//GET MAJOR
$(document).ready(function(){

  major_select();
  province_select();
  barangay_select();
  $('#Program').change(function(){ 
    
      major_select();

  });

  //GET MUNICIPALITY

   $('#provinces').change(function(){
    province_select();
      
   });

   $('#municipalitys').change(function(){
    barangay_select();
     });

 
});

//GET SECTIONS

function Display_Major(result){
   $('#mjr').append('<option value="0">Select Major:</option>');
   $.each(result, function(index, result) 
    {
      $('#mjr').append('<option value="'+result['ID']+'">'+result['Program_Major']+'</option>');
    });
    $('select[name=mjr]').val($('#major').val());
    $("#mjr").selectpicker('refresh'); 
   
}



 function Display_Municipalitys(result){
   $('#municipalitys').append('<option selected value="">Select Municipality:</option>');
   $.each(result, function(index, result) 
    {
      $('#municipalitys').append('<option>'+result['citymunDesc']+'</option>');
    });
    $('select[name=municipality]').val($('#municip').val());
    $("#municipalitys").selectpicker('refresh'); 
   
}


//GET BARANGAY


function Display_Barangays(result){

   $('#barangays').append('<option selected value="">Select Barangay:</option>');
   $.each(result, function(index, result) 
    {
      $('#barangays').append('<option>'+result['brgyDesc']+'</option>');
    });
    $('select[name=municipality]').val($('#barang').val());
    $("#barangays").selectpicker('refresh'); 
   
}

function province_select(){

  var Guidance_url = $("#guidance_url").val(); 
  var Province_code = $('#provinces').val();
  if(Province_code != '')
  {
   $.ajax({
    url:Guidance_url+"index.php/Guidance/fetch_muni",
    method:"POST",
    data:{Province_code:Province_code},
    success:function(data)
    {        
            $("#municipalitys").html('');
            result = JSON.parse(data);
            Display_Municipalitys(result)
               
              //  alert('HELLOWORLD');
            }
         });
      
      }

}

function major_select(){

  var Guidance_url = $("#guidance_url").val(); 
  var Program_id = $('#Program').val();
  if(Program_id != '')
  {
   $.ajax({
    url:Guidance_url+"index.php/Guidance/fetch_major",
    method:"POST",
    data:{Program_id:Program_id},
    success:function(data)
    {        
            $("#mjr").html('');
            result = JSON.parse(data);
            Display_Major(result)
    }
   });
  }

}


function barangay_select(){

  var Guidance_url = $("#guidance_url").val(); 
  var Municipality_code = $('#municipalitys').val(); 
   if(Municipality_code != '')
  {
   $.ajax({
    url:Guidance_url+"index.php/Guidance/fetch_barangay",
    method:"POST",
    data:{Municipality_code:Municipality_code},
    success:function(data)
    {        
           $("#barangays").html('');
            result = JSON.parse(data);
            Display_Barangays(result)
         }
      });
   
   }

}