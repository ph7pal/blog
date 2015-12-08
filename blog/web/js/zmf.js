if ($.support.pjax) {    
    $(document).pjax('a:not([data-remote]):not([data-skip-pjax]):not([data-ajax=false]):not([target=_blank])', '#pjax-container', {
        push:true,
        scrollTo:0,
        fragment:'#pjax-container', 
        timeout:5000
    });
    $(document).on('pjax:send', function() {
        NProgress.start();
    });
    $(document).on('pjax:complete', function() {
        NProgress.done();
        $("body,html").animate({
            scrollTop: 0
        });
    });
}