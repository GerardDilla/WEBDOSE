<!-- <body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="">DOSE SYSTEM</a>
            <small>Admin Side</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" method="POST" action="">
                    <div class="msg">Sign in to start your session</div>
                    
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                    </div>

                    <h3><span class="label label-danger"><?php echo $this->session->flashdata('login_message'); ?></span></h3>
                    
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-xs-4">
                           
                          <button class="btn btn-block bg-red waves-effect" type="submit">SIGN IN</button> 
                       
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                          
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="forgot-password.html">Forgot Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
     -->
<!-- <body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="">DOSE SYSTEM</a>
            <small>Admin Side</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" method="POST" action="">
                    <div class="msg">Sign in to start your session</div>
                    
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                    </div>

                    <h3><span class="label label-danger"><?php echo $this->session->flashdata('login_message'); ?></span></h3>
                    
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-xs-4">
                           
                          <button class="btn btn-block bg-red waves-effect" type="submit">SIGN IN</button> 
                       
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                          
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="forgot-password.html">Forgot Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
     -->
<style>
    .head-title-1{
        position:absolute;
        top:10%;
        left:6%;
        color:white;
        font-size:2em;
        font-weight:bold;
        text-shadow: 2px 2px black;
    }
    .head-title-2{
        position:absolute;
        padding-top:100px;
        font-size:1.4em;
        top:10%;
        left:6%;
        color:white;
    }
