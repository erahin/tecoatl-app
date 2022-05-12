let a1 = document.getElementById("a1");
let a2 = document.getElementById("a2");
let a3 = document.getElementById("a3");
let a4 = document.getElementById("a4");
let a5 = document.getElementById("a5");
let a6 = document.getElementById("a6");

let liActive = 0;
let liMenu = document.querySelectorAll(".gtr-menu__li");
let faMenu = document.querySelectorAll(".fa__li");
let aMenu = document.querySelectorAll(".nav-link");
let menuRegion = document.querySelectorAll(".menu-region");
const home = document.getElementById("home");

/* -------------------------------------------------------------------------- */
/*                               Initial script                               */
/* -------------------------------------------------------------------------- */
window.oncontextmenu = function () {
    return false;
};
/* -------------------------------------------------------------------------- */
/*                           first letter capitalize                          */
/* -------------------------------------------------------------------------- */
function firstLetterToCapitalize(str) {
    let value = str.value;
    return (str.value = value.charAt(0).toUpperCase() + value.slice(1));
}
/* -------------------------------------------------------------------------- */
/*                              Search with table                             */
/* -------------------------------------------------------------------------- */
function searchTable() {
    let input, filter, table, tr, td, i;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    table = document.getElementById("table");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            let tdata = td[j];
            if (tdata) {
                if (tdata.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
}
/* -------------------------------------------------------------------------- */
/*                             Change class active                            */
/* -------------------------------------------------------------------------- */
liMenu.forEach((element, index) => {
    element.addEventListener("click", function () {
        changeActive(index);
    });
});

function changeActive(index) {
    localStorage.setItem("index", index);
}
function changeActiveMenu(name) {
    if (name != "") {
        if (localStorage.getItem("a") != null) {
            let old = document.getElementById(localStorage.getItem("a"));
            old.classList.remove("active");
        }
        localStorage.setItem("a", name);
    }
}
function activeMenu() {
    if (localStorage.getItem("a") != null) {
        let new_menu = document.getElementById(localStorage.getItem("a"));
        new_menu.classList.add("active");
    }
}
if (a1 != null) {
    a1.addEventListener("click", () => {
        localStorage.removeItem("a");
    });
}
if (a2 != null) {
    a2.addEventListener("click", () => {
        a2.classList.add("active");
        changeActiveMenu("a2");
    });
}
if (a3 != null) {
    a3.addEventListener("click", () => {
        a3.classList.add("active");
        changeActiveMenu("a3");
    });
}
if (a4 != null) {
    a4.addEventListener("click", () => {
        a4.classList.add("active");
        changeActiveMenu("a4");
    });
}
if (a5 != null) {
    a5.addEventListener("click", () => {
        a5.classList.add("active");
        changeActiveMenu("a5");
    });
}
if (a6 != null) {
    a6.addEventListener("click", () => {
        a6.classList.add("active");
        changeActiveMenu("a6");
    });
}

(function () {
    if (
        localStorage.getItem("index") == -1 ||
        localStorage.getItem("index") == undefined
    ) {
        console.log("0");
    } else {
        liMenu[liActive].classList.remove("active");
        liMenu[localStorage.getItem("index")].classList.add("active");
        liActive = localStorage.getItem("index");
        changeActiveMenu("");
        activeMenu();
    }
})();

home.addEventListener("click", () => {
    liMenu[liActive].classList.remove("active");
    localStorage.setItem("index", -1);
    localStorage.removeItem("index");
    localStorage.removeItem("a");
    localStorage.clear();
});
