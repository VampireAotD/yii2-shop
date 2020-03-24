$(document).on('click','.add-to-cart', function (e) {
    e.preventDefault();
    addToCart($(this));
});

function addToCart(button) {
    $.getJSON(button.attr('href'), function (json) {
        $('.cart span').html(`(${json.counter})`);
        button.replaceWith('<div class="btn btn-default already-in-cart"><i class="fa fa-shopping-cart"></i> In cart </div>');
    });
}