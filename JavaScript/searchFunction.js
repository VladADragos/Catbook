createElement = () => {
  let element = '<section> <a href="./">TEST</a></section>';
  return element;
};
searchfunc = () => {
  let str = event.target.value;
  let out = document.getElementById("suggestion");

  if (str.length == 0) {
    out.innerHTML = "";
    return;
  } else {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        out.innerHTML = createElement();
      }
    };
    xmlhttp.open("GET", "process.php?q=" + str, true);
    xmlhttp.send();
  }
};
