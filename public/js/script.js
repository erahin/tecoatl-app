/* -------------------------------------------------------------------------- */
/*                                 Data Table                                 */
/* -------------------------------------------------------------------------- */
$(document).ready(function () {
    $("#example").DataTable({
        paging: false,
        ordering: true,
        info: false,
        filter: false,
        language: {
            lengthMenu: "Display _MENU_ records per page",
            zeroRecords: "No se encontrarón registros",
            info: "Showing page _PAGE_ of _PAGES_",
            infoEmpty: "No records available",
            infoFiltered: "(filtered from _MAX_ total records)",
        },
    });
});
/* -------------------------------------------------------------------------- */
/*                             Change class active                            */
/* -------------------------------------------------------------------------- */
let liActive = 0;
let liMenu = document.querySelectorAll(".gtr-menu__li");

liMenu.forEach((element, index) => {
    element.addEventListener("click", function () {
        changeActive(index);
    });
});

function changeActive(index) {
    localStorage.setItem("index", index);
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
    }
})();

const home = document.getElementById("home");
home.addEventListener("click", () => {
    liMenu[liActive].classList.remove("active");
    localStorage.setItem("index", -1);
    localStorage.removeItem("index");
    localStorage.clear();
});
