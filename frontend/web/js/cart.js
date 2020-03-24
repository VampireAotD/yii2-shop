$('.cart_quantity_up').on('click', function () {
    $(this).next().find('.cart_quantity_input').val(function (i, value) {
        if(value >= 3){
            return value = 3;
        }
        return ++value;
    }).trigger('change');
});

$('.cart_quantity_down').on('click', function () {
    $(this).prev().find('.cart_quantity_input').val(function (i, value) {
        if (value <= 1) {
            return value = 1;
        }
        return --value;
    }).trigger('change');
});

$('.cart_quantity_input').on('change', function () {
    let max = $(this).attr('max');

    if($(this).val() > +max){
        return;
    }

    let params = {
        id : $(this).attr('data-id'),
        amount: $(this).val(),
    };
    $.post('/cart/default/change-amount',params,function (json) {
        $('.total').html(json.total);
    },'JSON');
});