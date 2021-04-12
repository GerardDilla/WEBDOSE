//GET MAJOR
$(document).ready(function(){
 $('#Program').change(function(){ 
  var Guidance_url = $("#guidance_url").val(); 
  var Program_id = $('#Program').val();
  if(Program_id != '')
  {
   $.ajax({
    url:Guidance_url+"index.php/Registrar/fetch_major",
    method:"POST",
    data:{Program_id:Program_id},
    success:function(data)
    {        
            $("#mjr").html('');
            result = JSON.parse(data);
            $.each(result, function(index, result) 
            {
                $('#mjr').append('<option value="'+result['ID']+'">'+result['Program_Major']+'</option>');
             });
               
                $("#mjr").selectpicker('destroy');
    }
   });

  }
  else
  {
   $('#mjr').html('<option value="">Select Major</option>');
  }
 });

//GET SECTIONS

 $('#Program').change(function(){
 var Guidance_url = $("#guidance_url").val(); 
  var Program_id = $('#Program').val();
  if(Program_id != '')
  {
   $.ajax({
    url:Guidance_url+"index.php/Registrar/fetch_sections",
    method:"POST",
    data:{Program_id:Program_id},
    success:function(data)
    {        
            $("#Section").html('');
            result = JSON.parse(data);
            $('#Section').append('<option selected value="0">Select Section:</option>');
            $.each(result, function(index, result) 
            {
                $('#Section').append('<option value="">'+result['SN']+'</option>');
             });
               
             $("#Section").select2("destroy");
    }
   });

  }
  else
  {
   $('#Section').html('<option value="">Select Major</option>');
  }
 });
});

