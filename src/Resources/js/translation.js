$(document).ready(function () {
    var data = {
        controller: 'Translation',
        action: 'getResponse'
    };

    $.ajax({
        method: 'POST',
        url: '/index.php',
        data: data,
        success: function (answ) {
            var response = $.parseJSON(answ);
            if (response.success) {
                console.log(response.data);
            } else {
                alert(JSON.stringify(response.errors));
                console.log(response.errors);
            }
        }
    });
});