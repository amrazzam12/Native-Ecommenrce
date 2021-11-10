
$(function() {

'use strict';



$('input[placeholder]').focus( function () {

    $(this).attr('data-text' , $(this).attr('placeholder'));
    $(this).attr('placeholder' , "");
}).blur(function () {
    $(this).attr('placeholder' , $(this).attr('data-text'));
});



$(".title").keyup(function() {

    $(".live-title").text($(".title").val());

});

$(".desc").keyup(function() {

    $(".live-desc").text($(".desc").val());

});


$(".price").keyup(function() {

    $(".live-price").text("$"  + $(".price").val());

});









});