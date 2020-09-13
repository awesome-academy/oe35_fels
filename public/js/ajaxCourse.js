var SITEURL = window.location.origin;
var jq = new jQuery();
/* dataTable AJAX */
(function () {
    $.fn.data_table = function (string = "") {
        $("#datatable_record").DataTable({
            autoWidth: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + '/admin/' + string,
                type: "GET",
            },
            columns: [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex"
                }, // 0
                {
                    data: "name",
                    name: "name"
                },
                {
                    data: "created_at",
                    name: "created_at"
                },
                {
                    data: "action",
                    name: "action",
                    render: function (data, type, row, meta) {
                        btn = '<a href="javascript:void(0);" id="edit_record" data-id="' + row.id + '" data-toggle="tooltip" data-original-title="Edit" class="btn btn-icon btn-info"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        btn += '&nbsp;<a href="javascript:void(0);" id="delete_record" data-id="' + row.id + '" data-toggle="tooltip" data-original-title="Delete" class="btn btn-icon btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';

                        return btn;
                    }
                }, // 3
            ],
            columnDefs: [{
                    orderable: false,
                    targets: [0, 3]
                },
                {
                    searchable: false,
                    targets: [0, 2, 3]
                }
            ],
            order: [
                [2, "desc"]
            ],
        });
    };
})(jQuery);

/* Initial dataTable AJAX when document is ready*/
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    jq.data_table('courses');
});

/* Show Edit/Create Modal */
$("body").on("click", "#edit_record, #create_new_record", function () {
    // $.resetValidate(); // critical error cause reload page =.=
    $(".alert-warning").hide();
    modal_type = $(this).attr("id");
    if (modal_type == "create_new_record") {
        $("#record_id").val("");
        $("#formModal").trigger("reset");
        $("#modalTitle").html("Step 1 - Add New Course");
        $("#btn_save").html("Create");
        $("#bootstrapModal").modal({
            show: true,
            backdrop: "static",
            keyboard: false,
        });
    } else {
        // Get detail record form server
        var record_id = $(this).data("id");
        $.get(SITEURL + '/admin/courses/' + record_id + '/edit', function (value) {
            $("#modalTitle").html("Edit Record");
            $("#btn_save").html("Update");
            $("#bootstrapModal").modal({
                show: true,
                backdrop: "static",
                keyboard: false,
            });
            $("#record_id").val(value.data.id);
            $("#name").val(value.data.name);
        });
    }
});

/* Show confirm modal */
$("body").on("click", "#delete_record", function () {
    record_id = $(this).data("id");
    $("#confirmModal").modal("show");
});

/* Confirmation related to delete or restore record */
$("#btn_ok").click(function () {
    var url_action = '/admin/courses/';
    var url_type = "DELETE";
    var msg = "Deleting...";
    $.ajax({
        type: url_type,
        url: SITEURL + url_action + record_id,
        contentType: 'application/json',
        beforeSend: function () {
            $("#btn_ok").text(msg);
        },
        success: function (data) {
            if (data.errors) {
                $("#alert_msg").empty();
                $.each(data.errors, function (key, value) {
                    $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                    $(".alert-warning").show();
                });
            } else {
                $("#datatable_record").dataTable().fnDraw(false);
                setTimeout(function () {
                    $(".alert-warning").hide();
                    $("#confirmModal").modal("hide");
                    $("#btn_ok").html("OK");
                    $.msgNotification("success", data.success);
                }, 1000);
            }
        },
    });
});

/* Finish create course and word */
$("#btn_finishWord").click(function () {
    $(".alert-warning").hide();
    // check un-finish work
    var empty = true;
    $('input[type="text"]').each(function () {
        if ($(this).val() != "") {
            empty = false;
            return false;
        }
    });

    if (empty) {
        var data = {
            'course_id': $("#course_id").val()
        };
        $.post(SITEURL + '/admin/send-notify', data, function (data, status) {
            $.msgNotification("success", data.success);
        });
        $("#datatable_record").DataTable().ajax.reload();
        setTimeout(function () {
            $("#formModalWord").trigger("reset");
            $("#bootstrapModalWord").modal("hide");
            $("#btn_saveWord").html("Save Changes");
            $.msgNotification("success", 'Finish create!');
        }, 1000);
    } else {
        $("#alert_msgWord").empty();
        $("#alert_msgWord").append("<strong>Please finish your work!</strong>");
        $(".alert-warning").show();
    }
});

