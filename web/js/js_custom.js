$(document).ready(function()
{
    $('.modal_import_balancete').click(function () 
    {
        var url = $(this).attr("data-link");
        var title = $(this).attr("data-title");
        $('#iframe_modal_import_balancete').attr('src', url);
        $("[id^='modalimport_balancete']").modal("show");
        $('.modal-backdrop').removeClass('modal-backdrop');
        $('#modalimport_balancete .modal-header h3').text(title);
    });
    
    $("[id^='modalimport_balancete']").on('hidden.bs.modal', function () 
    {
        window.location.reload();
    });
});