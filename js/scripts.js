$('.list > li a').click(function() {
    $(this).parent().find('ul').toggle();
});