</style>
<body data-barba="wrapper">
<svg class="transition-effect" width="475" height="116" viewBox="0 0 475 116" fill="none" xmlns="http://www.w3.org/2000/svg" id="amazing">
    <path d="M93.6604 94.9991L93.6627 94.9974C103.855 87.7316 108.836 76.2653 108.836 60.944V46.256C108.836 31.2056 103.796 19.8475 93.5243 12.4946C83.4959 5.2473 70.1958 1.69998 53.768 1.69998H7.832C6.36566 1.69998 5.07567 2.251 4.03534 3.29133C2.99501 4.33165 2.444 5.62164 2.444 7.08798V100.112C2.444 101.578 2.99501 102.868 4.03534 103.909C5.07567 104.949 6.36567 105.5 7.832 105.5H53.768C70.376 105.5 83.7243 102.054 93.6604 94.9991ZM64.1713 35.7338L64.1939 35.7531L64.2173 35.7715C66.4857 37.5538 67.676 40.1096 67.676 43.664V63.536C67.676 67.0886 66.4854 69.708 64.1939 71.5913C61.9502 73.4182 58.7736 74.42 54.488 74.42H42.884V32.78H54.488C58.7608 32.78 61.9283 33.8231 64.1713 35.7338Z" stroke="#F14242" stroke-width="3"/>
    <path d="M137.322 102.162L137.328 102.166C147.895 109.771 161.832 113.5 179 113.5C196.166 113.5 210.055 109.772 220.524 102.164C231.24 94.4503 236.5 82.5358 236.5 66.7347V48.2653C236.5 37.8256 233.979 29.02 228.837 21.9497C223.736 14.9352 216.819 9.7698 208.142 6.44498C199.609 3.13687 189.886 1.5 179 1.5C168.112 1.5 158.341 3.13732 149.711 6.44372C141.026 9.77079 134.107 14.9912 129.007 22.1097L129.004 22.113C123.966 29.1846 121.5 38.0374 121.5 48.5681V66.4319C121.5 82.4224 126.701 94.4421 137.322 102.162ZM189.164 37.1419L189.186 37.1613L189.21 37.1797C191.601 39.0693 192.855 41.7808 192.855 45.5403V69.4597C192.855 73.2167 191.601 75.9942 189.187 77.9897C186.826 79.9238 183.489 80.9792 179 80.9792C174.52 80.9792 171.121 79.9277 168.65 77.98C166.359 76.0977 165.145 73.3845 165.145 69.6111V45.3889C165.145 41.6155 166.359 38.9024 168.65 37.0201C171.121 35.0723 174.52 34.0208 179 34.0208C183.476 34.0208 186.803 35.1196 189.164 37.1419Z" stroke="#F14242" stroke-width="3"/>
    <path d="M327.28 110.139L327.288 110.136L327.295 110.133C335.674 107.111 342.305 102.804 347.102 97.1666C352.03 91.3912 354.5 84.6284 354.5 76.9444C354.5 69.999 352.951 64.0882 349.753 59.3053C346.545 54.5053 341.423 50.731 334.55 47.9058C327.778 45.0808 318.838 43.0733 307.784 41.8431C300.004 40.9275 294.959 40.0768 292.509 39.3128C290.011 38.426 289.64 37.5423 289.64 37.0694C289.64 36.6733 289.748 36.3789 289.949 36.122C290.167 35.8432 290.558 35.5305 291.237 35.241C292.627 34.6484 294.892 34.2917 298.176 34.2917C301.222 34.2917 303.28 34.5993 304.5 35.0972C305.844 35.6456 306.986 36.3665 307.941 37.2527L307.957 37.2676L307.974 37.2821C309.618 38.7191 311.509 39.4861 313.605 39.4861H345.81C347.172 39.4861 348.435 39.1052 349.386 38.161C350.416 37.2395 350.905 36.0101 350.905 34.625C350.905 29.4786 348.652 24.3622 344.414 19.3008C340.125 14.1799 333.963 9.98361 326.025 6.66111C318.013 3.20525 308.718 1.5 298.176 1.5C288.045 1.5 279.066 2.99812 271.269 6.03269L271.269 6.03267L271.262 6.03515C263.573 9.06782 257.54 13.3385 253.25 18.8881C248.945 24.4568 246.795 30.8933 246.795 38.1389C246.795 48.3489 250.632 56.4025 258.338 62.1083L258.338 62.1083L258.349 62.1163C265.927 67.6224 276.697 71.1359 290.509 72.7811L290.512 72.7815C296.589 73.4928 301.117 74.1983 304.131 74.8923L304.158 74.8986L304.186 74.9039C307.358 75.5106 309.249 76.2266 310.147 76.9136L310.202 76.9558L310.261 76.9927C311.249 77.613 311.506 78.2059 311.506 78.7778C311.506 79.1987 311.238 79.9724 309.002 80.6685C306.852 81.3379 303.479 81.7083 298.775 81.7083C295.046 81.7083 292.249 81.4573 290.325 80.9948C288.496 80.4562 286.823 79.4745 285.3 78.0159C283.684 76.3772 281.586 75.5972 279.153 75.5972H248.445C247.113 75.5972 245.905 76.0156 244.911 76.8846L244.868 76.9226L244.828 76.9638C243.902 77.9075 243.5 79.127 243.5 80.4583C243.5 86.7352 245.632 92.5095 249.821 97.7429L249.825 97.7488L249.83 97.7546C254.046 102.915 260.349 106.965 268.602 109.978C276.903 113.01 286.975 114.5 298.775 114.5C309.395 114.5 318.903 113.056 327.28 110.139Z" stroke="#F14242" stroke-width="3"/>
    <path d="M471.761 80.8894C470.688 79.817 469.36 79.25 467.85 79.25H409.5V72.8H458.1C459.61 72.8 460.938 72.233 462.011 71.1607C463.083 70.0883 463.65 68.7603 463.65 67.25V47.75C463.65 46.2397 463.083 44.9117 462.011 43.8393C460.938 42.767 459.61 42.2 458.1 42.2H409.5V35.75H466.35C467.86 35.75 469.188 35.183 470.261 34.1107C471.333 33.0383 471.9 31.7103 471.9 30.2V9.05C471.9 7.53967 471.333 6.21168 470.261 5.13935C469.188 4.06702 467.86 3.5 466.35 3.5H373.05C371.54 3.5 370.212 4.06702 369.139 5.13935C368.067 6.21167 367.5 7.53966 367.5 9.05V105.95C367.5 107.46 368.067 108.788 369.139 109.861C370.212 110.933 371.54 111.5 373.05 111.5H467.85C469.36 111.5 470.688 110.933 471.761 109.861C472.833 108.788 473.4 107.46 473.4 105.95V84.8C473.4 83.2897 472.833 81.9617 471.761 80.8894Z" stroke="#F14242" stroke-width="3"/>
</svg>

<ul class="transition transition-effect">
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
</ul>

