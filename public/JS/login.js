(function ($) {
    "use strict";

    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input');

    $('.validate-form').on('submit', function () {
        var check = true;

        for (var i = 0; i < input.length; i++) {
            if (validate(input[i]) == false) {
                showValidate(input[i]);
                check = false;
            }
        }

        return check;
    });


    $('.validate-form .input').each(function () {
        $(this).focus(function () {
            hideValidate(this);
        });
    });

    function validate(input) {
        if ($(input).val().trim() == '') {
            return false;
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }

    /*==================================================================
    [ Show pass ]*/
    var showPass = 0;
    $('.btn-show-pass').on('click', function () {
        if (showPass == 0) {
            $(this).next('input').attr('type', 'text');
            $(this).addClass('active');
            showPass = 1;
        }
        else {
            $(this).next('input').attr('type', 'password');
            $(this).removeClass('active');
            showPass = 0;
        }

    });
})(jQuery);