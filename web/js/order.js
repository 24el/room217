$(document).ready(function(){
    if($('.priceRadio').is(':checked')){
        alert('Hello');
    }
    $(".orderDelButton").click(function () {
        var orderId = $(this).data('id');
        $(".modal-footer .modalDeleteButton").attr('href', $(this).attr('href')+'&orderId='+orderId);
    });

    $(".requestDelButton").click(function () {
        var orderId = $(this).data('id');
        $(".modal-footer .modalDeleteRequestButton").attr('href', $(this).attr('href')+'&orderId='+orderId);
    });

});
