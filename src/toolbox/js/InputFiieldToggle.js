var plusBtn = document.getElementById("btn-add");
var icon = document.getElementById("plu-min");
var inputfield = document.getElementById("add-input-field");
var submitBtn = document.getElementById("btn-submit");


plusBtn.addEventListener("click", () => {

    if (checkIfCurrentIconPlus()) {
        changeIconToMinus();
        toggleInputField(true);

    } else if (checkIfCurrentIconMinus()) {
        changeIconToPlus();
        toggleInputField(false);
    }
});

function checkIfCurrentIconPlus() {
    return icon.classList.contains("fa-plus-circle");
}

function changeIconToMinus() {
    icon.classList.remove("fa-plus-circle");
    icon.classList.add("fa-minus-circle");
}

function toggleInputField(toggle) {
    if (toggle) {
        inputfield.type = "text";
        submitBtn.style.visibility = "visible";
    } else {
        inputfield.type = "hidden";
        submitBtn.style.visibility = "hidden";
    }
}

function checkIfCurrentIconMinus() {
    return icon.classList.contains("fa-minus-circle");
}

function changeIconToPlus() {
    icon.classList.remove("fa-minus-circle");
    icon.classList.add("fa-plus-circle");
}