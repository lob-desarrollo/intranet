$(window).scroll(function() {
    if($(this).scrollTop() > 300){ 
        $('.botonSubir').slideDown(300);
    }else{
        $('.botonSubir').slideUp(300);
    }
});