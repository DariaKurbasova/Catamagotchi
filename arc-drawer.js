const RADIUS = 45;
const OFFSET = 10;

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
    //svgDiv.appendChild(parseSVG(path));
    svgDiv.appendChild(path);
    // return path;
}

function polarToCartesian(centerX, centerY, angleInDegrees) {
    let angleInRadians = (angleInDegrees - 90) * Math.PI / 180.0;

    return {
        x: centerX + (RADIUS * Math.cos(angleInRadians)),
        y: centerY + (RADIUS * Math.sin(angleInRadians))
    };
}

let svgDiv = document.querySelector('#arc');
drawArc(svgDiv, 0, 72, 'red');
drawArc(svgDiv, 72, 144, 'yellow');
drawArc(svgDiv, 144, 216, 'green');
drawArc(svgDiv, 216, 288, 'purple');
drawArc(svgDiv, 288, 0, 'navy');
let size = (RADIUS + OFFSET) * 2;
svgDiv.setAttribute('width', size + 'px');
svgDiv.setAttribute('height', size + 'px');
svgDiv.innerHTML = svgDiv.innerHTML;
//drawArc(svgDiv, 0, 72, 50, 'red');
// document.querySelector('#arc').appendChild(path);