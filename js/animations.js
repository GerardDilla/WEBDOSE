// var playPause = anime({
//     targets:'img.loading',
//     loop:true,
//     keyframes:[
//         {rotate:'360deg'}
//     ],
//     translateY: {
//         value:    ['160px', '0'], 
//         duration: 575,
//         easing:   'easeInQuad',
//       },
//     duration:3000,
//     autoplay:false
// });
// $('#amazing path').css('display','none')

// var playPause2 = anime({
//     targets: '#amazing path',
//     strokeDashoffset: [anime.setDashoffset, 0],
//     easing: 'easeInOutSine',
//     duration: 1000,
//     delay: function(el, i) { return i * 200 },
//     direction: 'reverse',
//     // loop: false,
//     autoplay:false,
//     begin: function(anim) {
//         $('ul.transition li').css('transform','scaleY(1)');
//         var f = window.setInterval(function(){
//             $('.transition-effect').css('z-index','0');
//             // $('ul.transition li').css( 'transform','scaleY(1)');
//             clearInterval(f);
//             $('.content input.input-material').children(':first').focus();
//             $('.content input.input-material').children(':first').addClass('active');
//             console.log($('.content input.input-material').children(':first'));
//         },1000);
        
//       }
//   });
// $('.transition-effect').css('z-index','0');
// $('#amazing path').css('display','none')
$('#amazing').css('z-index','0')
// var startEffect = window.setInterval(function(){
//       $('.transition-effect').css('z-index','0');
//       $('.content input.input-material').children(':first').focus();
//       $('.content input.input-material').children(':first').addClass('active');
//       console.log($('.content input.input-material').children(':first'));
//       clearInterval(startEffect);
      
//   },1000)
  $(window).on('beforeunload',function(){
    // console.log('wazzup');
    // var playPause = anime({
    // targets: '#amazing path',
    // strokeDashoffset: [anime.setDashoffset, 0],
    // easing: 'easeInOutSine',
    // duration: 1000,
    // delay: function(el, i) { return i * 200 },
    // direction: 'normal',
    // // loop: false,
    // autoplay:true,
        
    // });
    // playPause.play();
    // gsap.to('.form-holder',{opacity:0,duration:1,y:-50});
    // gsap.to('.anim1',{opacity:0,duration:1,y:-50,stagger:0.6});
    // gsap.to('.anim2',{opacity:0,duration:1,y:-50,stagger:0.6});
    // gsap.to('.anim3',{opacity:0,delay:.5,duration:1,y:-50,stagger:0.3});
    // var t1 = gsap.timeline();
    // t1.to('ul.transition li',{duration:.2,scaleY:1,transformOrigin:"bottom left",stagger:.1,delay:.1});
    // $('.transition-effect').css('z-index','1001');
    // $('#amazing').css('z-index','1002');
});
//   playPause.play();
//   alert('hello');
$(document).ready(function(){
    gsap.from('.form-holder',{opacity:0,duration:1,y:-50});
    gsap.from('.anim1',{opacity:0,duration:1,y:-50,stagger:0.6});
    gsap.from('.anim2',{opacity:0,duration:1,y:-50,stagger:0.6});
    gsap.from('.anim3',{opacity:0,delay:.5,duration:1,y:-50,stagger:0.3});
    // playPause.play();
    if( /Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $('ul.transition li').css('transform','scaleY(0)')
    }
    else{
    var t1 = gsap.timeline();
    t1.to('ul.transition li',{duration:.1,scaleY:1,transformOrigin:"bottom left"});
    t1.to('ul.transition li',{duration:.2,scaleY:0,transformOrigin:"bottom left",stagger:.1,delay:.1});
    }
    // var setInterval = window.setInterval(function(){ 
    //     $('#loading').hide();
    //     $('.loading').hide();
    //     clearInterval(setInterval);
    //     alert('1');
    // }, 2000);
});
// $('.leave_button').on('click',function(){
//     var setInterval2 = window.setInterval(function(){ 
        
//         // alert('1');
//         clearInterval(setInterval2);
//         // playPause();
//     }, 100);
//     gsap.to('.form-holder',{opacity:0,duration:1,y:-50});
//     gsap.to('.anim1',{opacity:0,duration:1,y:-50,stagger:0.6});
//     gsap.to('.anim2',{opacity:0,duration:1,y:-50,stagger:0.6});
//     gsap.to('.anim3',{opacity:0,delay:.5,duration:1,y:-50,stagger:0.3});
//     var t1 = gsap.timeline();
//     t1.to('ul.transition li',{duration:.2,scaleY:1,transformOrigin:"bottom left",stagger:.1,delay:.1});
// });