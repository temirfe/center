//adminpanel open-close
$('.js_openclose').click(function(){
    $door=$('.js_admpanel-content');
    if($door.is(':visible')){
        $door.slideUp();
        $(this).text('Collapse +');
    }
    else{
        $door.slideDown();
        $(this).text('Hide -');
    }
});

/*$(window).scroll(function() {
    var logo_wrap=$('.js_logo_wrap');
    if ($(window).scrollTop() > 200) {
        logo_wrap.removeClass('logo_wrap_index');
    }
    else {
        logo_wrap.addClass('logo_wrap_index');
    }
});*/

//Check to see if the window is top if not then display button
$(window).scroll(function(){
    if ($(this).scrollTop() > 300) {
        $('.scrollToTop').fadeIn();
    } else {
        $('.scrollToTop').fadeOut();
    }
});

//Click event to scroll to top
$('.scrollToTop').click(function(e){
    e.preventDefault();
    $('html, body').animate({scrollTop : 0},500);
    return false;
});

//add participant
$('.js_add_panelist').click(function (e) {
   e.preventDefault();
   var inp=$('.js_panelist_form').find('div').clone();
    $('.js_panelists').append(inp);
});

//show form
$('.js_register_to_event').click(function (e) {
    e.preventDefault();
    $('.js_attendant_form').show();
    $(this).hide();
});

//facebook share article
$('.js_fb_share').click(function (e) {
    e.preventDefault();
    var link=$(this).attr('href');
    FB.ui({
        method: 'share',
        display: 'popup',
        href: link
    }, function(response){});
});

//twitter share
$('.popup').click(function(event) {
    var width  = 575,
        height = 400,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = this.href,
        title=$(this).attr('title'),
        opts   = 'status=1' +
            ',width='  + width  +
            ',height=' + height +
            ',top='    + top    +
            ',left='   + left;

    window.open(url, title, opts);

    return false;
});

//video
$('.js_vid_thumb').click(function(e){
    e.preventDefault();
    var id=$(this).attr('data-id');
    console.log(id);
    $('.js_vid').hide();
    $('.js_vid[data-video="'+id+'"]').show();
});

//sections
$('.js_sections_toggle').click(function(e){
    e.preventDefault();
    var fa=$(this).find('span');
    var sec=$('.js_sections');
    if(sec.hasClass('js_sec_open')){sec.removeClass('sections_visible js_sec_open'); fa.removeClass('fa-times').addClass('fa-bars');}
    else {sec.addClass('sections_visible js_sec_open');fa.addClass('fa-times').removeClass('fa-bars');}
});

var slider=$('.bxslider');
if(slider.length){
    var bxSlider=slider.bxSlider({
        mode: 'fade',
        captions: true,
        controls:false,
        auto:true,
        autoHover:true,
        onSlideBefore: function($slideElement, oldIndex, newIndex){
            $('.js_sindex').removeClass('bge6');
            $('.js_slide_index_'+newIndex).addClass('bge6');
        }
    });


    $('.js_sindex').mouseover(function(){
        var ind=$(this).attr('data-index');
        var current = slider.getCurrentSlide();
        if(current!==ind){
            bxSlider.goToSlide(ind);
        }
        bxSlider.stopAuto();
    }).mouseout(function(){
        bxSlider.startAuto();
    });
}


$('.bximg').mouseover(function(){$(this).attr('title','');});

$('.js_select_expert_for_opinion').change(function(){
    var val=$(this).val();
    var opi=$('.js_opinionist');
    if(val){opi.hide();}
    else {
        opi.show();
    }
});

$('.js_approve_comment').click(function(){
    var id=$(this).attr('data-id');
    var checked;
    if($(this).is(':checked')){
        checked=1;
    }
    else{
        checked=0;
    }
    $.ajax({
        type: 'POST',
        data: {id:id, checked:checked, _csrf: yii.getCsrfToken()},
        url: '/comment/approve',
        //beforeSend: function () {},
        success:function(data){
            console.log(id+" "+checked);
        }
    });
});