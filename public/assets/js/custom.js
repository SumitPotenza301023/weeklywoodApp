/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */
if (window.location.href.indexOf('www') === -1) {
    window.location.href = 'https://www.weeklywodthrowdown.com/backend/';
}
tinymce.init({
    selector: '#new-page-content',
    height: 500,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help | paste',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});

/**
/**
 * =======================================================================
 *  Admin login ajax
 * =======================================================================
 */
$(function () {

    jQuery('.loader').bind('ajaxStart', function () {
        $(this).show();
    }).bind('ajaxStop', function () {
        $(this).hide();
    });

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('loggedin')) {
        iziToast.success({
            title: 'WELCOME',
            message: 'SUCCESSFULLY LOGGED IN',
            position: 'topRight'
        });
    }
    $('#login_form').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($('#login_form')[0]);
        // console.log( formData );

        url = weekly.config.login;
        jQuery.ajax({
            url: url,
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.success == false) {
                    iziToast.error({
                        title: 'INVALID CRIDENTIALS',
                        message: data.message,
                        position: 'topRight'
                    });

                } else if (data.success == true) {
                    window.location.href = base_url + "/admin/dashboard?loggedin=true";
                }

            }
        });


    });

    /**
     * =======================================================================
     *  Delete User Account
     * =======================================================================
     */

    $('#deleteAccount_form').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($('#deleteAccount_form')[0]);

        $('#deleteAccount_form').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5
                },
            },
            messages: {
                email: {
                    required: "Please enter a email address",
                    email: "Please enter a valid email address"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        if ($(this).valid()) {
            swal({
                title: 'Are you sure?',
                text: 'Once deleted, you will not be able to recover this account',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    url = weekly.config.delete_account;
                    jQuery.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        async: false,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function (data) {
                            if (data.success == false) {
                                iziToast.error({
                                    title: 'INVALID CRIDENTIALS',
                                    message: data.message,
                                    position: 'topRight'
                                });

                            } else if (data.success == true) {
                                // iziToast.success({
                                //     title: 'ACCOUNT DELETED',
                                //     message: data.message,
                                //     position: 'topRight'
                                // });
                                window.location.href = base_url + "/delete-account";
                            }
                        }
                    })
                }
            })
        }
    });
});


/**
 * =======================================================================
 *  Admin Update profile ajax
 * =======================================================================
 */
$('#edit_admin_form').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#edit_admin_form')[0]);

    jQuery.ajax({
        url: weekly.config.updateprofile,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });


                setTimeout(
                    function () {
                        window.location.href = base_url + "/admin/profile?profileupdate=true";
                    }, 5000);

            }
        }
    });
});

/**
 * ========================================================================
 * RESET PASSWORD AJAX
 * ========================================================================
 */
$('#edit_password_form').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#edit_password_form')[0]);

    jQuery.ajax({
        url: weekly.config.resetpassword,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });


                setTimeout(
                    function () {
                        window.location.href = base_url + "/admin/reset-password";
                    }, 5000);

            }
        }
    });
});
/**
 * ========================================================================
 * Send Reset password Link Ajax
 * ========================================================================
 */
$('#forgot_form').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#forgot_form')[0]);

    jQuery.ajax({
        url: weekly.config.forgot_password_mail,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                window.location.href = base_url + "/login/verify-code";


            }
        }
    });
});
/**
 * ========================================================================
 * VERIFY CODE
 * ========================================================================
 */
$('#verify_form').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#verify_form')[0]);

    jQuery.ajax({
        url: weekly.config.verify_code,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                window.location.href = base_url + "/login/reset-password";


            }
        }
    });
});
/**
 * =========================================================================
 * RESET_PASSWORD
 * =========================================================================
 */
$('#reset_form').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#reset_form')[0]);

    jQuery.ajax({
        url: weekly.config.reset_form,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                window.location.href = base_url + "/login";


            }
        }
    });
});
/**
 * =======================================================================
 * Add Contest Ajax
 * =======================================================================
 */
