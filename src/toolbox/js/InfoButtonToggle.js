const HOVER_OVER = "mouseover";
const HOVER_OUT = "mouseout";

var infoIcons = document.getElementsByClassName("info-icon");
var infoLists = document.getElementsByClassName("info-list");



console.log(infoIcons);
console.log(infoLists);

addListenerToInfoBtn();


function addListenerToInfoBtn() {
    for (let i = 0; i < infoIcons.length; i++) {


        infoIcons[i].addEventListener(HOVER_OVER, () => {

            removeHideClassFromInfoPanel(infoLists[i]);
        });

        infoIcons[i].addEventListener(HOVER_OUT, () => {
            addHideClassToInfoPanel(infoLists[i]);
        });
    }
}

function removeHideClassFromInfoPanel(currentInfoList) {
    currentInfoList.classList.remove("hide");
}

function addHideClassToInfoPanel(currentInfoList) {
    currentInfoList.classList.add("hide");
}