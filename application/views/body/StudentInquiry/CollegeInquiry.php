
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/css/iziModal.min.css" integrity="sha512-8vr9VoQNQkkCCHGX4BSjg63nI5CI4B+nZ8SF2xy4FMOIyH/2MT0r55V276ypsBFAgmLIGXKtRhbbJueVyYZXjA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/js/iziModal.min.js" integrity="sha512-8aOKv+WECF2OZvOoJWZQMx7+VYNxqokDKTGJqkEYlqpsSuKXoocijXQNip3oT4OEkFfafyluI6Bm6oWZjFXR0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/timeago.js/2.0.2/timeago.min.js" integrity="sha512-sl01o/gVwybF1FNzqO4NDRDNPJDupfN0o2+tMm4K2/nr35FjGlxlvXZ6kK6faa9zhXbnfLIXioHnExuwJdlTMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="<?php echo base_url(); ?>plugins/waitme/waitMe.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url(); ?>plugins/waitme/waitMe.min.js"></script>
<style>
/* #chatinquiryModal .modal-dialog{
    max-width: 700px;
} */
#chat-message{
    overflow-y: auto;
    max-height:60vh;
}
.chat{
    position:relative;
    width:60%;
    min-height:50px;
    border-radius:10px;
    margin:5px;
    padding:10px;
    position:relative;
}
.chat-student{
    /* background:#3FD3B6; */
    color:black;
    float:left;
}
.chat-admin{
    /* background:#d4d4d4; */
    color:black;
    float:right;
}
.message-head{
    font-weight:bold;
    font-size:18px;
    padding-left:10px;
}
.message-time{
    padding-left:10px;
    font-weight:700;
    font-size:14px;
}

.message-body{
    padding:10px 10px 10px 20px;
    min-height:50px;
    /* max-height:50vh; */
    border-radius:10px;
    width:100%;
    white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
    white-space: -webkit-pre-wrap;          /* Chrome & Safari */ 
    white-space: -pre-wrap;                 /* Opera 4-6 */
    white-space: -o-pre-wrap;               /* Opera 7 */
    white-space: pre-wrap;                  /* CSS3 */
    word-wrap: break-word;                  /* Internet Explorer 5.5+ */
    word-break: break-all;
    white-space: normal;
}
#someone-typing .message-body{
    min-height:50px;
}
.chat-admin .message-body{
    background:#FF554D;
    color:white;
}
.chat-student .message-body{
    background:#d4d4d4;
    
}
/* #someone-typing{
    display:block;
} */
#someone-typing .chat-student .message-body{
    background:white;
    
}
.chat-textarea{
    display:inline-block;
    width:84%;
    float:left;
    min-height:50px;
    max-height:100px;
    /* border:1px #d4d4d4 solid; */
    border:1px maroon solid;
    padding:10px;
    border-radius:8px;
    white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
    white-space: -webkit-pre-wrap;          /* Chrome & Safari */ 
    white-space: -pre-wrap;                 /* Opera 4-6 */
    white-space: -o-pre-wrap;               /* Opera 7 */
    white-space: pre-wrap;                  /* CSS3 */
    word-wrap: break-word;                  /* Internet Explorer 5.5+ */
    word-break: break-all;
    white-space: normal;
    overflow-y:auto;
}
span.chat-status{
    /* transform:translate(50%,50%); */
    bottom:3px;
    right:-9px;
    position:absolute;
    color:black;
    /* padding-right:10px;
    padding-bottom:10px; */
}
.modal .modal-header{
    border-bottom:1px solid maroon;
}
.modal-dialog-scrollable .modal-body {
    overflow-y: auto;
}
</style>
<section  id="top" class="content" style="background-color: #fff;">
    <!-- CONTENT GRID-->
    <div class="container-fluid">
    <!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#chatinquiryModal">
  Launch demo modal
