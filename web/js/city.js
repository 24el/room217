$(document).ready(function(){

    $(".cityChangeSelect").change(function() {
        var city = $(".cityChangeSelect").val();
<<<<<<< HEAD
        $(location).attr('href', document.baseURI+'/delivery/city_change?city='+city);
=======
        $(location).attr('href', 'http://localhost/basic/web/delivery/city_change?city='+city);
>>>>>>> def8989fc1dd8e872e1784ba8778b92e1d803d69
    });



        $('.filterField').keyup(function(){
            $('#filterRefresh').click();
        });

        $(window).scroll(function(){
            var inProcess = false;

            var offset = 10;

            if($(window).scrollTop() + $(window).height() >= $(document).height() - 100 && !inProcess){
                $.ajax({
                    url: "http://localhost/basic/web/index.php?r=orders%2Ffilter_orders",
                    method: "POST",
                    data: {"offset": offset},
                    beforeSend: function(){
                        inProcess = true;
                    }
                }).done(function(data){
                    data = JQuery.parseJSON(data);
                    if(data.length > 0){
                        $.each(data, function(index, data){
                            $('.order').append("<p class='text-primary' style='margin:100px;'>"+data.title+"</p>");
                        });
                    }
                    inProcess = false;
                    offset += 10;
                });
            }
        });


});