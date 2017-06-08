function ajax_function(type,value = ''){
    data = {};
    data[type] = value;

    $.ajax({
        type: 'POST',
        url: 'ajax_conection.php',
        data: data,
        success: function (x) {
            x = x.split("%%");
            $( "#Insert-container" ).html(x[1]);
            if(x[0] == 'true') {
                location.reload();
            }

        }
    });
}