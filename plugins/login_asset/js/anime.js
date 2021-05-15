var playPause = anime({
    targets:'img.loading',
    loop:true,
    keyframes:[
        {rotate:'360deg'}
    ],
    translateY: {
        value:    ['160px', '0'], 
        duration: 575,
        easing:   'easeInQuad',
      },
    duration:3000,
    autoplay:false
});
playPause.play();