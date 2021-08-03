class StorageData{
    constructor(){
        this.user;
        this.data;
    }
    changeVal(val,data){
        this[val] = data;
    }
    getVal(val){
        return this[val];
    }
}
$('#modal').iziModal({
    headerColor: '#45abee',
    width: '30%',
    overlayColor: 'rgba(0, 0, 0, 0.5)',
    // top:modal_top_attr,
    fullscreen: true,
    transitionIn: 'fadeInUp',
    transitionOut: 'fadeOutDown',
    overlayClose: false,
    closeButton: false,
    closeOnEscape: false,
    openFullscreen: false,
    fullscreen:  false
    // height: '80',
});
var storagedata = new StorageData();
// $this->
$('#semester').on('change',function(){
    alert(this.value);
})

$("#sendButton").click(function(){

    // $('body').waitMe({
    //     effect : 'stretch',
    //     text : 'Please wait...',
    //     bg : 'rgba(255,255,255,0.7)',
    //     color : '#000',
    //     maxSize : '',
    //     waitTime : -1,
    //     textPos : 'vertical',
    //     fontSize : '',
    //     source : '',
    //     onClose : function() {}
    // });
    // $.ajax({
    //         url: "StatementOfAccount/getEmailData",
    //         method: 'get',
    //         dataType:'json',
    //         data:{
    //             programCode:$('#programCode').val(),
    //             semester:$('#semester').val(),
    //             schoolYear:$('#schoolYear').val()
    //         },
    //         success: function(response) {
    //             storagedata.changeVal('data',response);
    //             // console.log(response);
    //             for(var x=1;x<=response.total_page;++x){
    //                 console.log(`page ${x}`);
    //             }
    //             $('body').waitMe('hide');
    //             $('#modal').iziModal('open');
    //         },
    //         error: function(response) {
    //             // reject(response);
    //         }
    //     });
        // console.log(storagedata.getVal('data'));
    // var programCode = $("#programCode").val();
    // var schoolYear = $("#schoolYear").val();
    // var semester = $("#semester").val();
    // var term = $("#term").val();
    // if ( !$("#programCode").val() || !$("#schoolYear").val() || !$("#semester").val() || !$("#term").val() || !$("#dueDate").val() ) 
    // {
    //     alert("Please fill up the form");
    //     console.log(`logs ${programCode}, ${schoolYear}, ${semester}, ${term}`);
    //     return;
    // }
    // console.log(`logs ${$("#schoolYear").val()}`);

    // $('#sendForm').attr('action', $("#addressUrl").val()+"/send_email");

    // $("#sendForm").submit();
});