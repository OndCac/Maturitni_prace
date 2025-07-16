function sendAjax(action, data = {}, url) {
    data.action = action;
    $.ajax({
        type: "POST",
        url: '../app/controllers/' + url + '_api.php',
        data: data,
        dataType: "json",
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                console.warn("Unexpected response:", response);
            }
        },
        error: function(xhr) {
            console.error(`${action} failed`, xhr.responseText);
        }
    });
}