var handler = window.handler;
var post_redirect = window.post_redirect;
var post_redirect_params = window.post_redirect_params;
var post_redirect_querystring = window.post_redirect_querystring;

$(function() {
    const formEl = $('#form');
    formEl.on('submit', function(e) {
        e.preventDefault();
        if (!$(this).valid()) return;
        $.ajax({
            type: 'POST',
            url: `${base_url}/{{ cookiecutter.module_slug }}/create`,
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function() {
                AmagiLoader.show();
            },
            success: function(response) {
                if (response.status) {
                    swal.fire({
                        title: 'Success!',
                        text: response.message,
                        type: 'success'
                    }).then(function () {
                        if(post_redirect){
                            window.location.assign(post_redirect + response[post_redirect_params] + post_redirect_querystring);
                        }else{
                            window.location.reload();
                        }
                    });
                } else {
                    swal.fire({
                        title: 'Oops!',
                        html: response.message,
                        type: 'error'
                    });
                }
            },
            error: function(response) {
                Swal.fire({
                    title: 'Failed!',
                    text: 'Error has occurred, Please try again later.',
                    icon: 'error'
                });
            },
            complete: function() {
                AmagiLoader.hide();
            }
        });
    });
});