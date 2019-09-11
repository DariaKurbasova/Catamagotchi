showIndicator('.food_indicator span');
showIndicator('.mood_indicator span');
showIndicator('.communication_indicator span');
showIndicator('.energy_indicator span');

function showIndicator(indicatorSelector) {
    let indicator = $(indicatorSelector);
    let width = indicator.data('width') + '%';
    indicator.css('width', width);

    let indicator_change = indicator.siblings('.indicator_change');
    let change_number = indicator_change.data('number');

    if (change_number === 0) {
        indicator_change.css('display', 'none');
    } else if (change_number < 0) {
        indicator_change.css('color', 'red');
    } else {
        indicator_change.css('color', 'green');
        change_number = '+' + change_number;
    }

    indicator_change.text(change_number);
}

$('.show-instruction').click (function () {
    $('.instruction').fadeToggle(500);
});

