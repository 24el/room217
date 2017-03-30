$(document).ready(function(){
    $(".requestCancelButton").click(function () {
        var requestId = $(this).data('id');
        $(".modal-footer .modalCancelReqButton").attr('href', $('.modalCancelReqButton').attr('href')+'&requestId='+requestId);
    });
});
