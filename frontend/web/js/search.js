$(function () {
    $('.search-input').on('keyup', function (e) {
        if (e.keyCode === 13) return false

        let value = $(this).val()

        if (value.length >= 3) {
            $.getJSON('/ajax/search', {value}, function (response) {
                $('.search-items').empty();

                if (response.status) {
                    $.each(response.items, function (index, item) {
                        let information = item._source

                        $('.search-items').append(`
                            <div class="search-item">
                                <a href="/good/${information.id}">
                                    <div class="desc">
                                        <img src="http://yiishop/uploads/${information.image}" alt="${information.name}">
                                        <div class="inner">
                                            <span>${information.name}</span>
                                            <p>${information.price}</p>
                                            <p>${information.description}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        `);
                    });
                }
            }, 'JSON');
        }
    });
});