
$(function() {
  ( <any>$('.dropdown-toggle')).dropdown();
  $('#menu-bar').on('click', function(ev) {
    console.log(ev);
    $(ev.currentTarget).toggleClass("change");
    $('#nav').toggleClass("change");
    $('#menu-bg').toggleClass("change-bg");
    $('body').toggleClass("menu-open");
  })
})



