$(function(){
   'use strict';
    $('[placeholder]').focus(function(){
        $(this).attr('data', $(this).attr('placeholder'));
        $(this).attr('placeholder' ,'');
    }).blur(function(){
        $(this).attr( 'placeholder', $(this).attr('data'));
        /*$(function(){
    'use strict';
     $('[placeholder]').focus(function(){
         $(this).attr('data','username');
         $(this).attr('placeholder' ,'');
     }).blur(function(){
         $(this).attr( 'placeholder','username');
     });
 });*/

    });


 //add asterisk on required field
 //use each to check all inputs in page
 $('input').each(function () {

    if ($(this).attr('required') === 'required') {

        $(this).after('<span class="asterisk">*</span>');

    }

});
//convert password field to text field on hover
var pass =$('.password');
$('.show-pass').hover(function(){
  pass.attr('type','text');
},function(){
    pass.attr('type','password');

});

$('.confirm').click(function(){
  return confirm("are you sure");
});














});