$('#add_contest').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#add_contest')[0]);

    jQuery.ajax({
        url: weekly.config.add_contest,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                $('.bd-create-contest-modal-lg').modal('hide');

                $('#contestdatatable').DataTable().ajax.reload(null, false);

            }
        }
    });
});
/**
 * =======================================================================
 * EDIT Contest Ajax
 * =======================================================================
 */
$('#edit_contest').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#edit_contest')[0]);

    jQuery.ajax({
        url: weekly.config.edit_contest,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                $('.bd-edit-contest-modal-lg').modal('hide');
                $('#contestdatatable').DataTable().ajax.reload(null, false);
            }
        }
    });
});
/**
 * ====================================================================
 * Banner Image
 * ====================================================================
 */
function readURL(input) {
    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function (e) {
            $('.image-upload-wrap').hide();

            $('.file-upload-image').attr('src', e.target.result);
            $('.file-upload-content').show();

            $('.image-title').html(input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);

    } else {
        removeUpload();
    }
}

function removeUpload() {
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
});
$('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});

/**
 * ==========================================================================
 * CONTEST DETAILS
 * ==========================================================================
 */
$(document).on('click', '.btncontestdetails', function (e) {
    $("#edit_contest .image-upload-wrap").hide();
    e.preventDefault();
    var contest_id = $(this).data('id');

    jQuery.ajax({
        url: weekly.config.get_contest,
        type: 'POST',
        data: { c_id: contest_id },
        datetype: "json",
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                console.log(data.data);
                //$( "#edit_contest input[name=name]" ).val( 'Hello World!' );
                $("#edit_contest .file-upload-content").show();
                $("#edit_contest .file-upload-image").attr('src', data.data.CONTEST_BANNER);
                $("#edit_contest input[name=contest_id]").val(data.data.C_ID);
                $("#edit_contest input[name=contest_name]").val(data.data.CONTEST_NAME);
                $("#edit_contest textarea[name=contest_description]").html(data.data.CONTEST_DESCRIPTION);
                $("#edit_contest input[name=contest_points]").val(data.data.CONTEST_POINTS);
                $("#edit_contest select[name=score_type]").val(data.data.SCORE_TYPE);
                $("#edit_contest input[name=start_date]").val(data.data.START_DATE);
                $("#edit_contest input[name=end_date]").val(data.data.END_DATE);
                $("#edit_contest .contestpdflink").attr('href', data.data.CONTEST_PDF);
                $("#edit_contest input[name=videourl]").val(data.data.VIDEO_URL);
                $("#edit_contest input[name=contest_pdf_title]").val(data.data.CONTEST_PDF_TITLE);
                // $( "#edit_contest input[name=weekpicker]" ).val( data.data.START_DATE + ' - ' + data.data.END_DATE );

            }
        }
    });
});
/**
 * =========================================================================
 * DELETE CONTEST AJAX
 * =========================================================================
 */
$(document).on('click', '.btncontestdelete', function () {
    var contest_id = $(this).data('id');
    swal({
        title: 'Are you sure?',
        text: 'Once deleted, you will not be able to recover this contest',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                jQuery.ajax({
                    url: weekly.config.delete_contest,
                    type: 'POST',
                    data: { c_id: contest_id },
                    datetype: "json",
                    success: function (data) {
                        if (data.success == false) {
                            iziToast.error({
                                title: 'ERROR',
                                message: data.message,
                                position: 'topRight'
                            });

                        } else if (data.success == true) {
                            swal('Poof! Your contest has been deleted!', {
                                icon: 'success',
                            });
                            $('#contestdatatable').DataTable().ajax.reload(null, false);

                        }
                    }
                });

            } else {
                swal('Your contest is safe!');
            }
        });
});
/**
 * =========================================================================
 * DELETE BANNER AJAX
 * =========================================================================
 */
