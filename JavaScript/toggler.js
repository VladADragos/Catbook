let isToggled = false;

const toggle = (e) => {
    const button = e.currentTarget;
    const panel = e.currentTarget.parentNode.childNodes[3];
    if (isToggled) {

        button.style.color = "#a3b7c1";
        panel.style.display = "none";
        isToggled = false;
    } else {
        button.style.color = "hsl(201,50%, 30%)";
        panel.style.display = "block";
        isToggled = true;
    }
}