</button> -->
        <!-- MODULE TITLE-->
        <div class="block-header row">
            <h1 style="float:left;" class="col-md-8"> <i class="material-icons" style="font-size:100%">feedback</i> College Inquiry</h1>
            <span class="col-md-4"><input type="date" id="search_date" name="search_date" class="form-control" style="margin-top:10px;" value="<?= date("Y-m-d");?>"></span>
            
            <?php if($this->session->flashdata('message_error') || $this->session->flashdata('message_success')): ?>
            <br>
                <h3 class="col-red">
                    <?php echo $this->session->flashdata('message_error'); ?>
                </h3>
                <h3 class="col-green">
                    <?php echo $this->session->flashdata('message_success'); ?>
                </h3>
            <br>
            <?php endIf; ?>
        </div>
        <div class="col-md-12 table-responsive">
            <div class="col-lg-4 col-md-4 input-group" style="float:right;">
                <span class="input-group-addon">
                    <i class="material-icons">search</i>
                </span>
                <div class="form-line">
                    <!-- <label class="form-label">search</label> -->
                    <input type="text" class="form-control" name="search_table" id="search_table" placeholder="Search..." required>
                </div>   
            </div>
            <table id="chatInquiryTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Level</th>
                        <th>Course</th>
                        <th width="15%">Total Messages</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($getStudentInquiry as $inquiry_list):?>
                    <?php
                    $level = "";
                    if($inquiry_list['YearLevel']=="1"){
                        $level = "1st Year";
                    }
                    else if($inquiry_list['YearLevel']=="2"){
                        $level = "2nd Year";
                    }
                    else if($inquiry_list['YearLevel']=="3"){
                        $level = "3rd Year";
                    }
                    else if($inquiry_list['YearLevel']=="4"){
                        $level = "4th Year";
                    }
                    ?>
                    <tr>
                        <td><?= $inquiry_list['Full_Name']?></td>
                        <td><?php echo $level; ?></td>
                        <td><?php echo $inquiry_list['Course']; ?></td>
                        <td width="15%"><?php echo $inquiry_list['total_message']; ?></td>
                        <td width="15%"><button class="btn btn-info" onclick="openModal('<?php echo $inquiry_list['ref_no'];?>','<?php echo $inquiry_list['First_Name'].' '.$inquiry_list['Middle_Name'].' '.$inquiry_list['Last_Name'];?>')" data-toggle="modal" data-target="#chatinquiryModal">open</button></td>
                        <!-- data-bs-toggle="modal" data-bs-target="#chatinquiryModal" -->
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>     
        </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="chatinquiryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel16"><img src="<?php echo base_url('img/Accounting/logo.png')?>" style="width:150px;height:auto;"> &nbsp;&nbsp;&nbsp;<font id="student-name">SDCA Inquiry</font></h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <i data-feather="x"></i>
            </button>
        </div>
        <div class="modal-body" style="position:relative;">
        <div class="col-md-12" id="chat-box" style="position:relative;">
                <div id="chat-message"></div>
                <!-- <div id="someone-typing"><img src="<?php echo base_url('assets/images/827.gif')?>" style="width:50px;height:auto;"> </div> -->
            <!-- <div class="col-md-12"><div class="chat-student chat"><div class="message-head">Jhon Norman Fabregas</div><div class="message-time">10:00 AM</div><div class="message-body">Hello</div></div></div>
            <div class="col-md-12"><div class="chat-admin chat"><div class="message-head">Jhon Norman Fabregas</div><div class="message-time">10:00 AM</div><div class="message-body">Hello</div></div></div> -->
        </div>
        </div>
        <form id="inquiryForm">
        <div class="modal-footer">
            <div id="someone-typing" class="col-md-12" align="center" style="display:none;"><img src="<?php echo base_url('assets/images/827.gif')?>" style="width:50px;height:auto;"></div>
            <div class="chat-textarea" contenteditable="true" id="chat-textarea"></div>
            <!-- <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Close</span>
            </button> -->
            <button class="btn btn-info" type="button">
                <!-- <i class="bx bx-x d-block d-sm-none"></i> -->
                <span class="d-none d-sm-block">Send</span>
            </button>
            
        </div>
        </form>
    </div>
  </div>
