function pageTransition(){
    var t1 = gsap.timeline();
    t1.to('ul.transition li',{duration:.2,scaleY:1,transformOrigin:"bottom left",stagger:.2});
    t1.to('ul.transition li',{duration:.2,scaleY:0,transformOrigin:"bottom left",stagger:.1,delay:.1});

    t1.from('.anim2',{duration:.1,translateY:50,opacity:0});
    t1.from('.anim3',{duration:.1,translateY:50,opacity:0});
    t1.to('img',{clipPath:"polygon(0 0,100% 0,100% 100%,0 100%)"});
}
// pageTransition();
function delay(n){
    n = n || 2000;
    return new Promise(done => {
        setTimeout(()=>{
            done();
        },n);
    });
}
function contentAnimation(){
    // var t1 = gsap.timeline();
    gsap.from('.form-holder',{duration:1.5,translateY:50,opacity:0});
    gsap.from('.anim2',{duration:1.5,translateY:50,opacity:0});
    gsap.from('.anim3',{duration:1.5,translateY:50,opacity:0});
    gsap.to('img',{clipPath:"polygon(0 0,100% 0,100% 100%,0 100%)"});
    return gsap;
}
$(function() {
    barba.init({
        sync:true,
        transitions:[{
            async leave(data){
                alert('hello');
                const done = this.async();
                pageTransition();
                await delay(1500);
                done();
            },
            async enter(data){
                contentAnimation();
            },
            async enter(data){
                contentAnimation();
            }
        }]
    });
});