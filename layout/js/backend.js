$(function(){
   'use strict';
   $(".login-page h1 span").click(function(){
     $(this).addClass("selected").siblings().removeClass("selected");
     $(".login-page form").hide();
     $('.'+$(this).data("class")).fadeIn(20);
   });

    //trigger the selectbox
    $("select").selectBoxIt({
        autoWidth:false
    });
   
    $('[placeholder]').focus(function(){
        $(this).attr('data', $(this).attr('placeholder'));
        $(this).attr('placeholder' ,'');
    }).blur(function(){
        $(this).attr( 'placeholder', $(this).attr('data'));
    });


 //add asterisk on required field
 //use each to check all inputs in page

 $('input').each(function () {

    if ($(this).attr('required') === 'required') {

        $(this).after('<span class="asterisk">*</span>');

    }

});


$('.confirm').click(function(){
  return confirm("are you sure");
});


 









});
