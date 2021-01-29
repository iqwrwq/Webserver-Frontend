class DarkmodeToggle {

    darkmodeToggleButtonOn;
    darkmodeToggleButtonOff;

    HTMLHeader;
    HTMLBody;
    displayDirBoxes;
    HTMLCutOff;

    constructor() {

        this.darkmodeToggleButtonOn = document.getElementById("darkmodeToggleOn");
        this.darkmodeToggleButtonOff = document.getElementById("darkmodeToggleOff");

        this.HTMLHeader = document.getElementById("heading");
        this.HTMLBody = document.body;
        this.displayDirBoxes = document.getElementsByClassName("display-dir-box");
        this.HTMLCutOff = document.getElementById("cut-off");

        this.togglers();
    }


    togglers() {
        this.darkmodeToggleButtonOn.addEventListener("click", () => {
            this.deactivateDarkmode();
        });
        this.darkmodeToggleButtonOff.addEventListener("click", () => {
            this.activateDarkmode();
        });
    }

    activateDarkmode() {
        this.darkmodeToggleButtonOn.classList.remove("hide");
        this.darkmodeToggleButtonOff.classList.add("hide");
        this.displayDarkmode();
        this.setDarkModeCookie(true);
    }

    deactivateDarkmode() {
        this.darkmodeToggleButtonOn.classList.add("hide");
        this.darkmodeToggleButtonOff.classList.remove("hide");
        this.displayLightmode();
        this.setDarkModeCookie(false);
    }

    displayDarkmode() {
        this.HTMLHeader.classList.add("darkmode");
        this.HTMLBody.classList.add("darkmode");
        for (let i = 0; i < this.displayDirBoxes.length; i++) {
            this.displayDirBoxes[i].classList.add("darkmode");
        }
        this.HTMLCutOff.classList.add("darkmode");
    }

    displayLightmode() {
        this.HTMLHeader.classList.remove("darkmode");
        this.HTMLBody.classList.remove("darkmode");
        for (let i = 0; i < this.displayDirBoxes.length; i++) {
            this.displayDirBoxes[i].classList.remove("darkmode");
        }
        this.HTMLCutOff.classList.remove("darkmode");
    }

}

const darkmodeToggle = new DarkmodeToggle();