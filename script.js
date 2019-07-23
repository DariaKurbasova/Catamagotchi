showIndicator('.food_indicator span');
showIndicator('.mood_indicator span');
showIndicator('.communication_indicator span');

function showIndicator(indicatorSelector) {
    let indicator = document.querySelector(indicatorSelector);
    let width = indicator.dataset.width + '%';
    indicator.style.width = width;
}