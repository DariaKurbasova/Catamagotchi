const RADIUS = 45;
const OFFSET = 10;
const SVG_SIZE = (RADIUS + OFFSET) * 2;

// Тут можно придумать какую-то фиксированную цветовую схему, чтобы каждое деление чуть отличалось цветом.
// Проще всего использовать rgba, выбрать один цвет и менять лишь прозрачность
const COLORS_FILLED = [
    'rgba(20, 20, 200, 0.5)',
    '#99d',
    '#88c',
    '#66b',
    '#44b',
    '#2323d5',
    '#000097',
];
const COLORS_NOT_FILLED = [
    'rgba(131, 57, 161, 0.5)',
    '#e8bde2',
    '#cb8ed2',
    '#c576d2',
    '#af4ad2',
    '#9a02cc',
    '#7902A9',
];

/**
 * Рисует одну дугу
 * @param svgDiv  Блок svg, в котором рисует
 * @param angleFrom  Угол, с которого начинаем (от 12 часов)
 * @param angleTo  Угол, которым заканчиваем
 * @param color  Цвет
 */
function drawArc(svgDiv, angleFrom, angleTo, color) {
    let centerX = RADIUS + OFFSET;
    let centerY = RADIUS + OFFSET;
    let start = polarToCartesian(centerX, centerY, angleFrom);
    let end = polarToCartesian(centerX, centerY, angleTo);

    let path = document.createElement('path');
    path.setAttribute('stroke-width', '8');
    path.setAttribute('stroke', color);
    path.setAttribute('fill', 'transparent');
    let d = [
        'M', start.x, start.y, 'A', RADIUS, RADIUS, 0, 0, 1, end.x, end.y
    ];

    d = d.join(' ');
    path.setAttribute('d', d);
    svgDiv.appendChild(path);
}

/**
 * Переводит полярные координаты в Х, У
 * @param centerX
 * @param centerY
 * @param angleInDegrees
 * @returns {{x: *, y: *}}
 */
function polarToCartesian(centerX, centerY, angleInDegrees) {
    let angleInRadians = (angleInDegrees - 90) * Math.PI / 180.0;

    return {
        x: centerX + (RADIUS * Math.cos(angleInRadians)),
        y: centerY + (RADIUS * Math.sin(angleInRadians))
    };
}

/**
 * Рисует несколько дуг
 * @param svgDiv   Блок svg, в котором рисуем
 * @param totalArcs  Общее количество дуг
 * @param filledCount  Сколько из них закрашены (тут логику надо продумать)
 */
function drawArcs(svgDiv, totalArcs, filledCount) {
    let angle = 360 / totalArcs;
    for (let i = 1; i <= totalArcs; i++) {
        // todo - Придумать, как выделять закрашенные и незакрашенные деления (цвета, прозрачность?)
        drawArc(svgDiv, (i - 1) * angle, i * angle, i > filledCount ? COLORS_FILLED[i] : COLORS_NOT_FILLED[i]);
    }
}

let reloadDivs = document.querySelectorAll('div.reloading');
reloadDivs.forEach(el => {
    let dataset = el.dataset;
    if (dataset && dataset.reloadLeft && dataset.reloadMax && parseInt(dataset.reloadLeft) > 0) {
        el.setAttribute('title', 'Перезаряжается, осталось ходов: ' + dataset.reloadLeft + ' из ' + dataset.reloadMax);
        let svgDiv = document.createElement('svg');
        drawArcs(svgDiv, dataset.reloadMax, dataset.reloadLeft);
        svgDiv.style.width =  SVG_SIZE + 'px';
        svgDiv.style.height =  SVG_SIZE + 'px';

        el.appendChild(svgDiv);

        // Бред какой-то, но без этой строки svg добавится, но не отобразится
        el.innerHTML = el.innerHTML;
    }
});

// let svgDiv = document.querySelector('#arc');
/*drawArc(svgDiv, 0, 72, 'red');
drawArc(svgDiv, 72, 144, 'yellow');
drawArc(svgDiv, 144, 216, 'green');
drawArc(svgDiv, 216, 288, 'purple');
drawArc(svgDiv, 288, 0, 'navy');*/

// drawArcs(svgDiv, 7, 3);


