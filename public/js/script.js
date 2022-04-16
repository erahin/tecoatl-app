window.oncontextmenu = function () {
    return false;
};

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
let liActive = 0;
let liMenu = document.querySelectorAll(".gtr-menu__li");
let faMenu = document.querySelectorAll(".fa__li");
let aMenu = document.querySelectorAll(".nav-link");
let menuRegion = document.querySelectorAll(".menu-region");
liMenu.forEach((element, index) => {
    element.addEventListener("click", function () {
        changeActive(index);
    });
});

function changeActive(index) {
    localStorage.setItem("index", index);
}
function changeActiveMenu(index) {
    let region = menuRegion.length;
    if (index >= 0 && index < region) {
        faMenu[0].classList.add("active");
        aMenu[0].classList.add("active");
    }
    if (index >= region && index < region + 6) {
        faMenu[1].classList.add("active");
        aMenu[1].classList.add("active");
    }
    if (index >= region + 6 && index < region + 10) {
        faMenu[2].classList.add("active");
        aMenu[2].classList.add("active");
    }
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
        changeActiveMenu(localStorage.getItem("index"));
    }
})();

const home = document.getElementById("home");
home.addEventListener("click", () => {
    liMenu[liActive].classList.remove("active");
    localStorage.setItem("index", -1);
    localStorage.removeItem("index");
    localStorage.clear();
});
