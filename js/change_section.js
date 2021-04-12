 
function getsched()
{
    //Runs ajax to get student data
    url =   $("#url").val();
    ajax = $.ajax({
        url: url+'index.php/Registrar/fetch_sched',
        type: 'GET',
        data: {
            schoolyear: $("#sy").val(), 
            semester: $("#sem").val(),
            sections: $("#sections").val() 
        },
        success: function(response){

            console.log(response);
            result = JSON.parse(response);
            
            showtable = $('#schedtable');

            showtable.html('');

            TotalUnits = 0;
            count = 0;



            $('#IDSection').html('<input      type="hidden"     name="SCCC"   value="'+result[0]['Section_Name']+'">');
            $('#IDYearLevel').html('<input    type="hidden"     name="YearLevels"      value="'+result[0]['Year_Level']+'">');
            $('#IDSemester').html('<input     type="hidden"     name="SEMS"   value="'+result[0]['Semester']+'">');
            $('#IDSchoolYear').html('<input   type="hidden"     name="SYS"    value="'+result[0]['SchoolYear']+'">');
            $('#IDasa').html('');
            

            $.each(result, function(index, result) 
            {
                $('#IDasa').append('<input type="hidden"  name="SchedID[]"    value="'+result['id']+'">');
                
               TotalUnits = TotalUnits + (parseInt(result['Course_Lab_Unit']) + parseInt(result['Course_Lec_Unit']));

              count++;

                //Set custom attribute 'sched-code'
                row = $("<tr/>").attr({onclick:'radio_highlight(this)'});
                //row.addClass("rowinfo");
                //row.attr({'data-scode':result['Sched_Code'], "onClick": "sched_select(this)"});

                row.append($("<td/>").html($('<input/>').attr({'type':'checkbox','checked': '','name':'schedData[]','value':result['Sched_Code']})));
                row.append($("<td/>").text(result['Sched_Code']));
                row.append($("<td/>").text(result['Course_Code']));
                row.append($("<td/>").text(result['Course_Lab_Unit']));
                row.append($("<td/>").text(result['Course_Lec_Unit']));
                row.append($("<td/>").text(result['Section_Name']));
            
                showtable.append(row);


            });




            $('#Total_Units').val('Total Units:'+  TotalUnits);
            $('#Total_Subjects').val('Total Subjects:'+  count);


            $("input[type='checkbox']").onchange (function(){
                if ($(this).is(':checked')){
                    $(this).parent().parent().attr({style:'background:#cc0000; color:#fff'});
                }else{
                    $(this).parent().parent().attr({style:'background:#fff; color:#555'});
                }  
            });

             
        },
        fail: function(){

            alert('Error: request failed');
            return;
        }
    });

}

$("input[type='checkbox']").change(function(){

    
    if ($(this).is(':checked')){
        $(this).parent().parent().attr({style:'background:#cc0000; color:#fff'});
    }else{
        $(this).parent().parent().attr({style:'background:#fff; color:#555'});
    }
    
});

 