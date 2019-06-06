// first set the body to hide and show everyhthing when fully loaded ;)
// document.write("<style>body{display:none;}</style>");

$(document).ready(function () {
    $('input[type="submit"]').addClass('btn btn-primary');
    $('input[type="button"]').addClass('btn btn-primary');
    $('input[type="button"]').removeClass(" btn-default");
    $('input[type="button"]').removeClass("button");
    $('input[type="text"]').addClass('form-control');
    $('input[type="email"]').addClass('form-control');
    $('textarea').addClass('form-control');
});