/* Show modal to create Word*/
$(function () {
    $.showModalWord = function (courseId) {
        $("#course_id").val(courseId);
        $("#formModalWord").trigger("reset");
        $("#modalTitleWord").html("Step 2 - Add New Word");
        $("#btn_saveWord").html("Create");
        $("#bootstrapModalWord").modal({
            show: true,
            backdrop: "static",
            keyboard: false,
        });
    };
});

/* Validate input data + send form to updateOrCreate */
$("#btn_save").click(function () {
    $("#formModal").validate({
        rules: {
            name: {
                required: true,
                minlength: 1,
                maxlength: 255,
            },
        },
        messages: {
            name: {
                required: "Name is required!",
                minlength: "Minimum length is 1!",
                maxlength: "Maximum length is 255!",
            },
        },
        submitHandler: function () {
            $("#btn_save").html("Saving..");
            var recordValue = $("#record_id").val();
            $.ajax({
                data: $("#formModal").serialize(),
                url: SITEURL + '/admin/courses',
                type: "POST",
                dataType: "json",
                success: function (data) {
                    $(".alert-warning").hide();
                    if (data.errors) {
                        $("#alert_msg").empty();
                        $.each(data.errors, function (key, value) {
                            $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                            $(".alert-warning").show();
                        });
                        $("#btn_save").html("Save Changes");
                    } else {
                        if (recordValue == '') {
                            // create mode move to step 2 - create Word
                            // last inserted course id
                            var courseIdCreated = data.course_id;
                            $("#formModal").trigger("reset");
                            $("#btn_save").html("Save Changes");
                            $("#bootstrapModal").modal("hide");
                            $.msgNotification("success", data.success);
                            $.showModalWord(courseIdCreated);
                        } else {
                            // update mode
                            $("#datatable_record").DataTable().ajax.reload();
                            setTimeout(function () {
                                $("#formModal").trigger("reset");
                                $("#bootstrapModal").modal("hide");
                                $("#btn_save").html("Save Changes");
                                $.msgNotification("success", data.success);
                            }, 1000);
                        }
                    }
                },
                error: function (data) {
                    var validateErrors = data.responseJSON.errors;
                    $("#alert_msg").empty();
                    $.each(validateErrors, function (key, value) {
                        $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                        $(".alert-warning").show();
                    });
                    $("#btn_save").html("Save Changes");
                },
            });
        },
    });
});

/* Validate input data and create Word */
$("#btn_saveWord").click(function () {
    $("#formModalWord").validate({
        rules: {
            name: {
                required: true,
                minlength: 1,
                maxlength: 255,
            },
            mean: {
                maxlength: 255,
            },
        },
        messages: {
            name: {
                required: "Name is required!",
                minlength: "Minimum length is 1!",
                maxlength: "Maximum length is 255!",
            },
            mean: {
                maxlength: "Maximum length is 255!",
            },
        },
        submitHandler: function () {
            $("#btn_saveWord").html("Saving..");
            var course_id = $("#course_id").val();
            $.ajax({
                data: $("#formModalWord").serialize(),
                url: SITEURL + '/admin/words',
                type: "POST",
                dataType: "json",
                success: function (data) {
                    $(".alert-warning").hide();
                    if (data.errors) {
                        $("#alert_msg").empty();
                        $.each(data.errors, function (key, value) {
                            $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                            $(".alert-warning").show();
                        });
                        $("#btn_saveWord").html("Save Changes");
                    } else {
                        // LOOP STEP CREATE WORD
                        $.msgNotification("success", data.success);
                        setTimeout(function () {
                            $.showModalWord(course_id);
                        }, 1000);
                    }
                },
                error: function (data) {
                    var validateErrors = data.responseJSON.errors;
                    $("#alert_msgWord").empty();
                    $.each(validateErrors, function (key, value) {
                        $("#alert_msgWord").append("<strong><li>" + value + "</li></strong>");
                        $(".alert-warning").show();
                    });
                    $("#btn_saveWord").html("Save Changes");
                },
            });
        },
    });
});

/* Remove validate error */
(function () {
    $.resetValidate = function () {
        var validator = $("#formModal").validate();
        validator.resetForm();
    };
})(jQuery);

/* Hide errors showed on modal when click close button*/
$(function () {
    $("[data-hide]").on("click", function () {
        $(this).closest("." + $(this).attr("data-hide")).hide();
    });
});

/* Capitalize first letter for Toast Nofitication*/
$(function () {
    $.jsUcFirst = function (string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    };
});

// toastr settings
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

/* Toast Nofitication*/
$(function () {
    $.msgNotification = function (msgType, msgText) {
        toastr[msgType]($.jsUcFirst(msgText));
    };
});
