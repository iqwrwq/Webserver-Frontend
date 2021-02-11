var date = new Date();
date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
const SESSION_EXPIRES_LONG = ";expires=" + date.toGMTString();

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

        this.initialize();
        this.togglers();


    }

    initialize() {
        if (!document.cookie || document.cookie.length === 0 || document.cookie === "darkmode=false") {
            document.cookie = "darkmode=false" + SESSION_EXPIRES_LONG;
        } else if (document.cookie === "darkmode=true") {
            this.activateDarkmode();
        }
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

    setDarkModeCookie(state) {
        if (state) {
            document.cookie = "darkmode=true" + SESSION_EXPIRES_LONG;
        } else {
            document.cookie = "darkmode=false" + SESSION_EXPIRES_LONG;
        }
    }





}

const darkmodeToggle = new DarkmodeToggle();