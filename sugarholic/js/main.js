$(document).ready(function () {
    

    /* all - header sub-menu */ 
    $('.gnb > li').mouseover(function () {
        $('.gnb > li > ul').removeClass('open');
        $(this).children('ul').addClass('open');
    });
    $('.gnb > li').mouseout(function () {
        $('.gnb > li > ul').removeClass('open');
    });
    
    
    /* all - header mobile gnb menu */
    $('.open_btn').on('click', function (e) {

        e.preventDefault();

        $(this).toggleClass('active');
        $('.over').toggleClass('block');
    });


    /* main page - reservation drop down */
    $('#reservation dl').hover(function () {
        $(this).children('dd').toggleClass('open');
    });

    $('#reservation dd').click(function () {
        var amt = $(this).text();
        $(this).siblings('dt').text(amt);
    });


    /* subpage - gallery popup */
    $('.gallery li a').on('click', function(){
        $('.gallery_cover').fadeIn();
        $(this).find('p').css('display', 'none');
        
        var img = $(this).html();
        $('.gallery_cover figure').html(img);
        
    });
    $('.gallery_cover .cls').on('click', function(){
        $(this).parent().fadeOut();
    });


    /* payment - popup on booking */
    $('.make_pay_btn').click(function(e){
        e.preventDefault();
        $('.paid_popup').fadeIn();
    });
    $('.paid_popup p').click(function(e){  
        e.preventDefault();      
        $('.paid_popup').fadeOut();
    });


    /* reservation - toggle on button */
    $('.detail_btn').click(function(){
        $(this).siblings('.detail_cont').slideToggle(300)
    });


    /* login - open join popup on click */
    $('.show_join_popup').click(function(e){
        e.preventDefault();
        $('.join_popup').fadeIn();
    });
    $('.join_popup span').click(function(e){  
        e.preventDefault();      
        $('.join_popup').fadeOut();
        alert('Successfully signed up! :)');
    });
    $('.join_popup p').click(function(e){  
        e.preventDefault();      
        $('.join_popup').fadeOut();
    });
          

    /* main page - slider*/
    $('.slider').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        speed: 1000,
        pauseOnHover: false,
        dots: false,
        arrows: true
    });

});