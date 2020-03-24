$('.controls').on('click','.add-to-wishlist',function (e) {
   e.preventDefault();
   addToWishlist($(this),$(this).attr('data-id'));
});

$('.controls').on('click','.remove-from-wishlist',function (e) {
    e.preventDefault();
    removeFromWishlist($(this),$(this).attr('data-id'));
});

function addToWishlist(button, id) {
    $.getJSON(`/wishlist/default/add?id=${id}`,function (json) {
       $('.wishlist span').html(`(${json.counter})`);
       button.replaceWith(`<a href='/wishlist/remove/${id}' class="remove-from-wishlist" data-id="${id}"><i class="fa fa-heart"></i>Remove from wishlist</a>`);
    });
}

function removeFromWishlist(button,id) {
    $.getJSON(`/wishlist/default/delete?id=${id}`,function (json) {
        $('.wishlist span').html(`(${json.counter})`);
        button.replaceWith(`<a href="/wishlist/add/${id}" class="add-to-wishlist" data-id="${id}"><i class="fa fa-heart"></i>Add to wishlist</a>`);
    });
}