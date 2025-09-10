$(document).ready(function(){
    $('.toggle-password').on('click', function() {
        $(this).toggleClass('bi-eye-slash bi-eye');
        var input = $(this).prev('input');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
        } else {
            input.attr('type', 'password');
        }   
    });

    $.ajaxSetup({
        data: {
            [csrfName]: csrfHash
        }
    });
});