$(document).on('click', '.btnbannerdelete', function () {
    var banner_id = $(this).data('id');
    swal({
        title: 'Are you sure?',
        text: 'Once deleted, you will not be able to recover this banner',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                jQuery.ajax({
                    url: weekly.config.delete_banner,
                    type: 'POST',
                    data: { b_id: banner_id },
                    datetype: "json",
                    success: function (data) {
                        if (data.success == false) {
                            iziToast.error({
                                title: 'ERROR',
                                message: data.message,
                                position: 'topRight'
                            });

                        } else if (data.success == true) {
                            swal('Poof! Your banner has been deleted!', {
                                icon: 'success',
                            });
                            $('#tbl_banners').DataTable().ajax.reload(null, false);


                        }
                    }
                });

            } else {
                swal('Your banner is safe!');
            }
        });
});
/**
 * =======================================================================
 * Change Banner Status
 * =====================================================================
 */

$(document).on('change', '.active-switch', function () {
    var banner_id = $(this).data('id');
    var status = 0;
    if ($(this).prop("checked") == true) {
        status = 1;
    }

    jQuery.ajax({
        url: weekly.config.banner_status,
        type: 'POST',
        data: { b_id: banner_id, status_id: status },
        datetype: "json",
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'Success',
                    message: data.message,
                    position: 'topRight'
                });
                $('#tbl_banners').DataTable().ajax.reload(null, false);

            }
        }
    });

});
/**
 * ====================================================================
 * Add PROMOCODE AJX
 * ====================================================================
 */
$('#add_promocode').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#add_promocode')[0]);

    jQuery.ajax({
        url: weekly.config.add_promocode,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                $('.bd-create-promocode-modal-lg').modal('hide');

                $('#promocodedatatable').DataTable().ajax.reload(null, false);

            }
        }
    });
});
/**
 * ==========================================================================
 * PROMOCODE DETAILS
 * ==========================================================================
 */
$(document).on('click', '.btnpromocodedetails', function (e) {
    $("#edit_promocode .image-upload-wrap").hide();
    e.preventDefault();
    var promo_id = $(this).data('id');

    jQuery.ajax({
        url: weekly.config.get_promocode,
        type: 'POST',
        data: { p_id: promo_id },
        datetype: "json",
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                $("#edit_promocode .file-upload-content").show();
                $("#edit_promocode .file-upload-image").attr('src', data.data.BANNER_IMAGE);
                $("#edit_promocode input[name=promo_id]").val(data.data.PROMO_ID);
                $("#edit_promocode input[name=promocode_title]").val(data.data.TITLE);
                $("#edit_promocode textarea[name=promocode_description]").html(data.data.DESCRIPTION);
                $("#edit_promocode input[name=promocode_points]").val(data.data.PURCHASE_POINTS);
                $("#edit_promocode input[name=minimum_promocode_points]").val(data.data.MINIMUM_POINTS);
                $("#edit_promocode input[name=expiry_date]").val(data.data.EXPIRY_DATE);

            }
        }
    });
});
/**
 * =======================================================================
 * EDIT PROMOCODE Ajax
 * =======================================================================
 */
$('#edit_promocode').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#edit_promocode')[0]);

    jQuery.ajax({
        url: weekly.config.edit_promocode,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                $('.bd-create-edit-modal-lg').modal('hide');
                $('#promocodedatatable').DataTable().ajax.reload(null, false);
            }
        }
    });
});
/**
 * =========================================================================
 * DELETE PROMOCODE AJAX
 * =========================================================================    
 */
