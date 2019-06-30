



const handleCounting = (e) => {
    let textLength = e.target.parentNode.childNodes[1].value.length;
    let containerIndex = e.target.parentNode.childNodes.length - 2;
    let container = e.target.parentNode.childNodes[containerIndex];
    let span = container.childNodes[3].childNodes[1];
    span.innerText = textLength;
}