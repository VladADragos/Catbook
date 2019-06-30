const imagesDirectory = './images/defaultProfilePictures/';
const selectImage = (e) => {
    let input = document.querySelector(".profile-picture");
    let value = e.target.name;
    let displayImg = document.querySelector("#display-img");
    displayImg.src = imagesDirectory + value;
    displayImg.style.opacity = 1;
    displayImg.style.border = "3px solid white";



    input.value = value;
    handleModal(e);

}
const handleModal = (e) => {
    e.target.style.background = "#002133";
    if (e !== null) {

        e.preventDefault();
    }
    let modal = document.querySelector(".picture-modal");

    if (modal.style.display != "grid") {
        modal.style.display = "grid";
    } else {
        modal.style.display = "none";
    }


}