$(document).on('click', '.btnpromocodedelete', function () {
    var promo_id = $(this).data('id');
    swal({
        title: 'Are you sure?',
        text: 'Once deleted, you will not be able to recover this Promocode',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                jQuery.ajax({
                    url: weekly.config.delete_promocode,
                    type: 'POST',
                    data: { p_id: promo_id },
                    datetype: "json",
                    success: function (data) {
                        if (data.success == false) {
                            iziToast.error({
                                title: 'ERROR',
                                message: data.message,
                                position: 'topRight'
                            });

                        } else if (data.success == true) {
                            swal('Poof! Your PromoCode has been deleted!', {
                                icon: 'success',
                            });
                            $('#promocodedatatable').DataTable().ajax.reload(null, false);


                        }
                    }
                });

            } else {
                swal('Your PromoCode is safe!');
            }
        });
});
/**
 * =========================================================================
 * ADD USER AJAX
 * =========================================================================
 */
$('#add_user').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#add_user')[0]);

    jQuery.ajax({
        url: weekly.config.add_user,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                $('.bd-create-user-modal-lg').modal('hide');
                $('#usersdatatable').DataTable().ajax.reload(null, false);
            }
        }
    });
});
/**
 * ===========================================================================
 * DELETE USER AJAX
 * ======================================================================
 */
$(document).on('click', '.btnuserdelete', function () {
    var user_id = $(this).data('id');
    swal({
        title: 'Are you sure?',
        text: 'Once deleted, you will not be able to recover this User',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                jQuery.ajax({
                    url: weekly.config.delete_user,
                    type: 'POST',
                    data: { u_id: user_id },
                    datetype: "json",
                    success: function (data) {
                        if (data.success == false) {
                            iziToast.error({
                                title: 'ERROR',
                                message: data.message,
                                position: 'topRight'
                            });

                        } else if (data.success == true) {
                            swal('Poof! Your User has been deleted!', {
                                icon: 'success',
                            });
                            $('#usersdatatable').DataTable().ajax.reload(null, false);


                        }
                    }
                });

            } else {
                swal('Your user is safe!');
            }
        });
});
/**
 * =====================================================================
 * BLOCK USER
 * =====================================================================
 */
$(document).on('click', '.btnuserblock', function () {
    var user_id = $(this).data('id');
    swal({
        title: 'Are you sure?',
        text: 'You want to block this user!',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                jQuery.ajax({
                    url: weekly.config.block_user,
                    type: 'POST',
                    data: { u_id: user_id },
                    datetype: "json",
                    success: function (data) {
                        if (data.success == false) {
                            iziToast.error({
                                title: 'ERROR',
                                message: data.message,
                                position: 'topRight'
                            });

                        } else if (data.success == true) {
                            swal('Poof! Your User has been Blocked!', {
                                icon: 'success',
                            });
                            $('#usersdatatable').DataTable().ajax.reload(null, false);


                        }
                    }
                });

            } else {
                swal('Your user is safe!');
            }
        });
});
/**
 * ======================================================================
 * UNBLOCK USER
 * =====================================================================
 */
$(document).on('click', '.btnuserunblock', function () {
    var user_id = $(this).data('id');
    swal({
        title: 'Are you sure?',
        text: 'You want to block this user!',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                jQuery.ajax({
                    url: weekly.config.unblock_user,
                    type: 'POST',
                    data: { u_id: user_id },
                    datetype: "json",
                    success: function (data) {
                        if (data.success == false) {
                            iziToast.error({
                                title: 'ERROR',
                                message: data.message,
                                position: 'topRight'
                            });

                        } else if (data.success == true) {
                            swal('Your User has been UnBlocked!', {
                                icon: 'success',
                            });
                            $('#usersdatatable').DataTable().ajax.reload(null, false);


                        }
                    }
                });

            } else {
                swal('Your user is safe!');
            }
        });
});
/**
 * ======================================================================
 * USER DETAILS
 * ======================================================================
 */
