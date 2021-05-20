// Api JS 

function runTestApiRequest() {
    var endpoint = $('#_endpoint').val();
    var method = $('#_method').val() || 'GET';
    if(endpoint.length > 10){
        if(method.length == 3 || method.length == 4){
        $.post(
            '/auth/run-endpoint',
            {endpoint : endpoint, method : method},
            (result) => {
                if(result.status == true){
                    $('#_enpointResult').html(JSON.stringify(result.response, undefined, 2));
                } else {
                    snackBar(result.message, 'danger');
                }
            }).fail(function (e){
            console.log(e);
            snackBar('Could not process your request');
        });
    } else {
        snackBar('Invalid request method');
    }
    } else {
        snackBar('Enter a valid endpoint to run test.', 'danger');
    }
}



function jsonPretty() {
    var elements = document.querySelectorAll('.json-pretty');
    for (let index = 0; index < elements.length; index++) {
        try{
            const element = elements[index];
            var content = JSON.parse(element.innerText);
            $(element).html(JSON.stringify(content, undefined, 2));
            
        } catch(e) {
            
            console.log(e)
        }
    }
}

jQuery(jsonPretty);

























