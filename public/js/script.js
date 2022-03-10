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
