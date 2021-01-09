$(document).ready(function(){
    //Sets the CSS when ready, like going back
    if(this.scrollY > 20){
        $('.navbar').addClass("sticky");
    }
    
    // scroll-up button show/hide script
    if(this.scrollY > 500){
        $('.scroll-up-btn').addClass("show");
    }
    $(window).scroll(function(){
        // sticky navbar on scroll script
        if(this.scrollY > 20){
            $('.navbar').addClass("sticky");
        }else{
            $('.navbar').removeClass("sticky");
        }
        
        // scroll-up button show/hide script
        if(this.scrollY > 500){
            $('.scroll-up-btn').addClass("show");
        }else{
            $('.scroll-up-btn').removeClass("show");
        }
    });

    // slide-up script
    $('.scroll-up-btn').click(function(){
        $('html').animate({scrollTop: 0});
        // removing smooth scroll on slide-up button click
        $('html').css("scrollBehavior", "auto");
    });

    $('.navbar .menu li a').click(function(){
        // applying again smooth scroll on menu items click
        $('html').css("scrollBehavior", "smooth");
    });

    // toggle menu/navbar script
    $('.menu-btn').click(function(){
        $('.navbar .menu').toggleClass("active");
        $('.menu-btn i').toggleClass("active");
    });

    $(function () {
        $('.input-field input').focusout(function () {
            $(this).next().toggleClass('active', $(this).val() !== "");
        }).focusout(); //trigger the focusout event manually
    });

    // toggleClasses();

    // $('.input-field input').on('focus change paste', function () {
        
    // });

    // $('.input-field input').val(function() {
    //     $(this).next().addClass('active');
    // });

    // //when focused, change label css
    // $('.input-field input').focus(function (e) { 
    //     $(this).next().addClass('active');
    // });

    // $('.input-field input').blur(function(e) {
    //     console.log($(this).next());
    //     if( !$(this).val() ) { //if it is blank. 
    //         $(this).next().removeClass('active');
    //     } else {
    //         $(this).next().addClass('active');
    //     }
    // });

    // owl carousel script
    $('.carousel').owlCarousel({
        margin: 20,
        loop: true,
        autoplayTimeOut: 2000,
        autoplayHoverPause: true,
        responsive: {
            0:{
                items: 1,
                nav: false
            },
            600:{
                items: 2,
                nav: false
            },
            1000:{
                items: 3,
                nav: false
            }
        }
    });
});