$(document).on('click', '.btnuserdetails', function (e) {

    e.preventDefault();
    var user_id = $(this).data('id');

    jQuery.ajax({
        url: weekly.config.get_userdetails,
        type: 'POST',
        data: { u_id: user_id },
        datetype: "json",
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {

                //$( "#edit_contest input[name=name]" ).val( 'Hello World!' );
                if (data.data.GENDER == 'M') {
                    $("#edit_user #gendermale").prop('checked', true);
                }
                if (data.data.GENDER == 'F') {
                    $("#edit_user #genderfemale").prop('checked', true);
                }
                if (data.data.PROFILE_IMAGE != "NOT ADDED") {
                    $("#edit_user #userimage").attr('src', data.data.PROFILE_IMAGE);

                }
                $("#edit_user input[name=user_id]").val(data.data.ID);
                $("#edit_user input[name=first_name]").val(data.data.FIRST_NAME);
                $("#edit_user input[name=last_name]").val(data.data.LAST_NAME);
                $("#edit_user input[name=dob]").val(data.data.DOB);
                $("#edit_user input[name=username]").val(data.data.USERNAME);
                $("#edit_user input[name=email]").val(data.data.EMAIL_ID);
                $("#edit_user select[name=user_role]").val(data.data.R_ID);
                $("#edit_user input[name=street]").val(data.data.STREET);
                $("#edit_user input[name=city]").val(data.data.CITY);
                $("#edit_user input[name=zipcode]").val(data.data.ZIPCODE);
                $("#edit_user input[name=state]").val(data.data.STATE);
                $("#edit_user input[name=paypalid]").val(data.data.PAYPAL_EMAIL_ID);
                $("#edit_user input[name=tax_id]").val(data.data.TAX_ID);

            }
        }
    });
});
/**
 * ==========================================================================
 * EDIT USER
 * =========================================================================
 */
$('#edit_user').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#edit_user')[0]);

    jQuery.ajax({
        url: weekly.config.edit_user,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                $('.bd-edit-user-modal-lg').modal('hide');
                $('#usersdatatable').DataTable().ajax.reload(null, false);
            }
        }
    });


});
/**
 * ======================================================================
 * UPDATE SETTING POINT
 * ======================================================================
 */
$('#update_point_setting').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#update_point_setting')[0]);

    jQuery.ajax({
        url: weekly.config.update_point,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
            }
        }
    });


});
/**
 * ======================================================================
 * UPDATE SETTING PAYMENT
 * ======================================================================
 */
$('#update_payment_setting').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#update_payment_setting')[0]);

    jQuery.ajax({
        url: weekly.config.update_payment,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
            }
        }
    });


});
/**
 * ==================================================================
 * NEW PAGE AJAX
 * ==================================================================
 */
$('#add_page').on('submit', function (e) {
    e.preventDefault();
    tinymce.triggerSave();
    var formData = new FormData($('#add_page')[0]);
    console.log(formData);
    console.log($('#new-page-content').text());
    jQuery.ajax({
        url: weekly.config.add_page,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                window.location.href = base_url + "/admin/cms";
            }
        }
    });


});
/**
 * ============================================================
 * DELETE PAGE AJAX
 * ==========================================================
 */
$(document).on('click', '.btnpagedelete', function () {
    var page_id = $(this).data('id');
    swal({
        title: 'Are you sure?',
        text: 'Once deleted, you will not be able to recover this Page',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                jQuery.ajax({
                    url: weekly.config.delete_page,
                    type: 'POST',
                    data: { p_id: page_id },
                    datetype: "json",
                    success: function (data) {
                        if (data.success == false) {
                            iziToast.error({
                                title: 'ERROR',
                                message: data.message,
                                position: 'topRight'
                            });

                        } else if (data.success == true) {
                            swal('Poof! Your Page has been deleted!', {
                                icon: 'success',
                            });
                            $('#pagedatatable').DataTable().ajax.reload(null, false);


                        }
                    }
                });

            } else {
                swal('Your page is safe!');
            }
        });
});
/**
 * =============================================================
 * UPDATE PAGE
 * =============================================================
 */
$('#edit_page').on('submit', function (e) {
    e.preventDefault();
    var editor = tinymce.get('new-page-content');
    console.log(editor.getContent());
    var formData = new FormData($('#edit_page')[0]);
    formData.set('pagecontent', editor.getContent());
    console.log(formData);
    jQuery.ajax({
        url: weekly.config.update_page,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
            }
        }
    });


});