</div>
<script src="https://unpkg.com/@feathersjs/client@^4.3.0/dist/feathers.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuidv4.min.js" integrity="sha512-BCMqEPl2dokU3T/EFba7jrfL4FxgY6ryUh4rRC9feZw4yWUslZ3Uf/lPZ5/5UlEjn4prlQTRfIPYQkDrLCZJXA==" crossorigin="anonymous"></script>
<script>
var search_date = $('input[name=search_date]').val();
$('#college_inquiry').iziModal({
    theme: 'light',
    headerColor: 'maroon',
    width: '60vw',
    overlayColor: 'rgba(0, 0, 0, 0.5)',
    top: 1,
    fullscreen: true,
    color: 'white',
    transitionIn: 'fadeInUp',
    transitionOut: 'fadeOutDown',
    // height: '80',
});
class CollegeTable{
    constructor(){
        this.data = [];
    }
    async updateData(value){
        this.data = value;
    }
    async filterData(search_value){
        console.log(this.data)
        var filtered = this.data.filter((col)=>{
            try{
                var search = search_value.toLowerCase();
                var lc_fullname = col.Full_Name.toLowerCase();
                var lc_YearLevel = col.YearLevel.toLowerCase();
                var lc_course = col.Course.toLowerCase();
                var lc_total_message = col.total_message;
                if(lc_total_message!=null||lc_fullname!=null||lc_YearLevel!=null||lc_course!=null){ 
                    return lc_fullname.indexOf(search) > -1||lc_YearLevel.indexOf(search) > -1||lc_course.indexOf(search) > -1||lc_total_message.indexOf(search) > -1
                // return lc_fullname.indexOf(search) > -1||lc_YearLevel.indexOf(search) > -1||lc_course.indexOf(search) > -1||lc_course.indexOf(search) > -1
                }
            }
            catch(err){

            }
        })
        await this.createDataTable(filtered);
        await this.hideWaitMe();
    }
    async filterByDate(value){

    }
    async createDataTable(value){
        $('body').waitMe({
            effect : 'win8',
            text : '',
            bg : 'rgba(255,255,255,0.7)',
            color : 'maroon',
            maxSize : '',
            waitTime : -1,
            textPos : 'vertical',
            fontSize : '',
            source : '',
            onClose : function() {}
        });
        // $('#chatInquiryTable').DataTable().destroy();
        $('#chatInquiryTable tbody').empty();
        var html = "";
        $.each(value,function(index,val){
            var level = ""
            if(val.YearLevel=="1"){
                level = "1st Year"
            }
            else if(val.YearLevel=="2"){
                level = "2nd Year"
            }
            else if(val.YearLevel=="3"){
                level = "3rd Year"
            }
            else if(val.YearLevel=="4"){
                level = "4th Year"
            }

            html += `<tr><td>${val.First_Name+' '+val.Middle_Name+' '+val.Last_Name}</td>`;
            html += `<td>${level}</td>`;
            html += `<td>${val.Course}</td>`;
            html += `<td>${val.total_message}</td>`;
            html += `<td><button class="btn btn-info" onclick="openModal('${val.ref_no}','${val.First_Name+' '+val.Middle_Name+' '+val.Last_Name}')" data-toggle="modal" data-target="#chatinquiryModal">open</button></td></tr>`; 
        })
        $('#chatInquiryTable tbody').append(html);
        // $('#chatInquiryTable').DataTable({
        //     "ordering": true,
        //     "bPaginate": true,
        //     "bLengthChange": false,
        //     "responsive": false
        // });
    }
    async hideWaitMe(){
        $('body').waitMe('hide');
    }
    getData(){
        return this.data;
    }
}

var collegetable = new CollegeTable();

$('#search_table').on('keyup',function(){
    collegetable.filterData(this.value);
})
// $('#chat-box:last-child').css('background','red');
var typing_timeout = null;

function timeSince(date) {
//   date = date.replace(/T/g, " ");
//   date = date.replace(/Z/g, "");
  var seconds = Math.floor((new Date() - new Date(date)) / 1000);
  var duration = getDuration(seconds);
  var suffix = (duration.interval > 1 || duration.interval === 0) ? 's' : '';
  return duration.interval + ' ' + duration.epoch + suffix;
};
var choose_ref = "";
var connectionOptions =  {          
        "transports" : ["websocket"],
        withCredentials: false,
    };
const socket = io('https://stdominiccollege.edu.ph:4003');
// const socket = io('http://localhost:4004');
const app = feathers();
app.configure(feathers.socketio(socket));
var array_status = [];
var status_running = false;

