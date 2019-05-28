const validate = (e) => {
    let value = e.target.value;
    e.target.style.color = "black";
    if (validateField(value)) {

        return true;

    }
    e.target.style.color = "red";
    return false;
}

const validateField = (string) => {
    string = string.trim();

    if (!(string.length === 0 || string === "")) {
        console.log("length passed");
        console.log(validateChars(string));
        if (!(string.length > 15) && validateChars(string)) {
            return true;
        }
    }
    alert("För långt användarnamn eller lösenord,\nhögst 15 tecken är tillåtet.\nDu har använt " + string.length + " tecken.");
    return false;
}

const validateChars = (string) => {

    const pattern = new RegExp(/[\s \\ \/ < >]/);
    if (pattern.test(string)) {
        alert("Otillåtet tecken i användarnamnet eller lösenordet.\n(mellanslag, \\, /, < eller >)");
        return false;
    }
    return true;

}

console.log(!(4 === 0 || 4 === ""));
