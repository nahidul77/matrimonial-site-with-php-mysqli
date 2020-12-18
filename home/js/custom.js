$(function () {
    $('.multiple-items').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 1000,
        dots: false,

    });
    $('#main-slider').pogoSlider({
    	autoplay: true,
    	autoplayTimeout: 5000,
    	displayProgess: true,
    	preserveTargetSize: true,
    	targetWidth: 1000,
    	targetHeight: 400,
    	responsive: false
    })
    .data('plugin_pogoSlider');

    var transitionDemoOpts = {
    	displayProgess: false,
    	generateNav: false,
    	generateButtons: false
    }


    

});