/**
 * ============================================================
 * ASSIGN REVIWIER DETAILS
 * =======================================================
 */
$(document).on('click', '.btnassignreviewer', function (e) {

    e.preventDefault();
    var p_id = $(this).data('id');
    var name = $(this).data('name');
    $("#assign-reviewer input[name=p_id]").val(p_id);
    $('#assign-reviewer .participant_name').text(name);
});
/**
 * ============================================================
 * ASSIGN REVIWIER 
 * =======================================================
 */
$('#assign-reviewer').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#assign-reviewer')[0]);

    jQuery.ajax({
        url: weekly.config.participant_assign,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                $('#participantdatatable').DataTable().ajax.reload(null, false);
                $('.bd-assignreviewer-modal-lg').modal('hide');
            }
        }
    });

});
// Bulk assign
$(document).on('click', '.btnbtnassign', function (e) {
    e.preventDefault();
    var checks = $('.drp_checks_participant:checked').map(function () {
        return $(this).val();
    }).get()
    jQuery.ajax({
        url: weekly.config.get_selected_participant,
        type: 'POST',
        data: { checks: checks },
        datetype: "json",
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });


            } else if (data.success == true) {
                $('.bd-assignreviewer-bulk-modal-lg').modal('show');
                $('#assign-reviewer-bulk .participant_id_list').html('');
                $('#assign-reviewer-bulk .participant_name').html('');
                $.each(data.data, function (i) {
                    $.each(data.data[i], function (key, val) {
                        if (key == 'P_ID') {
                            $('#assign-reviewer-bulk .participant_id_list').append('<input type="hidden" name="participant_id[]" value=' + val + '/>')
                        }
                        if (key == 'FIRST_NAME') {
                            $('#assign-reviewer-bulk .participant_name').append('<div class="form-group col-md-12"><label class="countpart">' + (i + 1) + '  :  </label><input type="text" class="form-control" name="participant_name" value=' + val + ' disabled /></div>')

                        }
                    });
                });

            }
        }
    });

});
$('#assign-reviewer-bulk').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#assign-reviewer-bulk')[0]);

    jQuery.ajax({
        url: weekly.config.assign_bulk_reviewer,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                $('#participantdatatable').DataTable().ajax.reload(null, false);
                $('.bd-assignreviewer-bulk-modal-lg').modal('hide');
            }
        }
    });

});
/**
 * ===========================================================
 * DISQALIFY PARTICIPANT
 * ==========================================================
 */
$(document).on('click', '.btndisqualify', function (e) {

    e.preventDefault();
    var p_id = $(this).data('id');
    swal({
        title: 'Please Enter Reason to Disqualify?',
        content: {
            element: 'input',
            attributes: {
                placeholder: 'Type your reason',
                type: 'text',
            },
        },
    }).then((data) => {
        jQuery.ajax({
            url: weekly.config.disqulaifyparticipant,
            type: 'POST',
            data: { p_id: p_id, message: data },
            datetype: "json",
            success: function (response) {
                if (response.success == false) {

                    swal(response.message, {
                        icon: 'error',
                    });

                } else if (response.success == true) {
                    swal('Poof! Your Partcipant has been disqualified!', {
                        icon: 'success',
                    });
                    $('#participantdatatable').DataTable().ajax.reload(null, false);


                }
            }
        });
    });

});
/**
 * ===========================================================
 * DISQALIFY PARTICIPANT
 * ==========================================================
 */
