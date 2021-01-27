const HOVER_OVER = "mouseover";
const HOVER_OUT = "mouseout";

var infoIcons = document.getElementsByClassName("info-icon");
var infoLists = document.getElementsByClassName("info-list");

addListenerToInfoBtn();


function addListenerToInfoBtn() {
    for (let i = 0; i < infoIcons.length; i++) {
        currentInfoIcon = infoIcons[i];
        currentInfoList = infoLists[i];

        currentInfoIcon.addEventListener(HOVER_OVER, () => {
            removeHideClassToInfoPanel(currentInfoList);
        });

        currentInfoIcon.addEventListener(HOVER_OUT, () => {
            addHideClassToInfoPanel(currentInfoList);
        });
    }
}

function removeHideClassToInfoPanel(currentInfoList) {
    currentInfoList.classList.remove("hide");
}

function addHideClassToInfoPanel(currentInfoList) {
    currentInfoList.classList.add("hide");
}