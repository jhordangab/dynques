//initialization components
$.typeahead({
    input: '.js-typeahead-sidebar',
    order: "desc",
    source: {
        data: [
            "Comercial DF", "Compras Estoque", "Company Maintenance", "Operação", "Salão", "Marketing",
            "Corporativo", "Leads", "KPI Comercial", "Insumos"
        ]
    }
});

$(function() {
    $(".selectpicker").select2({
        theme: "bp1"
    });
    $(".selectpicker-noSearch").select2({
        theme: "bp1",
        minimumResultsForSearch: Infinity
    });
    $(".selectpicker-valor").select2({
        theme: "bp1-inline",
        placeholder: "Digite um valor",
        allowClear: true
    });
});

$('#datagrid1').DataTable({
    // scrollY: '22vh',
    scrollCollapse: true,
    paging: false,
    info: false,
    searching: false,
    responsive: true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese.json"
    }
});

$(function() {
    $('.card-consulta').matchHeight();
});