$('.filterField').change(function(){
    var filterVal = $('.filterForm').serialize();
    alert (filterVal);
    $.ajax({
        ulr: 'orders/active_orders',
        type: "POST",
        data: filterVal,
        success: function(){
            alert('Ok');
        }
    });
});