$(document).on('click', '.btnundisqualify', function () {
    var page_id = $(this).data('id');
    swal({
        title: 'Are you sure?',
        text: 'Make Sure You Want to Unban this Participant!',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                jQuery.ajax({
                    url: weekly.config.undisqualifyparticipant,
                    type: 'POST',
                    data: { p_id: page_id },
                    datetype: "json",
                    success: function (data) {
                        if (data.success == false) {
                            iziToast.error({
                                title: 'ERROR',
                                message: data.message,
                                position: 'topRight'
                            });

                        } else if (data.success == true) {
                            swal('YOUR PARTICIPANT IS UNBANNED!', {
                                icon: 'success',
                            });
                            $('#participantdatatable').DataTable().ajax.reload(null, false);


                        }
                    }
                });

            } else {
                swal('Your Participant is Banned!');
            }
        });
});
/**
 * ==========================================================
 * GET PARTICIPANT DETAILS
 * =========================================================
 */
$(document).on('click', '.btnparticipantdetails', function () {
    var p_id = $(this).data('id');
    jQuery.ajax({
        url: weekly.config.getParticipant,
        type: 'POST',
        data: { participant_id: p_id },
        datetype: "json",
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {

                $("#paricipant_details .participant_video").attr('src', 'https://www.youtube.com/embed/' + data.data.VIDEO_URL);
                $("#paricipant_details input[name=score]").val(data.data.SCORE);
                $("#paricipant_details input[name=scoretype]").val(data.data.SCORE_TYPE);
                $("#paricipant_details input[name=inputname]").val(data.data.FIRST_NAME);
                $("#paricipant_details input[name=participant_id]").val(p_id);


            }
        }
    });

});
/**
 * ==============================================================
 * UPDATE SCORE
 * ==============================================================
 */
$('#paricipant_details').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#paricipant_details')[0]);

    jQuery.ajax({
        url: weekly.config.update_score,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                $('#participantdatatable').DataTable().ajax.reload(null, false);
                $('.bd-participantdetails-modal-lg').modal('hide');
            }
        }
    });


});
/**
 * ==============================================================
 * CHANGE ACCEPT REJECT STATUS
 * ==============================================================
 */
$(document).on('change', '.drp_accept_reject', function () {
    var p_id = $(this).data('id');
    var change_status = $(this).val();
    jQuery.ajax({
        url: weekly.config.change_status,
        type: 'POST',
        data: { participant_id: p_id, status: change_status },
        datetype: "json",
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {

                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                $('#participantdatatable').DataTable().ajax.reload(null, false);


            }
        }
    });

});

/**
 * ===========================================================
 * ACCESS CHECK
 * ==========================================================
 */
$(document).on('click', '.access-check', function () {
    var u_id = $(this).data('id');
    var searchIDs = $("input[id=" + u_id + "]:checked").map(function () {
        return $(this).val();
    }).get(); // <----
    console.log(searchIDs);
    jQuery.ajax({
        url: weekly.config.access_control,
        type: 'POST',
        data: { user_id: u_id, access: searchIDs },
        datetype: "json",
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {

                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                $('#usersdatatable').DataTable().ajax.reload(null, false);



            }
        }
    });

});
/**
 * ===========================================================
 * set firebase key
 * ===================================================
 */
$('#update_firebase_setting').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($('#update_firebase_setting')[0]);

    jQuery.ajax({
        url: weekly.config.update_firebase_setting,
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {
                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
            }
        }
    });


});
/**
 * ==================================================
 * MAKE CONTEST OFFICIAL
 * =================================================
 */
$(document).on('click', '.makecontestofficial', function () {
    var c_id = $(this).data('id');
    console.log(c_id)
    jQuery.ajax({
        url: weekly.config.make_contest_official,
        type: 'POST',
        data: { contest_id: c_id },
        datetype: "json",
        success: function (data) {
            if (data.success == false) {
                iziToast.error({
                    title: 'ERROR',
                    message: data.message,
                    position: 'topRight'
                });

            } else if (data.success == true) {

                iziToast.success({
                    title: 'SUCCESS',
                    message: data.message,
                    position: 'topRight'
                });
                $('#contestdatatable').DataTable().ajax.reload(null, false);

            }
        }
    });

});