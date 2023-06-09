window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }

    const datatablesSimple2 = document.getElementById('datatablesSimple2');
    if (datatablesSimple2) {
        new simpleDatatables2.DataTable(datatablesSimple2);
    }

    const datatables = document.querySelectorAll('.datatables');
    if(datatables.length) {
        datatables.forEach((table, index) => {
            new simpleDatatables.DataTable(table)
        })
    }

});