// $("time.timeago").timeago();
// document.getElementById('form#inquiryForm').addEventListener('submit', sendInquiry);
$('#inquiryForm button').on('click',function(){
    // alert('hello');
    if($('#chat-textarea').html()!=""){
        const uuid = uuidv4();
        app.service('chat-inquiry').create({
            message:$('#chat-textarea').html(),
            ref_no:choose_ref,
            type:'admin',
            admin_id:'<?= $this->session->logged_in['userid'];?>',
            return_id:uuid
        });
        sendMessage(uuid);
        $('#chat-textarea').html('');
    }
})
$('#chatinquiryModal').mouseover(function(){
    app.service('chat-inquiry').update(choose_ref,{
        type:'admin',
    });
    // updateToSeen();
})
$('#chat-textarea').on('keydown',function(e){
    
    if(e.keyCode==13){
        e.preventDefault();
        if($('#chat-textarea').html()!=""){
            const uuid = uuidv4();
            app.service('chat-inquiry').create({
                message:$('#chat-textarea').html(),
                ref_no:choose_ref,
                type:'admin',
                admin_id:'<?= $this->session->userdata('logged_in')['userid'];?>',
                return_id:uuid
            });
            sendMessage(uuid);
            $('#chat-textarea').html('');
            // document.getElementById('chat-box').scrollTo(0,document.getElementById('chat-box').scrollHeight);
            // $('.chat-card:last-child').focus();
            
        }
    }
    else{
        app.service('chat-action').create({
            ref_no:choose_ref,
            type:'admin'
        });
    }
})
$.ajax({
    url: "<?php echo base_url(); ?>index.php/StudentInquiry/getCollegeTable",
    method: 'get',
    dataType: 'json',
    success: function(response) {
        // storagedata
        collegetable.updateData(response);
    },
    error: function(response) {
    }
});
setTimeout(()=>{
    console.log(collegetable.getData());
    // alert()
},3000)
// function getStudentTable(){
    
// }

function sendMessage(id){
    var current_time = moment().format('MMM DD,YYYY h:kk a');
    document.getElementById('chat-message').innerHTML = document.getElementById('chat-message').innerHTML
                +`<div class="col-md-12 chat-card" tab-index="1" id="${id}"><div class="chat-admin chat"><div class="message-head">SDCA ADMIN</div><div class="message-time">${current_time}</div><div class="message-body">${$('#chat-textarea').html()}<span class="chat-status"><i id="${id}_icon" class="bi bi-circle not-sent"></i></span></div></div></div>`;
}
function renderIdea(data) {
    var current_time = moment(Date.parse(data.date_created)).format('MMM DD,YYYY h:kk a');
    // +`(${moment(Date.parse(data.date_created)).fromNow()})`;
    // current_time = timeSince(current_time)
        if(data.user_type=="student"){
            document.getElementById('chat-message').innerHTML = document.getElementById('chat-message').innerHTML
                +`<div class="col-md-12 chat-card" tab-index="1"><div class="chat-student chat"><div class="message-head"></div><div class="message-time">${current_time}</div><div class="message-body">${data.message}</div></div></div>`;
        }
        else{   
            document.getElementById('chat-message').innerHTML = document.getElementById('chat-message').innerHTML
            +`<div class="col-md-12 chat-card"><div class="chat-admin chat"><div class="message-head">SDCA ADMIN</div><div class="message-time">${current_time}</time></div><div class="message-body">${data.message}${data.status=="seen"?'<span class="chat-status"><i class="bi bi-check2-all"></i></span>':'<span class="chat-status sent"><i class="bi"></i></span>'}</div></div></div>`;
            
        }
    // }
    
}

