/* -------------------------------------------------------------------------- */
/*                                 Data Table                                 */
/* -------------------------------------------------------------------------- */
$(document).ready(function () {
    $("#table").DataTable({
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
/*                              Search with table                             */
/* -------------------------------------------------------------------------- */
function searchTable() {
    let input, filter, table, tr, td, i;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    table = document.getElementById("example");
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