<div class="content wrapper" data-barba="wrapper">
    <main data-barba="container" data-barba-namespace="<?php echo $Title;?>">
        <div class="page login-page page-1">
            <div class="container d-flex align-items-center">
                <div class="form-holder has-shadow">
                    <div class="row bg-white">
                        <div class="col-lg-7 col-md-7 col-sm-12 first_row login-row">
                            <!-- <div class="info d-flex align-items-center">
                            <div class="content title-content">
                                <div class="logo">
                                <image class="logo-white anim1" src="<?php echo base_url('assets/vendors/login_asset/img/DOSE_FINAL DESIGN.png');?>">
                                </div>
                                <h1 class="main-title anim1">One Stop Enrollment</h1>
                            </div>
                            </div> -->
                            
                            <!-- <span class="enrollment">Enrollment</span>
                            <span class="made_easy">MADE EASY!</span> -->
                            <span class="head-title-1">Revolutionizing <br> Education</span>
                            <span class="head-title-2">since 2003</span>
                            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                        </div>
                        <!-- Form Panel    -->
                        <div class="col-lg-5 col-md-5 col-sm-12 second_row login-row" >
                            <div class="col-md-12 admin-dashboard">ADMIN DASHBOARD</div>
                            <image class="dose-logo" src="<?php echo base_url('plugins/login_asset/css/img/DOSE LOGO.png');?>">
                            <div class="form d-flex">
                                <div class="content">
                                    <form id="sign_in" class="form-validate" method="POST" action="">
                                    <span class="white-box"></span>
                                    <div class="col-md-12" style="margin-bottom:20px;text-align:center;">
                                        <h1 class="anim2">SIGN IN</h1>
                                    </div>
                                    <div class="form-group anim3">
                                        <input required autocomplete="off" id="login-username" type="text" name="username" required data-msg="Please enter your username" class="input-material">
                                        <label for="login-username" class="label-material label-color" style="color:black;font-weight:bold;">User Name</label>
                                    </div>
                                    <div class="form-group anim3">
                                        
                                        
                                        <input autocomplete="off" id="login-password" type="password" name="password" required data-msg="Please enter your password" class="input-material">
                                        <label for="login-password" class="label-material label-color" style="color:black;font-weight:bold;">Password</label>
                                        <span class="show-password">
                                            <i id="show_password" class="bi bi-eye-fill" onclick="showPassword('password')" aria-hidden="true"></i>
                                        </span>
                                        
                                        
                                    </div>
                                    <h5><a href="javascript:void(0)" onclick="forgotPassword2()" class="forgot-pass leave_button">Forgot Password?</a></h5>
                                    <div align="center" style="margin-top:20px;">
                                        <button id="login" type="submit" class="btn btn-danger btn-sm submit-button">Login</button>
                                    </div>
                                    <div class="col-md-12">
                                    
                                    </div>
                                    </form>
                                </div>
                            </div>
                            <!-- <?php echo base_url('main/forgotpassword')?> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://unpkg.com/@barba/core"></script>
<script src="<?php echo base_url('js/barba.js')?>"></script>
<script src="<?php echo base_url('js/animations.js')?>"></script>
<script>
$('form').on('submit',function(){
    var count = 0;
    $('.input-material').each(function(){
        if($(this).val()==""){
            ++count;
        }
    })
    if(count==0){
        $('#login').attr('disabled','disabled');
    }
});
function showPassword(id){
    var x = document.querySelector(`[name=${id}]`);
    var icon = document.getElementById('show_'+id);

    if (x.type === "password") {
        x.type = "text";
        icon.classList.remove("bi-eye-fill")
        icon.classList.add("bi-eye-slash")
    } else {
        x.type = "password";
        icon.classList.remove("bi-eye-slash")
        icon.classList.add("bi-eye-fill")
    }
}
// alert("<?php echo $this->session->flashdata('login_message');?>")
</script>
</body>
<?php
if($this->session->flashdata('login_message')){
    echo "<script>
    iziToast.warning({
        title: 'Error: ',
        message: '".$this->session->flashdata('login_message')."',
        position: 'topCenter',
    });
    </script>";
    $this->session->set_flashdata('login_message','');
}
?>