// $(document). bind("contextmenu",function(e){ return false; });
async function getInquiryTableList(data){
    // console.log(data)
    // console.log(data.First_Name)
    $('#chatInquiryTable tbody').empty();
    var html = "";
    $.each(data,function(index,val){
        var level = ""
        if(val.YearLevel=="1"){
            level = "1st Year"
        }
        else if(val.YearLevel=="2"){
            level = "2nd Year"
        }
        else if(val.YearLevel=="3"){
            level = "3rd Year"
        }
        else if(val.YearLevel=="4"){
            level = "4th Year"
        }

        html += `<tr><td>${val.First_Name+' '+val.Middle_Name+' '+val.Last_Name}</td>`;
        html += `<td>${level}</td>`;
        html += `<td>${val.Course}</td>`;
        html += `<td>${val.total_message}</td>`;
        html += `<td><button class="btn btn-info" onclick="openModal('${val.ref_no}','${val.First_Name+' '+val.Middle_Name+' '+val.Last_Name}')" data-toggle="modal" data-target="#chatinquiryModal">open</button></td></tr>`; 
    })
    $('#chatInquiryTable tbody').append(html);
}
function updateToSeen(data){
    if(data.ref_no==choose_ref){
        if(data.type=="student"){
            $('.sent').each(function(){
                $(this).removeClass("sent");
                $(this).removeClass("bi-circle");
                $(this).removeClass("bi-check-circle");
                $(this).addClass("bi-check2-all");
            })
        }
    }
}
function setStatus(){
    status_running = true;
    array_status.map(value=>{
        var x = document.getElementById(`${value}_icon`);
        x.classList.remove("bi-circle")
        x.classList.remove("not-sent")
        x.classList.add("bi-check-circle")
        x.classList.add("sent")
        array_status = array_status.filter(this_value => { return this_value!=value });
    })
    status_running = false;
}
window.setInterval(()=>{
    if(status_running==false){
        setStatus()
    }
},2000);
function receivedMessage(data) 
{
    console.log(data)
    // console.log(data.message_count);
    // getInquiryTableList(data.message_count);
    collegetable.filterByDate();
    // collegetable.updateData(data.message_count)
    // collegetable.filterData($('#search_table').val());
    var current_time = moment(Date.parse(data.date_created)).format('MMM DD,YYYY h:kk a');
    // +`(${moment(Date.parse(data.date_created)).fromNow()})`;
    // current_time = timeSince(current_time)
    if(data.user_type=="student"){
        if(choose_ref==data.ref_no){
            document.getElementById('chat-message').innerHTML = document.getElementById('chat-message').innerHTML
                +`<div class="col-md-12 chat-card" tab-index="1"><div class="chat-student chat"><div class="message-head"></div><div class="message-time">${current_time}</div><div class="message-body">${data.message}</div></div></div>`;
        }
    }
    else{   
        array_status.push(data.return_id);
        // document.getElementById('chat-message').innerHTML = document.getElementById('chat-message').innerHTML
        //     +`<div class="col-md-12 chat-card" tab-index="1"><div class="chat-admin chat"><div class="message-head">SDCA ADMIN</div><div class="message-time">${current_time}</time></div><div class="message-body">${data.message}</div></div></div>`;
        
    }
    $('#chat-message').animate({ scrollTop: 100000000000000000000000000000000 }, 'slow');
    // }
    // getInquiryList();
    
}
async function typing(data){
    console.log(data)
    if(choose_ref==data.ref_no){
        if(data.type=='student'){
            $('#someone-typing').show();
            // $('#chatinquiryModal .modal-body').animate({ scrollTop: 100000000000000000000000000000000 }, 'slow');
            if(typing_timeout != null){
                clearTimeout(typing_timeout)
            }
            typing_timeout = setTimeout(function(){
                typing_timeout = null;
                $('#someone-typing').hide();
            },500)
        }
    }
}

async function someone_typing(){
    app.service('chat-action').on('created', typing);
}   
async function init(ref) {
// Find ideas
    const ideas = await app.service('chat-inquiry').get({ref_no:ref,search_date:search_date});
    ideas.forEach(renderIdea);
}

function openModal(ref,name){
    // $('#college_inquiry').iziModal('open');
    choose_ref = ref;
    $('#student-name').text(name);
    $("#chat-message").empty();
    init(ref);
    someone_typing();
    // setTimeout(function(){
        $('#chat-message').animate({ scrollTop: 100000000000000000000000000000000 }, 'slow');
    // },1000)
}
app.service('chat-inquiry').on('created', receivedMessage);
app.service('chat-inquiry').on('updated', updateToSeen);
// getInquiryList();
$('#search_date').on('change',function(){
    // const getFilteredChat = await app.service('chat-change-date').get({search_date:search_date});
    var search_date_value = this.value;
    
    (async() => {
        const getFilteredChat = await app.service('chat-change-date').get({search_date:search_date_value});
        collegetable.updateData(getFilteredChat)
        collegetable.filterData($('#search_table').val());
    })();
})
</script>