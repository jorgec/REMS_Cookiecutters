"use strict";
const object_status = [
    'Select Option',

];

function getQueryParams(query = window.location.search) {
    return query.replace(/^\?/, '').split('&').reduce((json, item) => {
        if (item) {
            item = item.split('=').map((value) => decodeURIComponent(value))
            json[item[0]] = item[1]
        }
        return json
    }, {})
}

function filter() {
    var values = $('#advanceSearch').serialize();
    var page_num = page_num ? page_num : 0;
    var filter_data = values ? getQueryParams(values) : '';
    filter_data.page = page_num;

    var url = base_url + "{{ cookiecutter.module }}/{{ cookiecutter.show_function_plural}}?filter=true&with_relations=yes&" + values;
    return url;
}

var PurchaseOrder = (function() {
    var PurchaseOrderTable = function() {
        var table = $("#{{ cookiecutter.module }}_table");
        var url = base_url + "{{ cookiecutter.module }}/{{ cookiecutter.show_function_plural}}?filter=true&with_relations=yes";

        // begin first table
        table.DataTable({
            order: [
                [2, "asc"]
            ],
            pagingType: "full_numbers",
            lengthMenu: [5, 10, 25, 50, 100],
            responsive: true,
            pageLength: 10,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            serverMethod: "post",
            deferRender: true,

            ajax: url,
            dom: "<'row'<'col-sm-12 col-md-10'l><'col-sm-12 col-md-2 text-right'<'btn-block'B>>>" +
                // "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{
                text: '<i class="la la-trash"></i> Delete Selected',
                className: "btn btn-sm btn-label-primary btn-elevate btn-icon-sm",
                attr: {
                    id: "bulkDelete"
                },
                enabled: false
            }],
            language: {
                lengthMenu: "Show _MENU_",
                infoFiltered: "(filtered from _MAX_ total records)"
            },

            columns: [{
                    data: null
                },
                {% for field, details in cookiecutter.fields.items() %} {% if details.meta.form_fillable == "True" %} {
                    data: "{{ field }}"
                }, {% endif %} {% endfor %}
                /* ==================== end: Add model fields ==================== */
                {
                    data: "Actions",
                    responsivePriority: -1
                }
            ],
            columnDefs: [{
                    targets: -1,
                    title: "Actions",
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {

                        var delete_action = `<a href="javascript:void(0);" class="dropdown-item remove_{{ cookiecutter.module }}" data-id="` + row.id + `"><i class="la la-trash"></i> Delete </a>`;
     
                        return (
                            `
								<span class="dropdown">
									<a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
									    <i class="la la-ellipsis-h"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="` + base_url + `{{ cookiecutter.module }}/form/` + row.id + `"><i class="la la-edit"></i> 
										    Update
										</a>
										` + delete_action + `
									</div>
								</span>
								<a href="` + base_url + `{{ cookiecutter.module }}/view/` + row.id + `" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
								    <i class="la la-eye"></i>
								</a>`
                        );
                    }
                },
                {
                    targets: [0, 1, 3, 4, -1],
                    className: "dt-center"
                },
                {
                    targets: 0,
                    render: function(data, type, row, meta) {
                        return (
                            `
	                  <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid">
                      <input type="checkbox" name="id[]" value="` +
                            row.id +
                            `" class="m-checkable delete_check" data-id="` +
                            row.id +
                            `">
                      <span></span>
	                  </label>`
                        );
                    },
                    orderable: false,
                    searchable: false
                },
                /* ==================== begin: Add target fields for dropdown value ==================== */
                {
                    targets: 7,
                    render: function(data, type, row, meta) {
                        return object_status[row.status];
                    }
                }
                /* ==================== end: Add target fields for dropdown value ==================== */
            ],
            drawCallback: function(settings) {
                $("#total").text(settings.fnRecordsTotal() + " TOTAL");
            }
        });

        var oTable = table.DataTable();
        $("#generalSearch").keyup(function() {
            oTable.search($(this).val()).draw();
        });

        $('#advanceSearch').submit(function(e) {
            e.preventDefault();
            var dTable = $("#{{ cookiecutter.module }}_table").DataTable();
            dTable.ajax.url(filter()).load();
            $('#filterModal').modal('hide');

        });

        $("#resetFilters").click(function(e) {
            e.preventDefault();
            var dTable = $("#{{ cookiecutter.module }}_table").DataTable();
            dTable.ajax.url(base_url + "{{ cookiecutter.module }}/{{ cookiecutter.show_function_plural}}?filter=true&with_relations=yes").load();
        });
    };

    var confirmDelete = function() {
        $(document).on("click", ".remove_{{ cookiecutter.module }}", function() {
            var id = $(this).data("id");

            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: base_url + "{{ cookiecutter.module }}/delete/" + id,
                        type: "POST",
                        dataType: "JSON",
                        data: { id: id },
                        success: function(res) {
                            if (res.status) {
                                $("#{{ cookiecutter.module }}_table")
                                    .DataTable()
                                    .ajax.reload();
                                swal.fire("Deleted!", res.message, "success");
                            } else {
                                swal.fire("Oops!", res.message, "error");
                            }
                        }
                    });
                } else if (result.dismiss === "cancel") {
                    swal.fire(
                        "Cancelled",
                        "Your imaginary file is safe :)",
                        "error"
                    );
                }
            });
        });
    };

    var upload_guide = function() {
        $(document).on("click", "#btn_upload_guide", function() {
            var table = $("#upload_guide_table");

            table.DataTable({
                order: [
                    [0, "asc"]
                ],
                pagingType: "full_numbers",
                lengthMenu: [5, 10, 25, 50, 100],
                pageLength: 10,
                responsive: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                deferRender: true,
                ajax: base_url + "{{ cookiecutter.module }}/get_table_schema",
                columns: [
                        // {data: 'button'},
                        { data: "no" },
                        { data: "name" },
                        { data: "type" },
                        { data: "format" },
                        { data: "option" },
                        { data: "required" }
                    ]
                    // drawCallback: function ( settings ) {

                // }
            });
        });
    };

    var _add_ons = function() {
        var dTable = $("#{{ cookiecutter.module }}_table").DataTable();

        $("#_search").on("keyup", function() {
            console.log("yow");
            dTable.search($(this).val()).draw();
        });

        $("#_export_select_all").on("click", function() {
            if (this.checked) {
                $("._export_column").each(function() {
                    this.checked = true;
                });
            } else {
                $("._export_column").each(function() {
                    this.checked = false;
                });
            }
        });

        $("._export_column").on("click", function() {
            if (this.checked == false) {
                $("#_export_select_all").prop("checked", false);
            }
        });

        $("#import_status").on("change", function(e) {
            var doc_type = $(this).val();

            if (doc_type != "") {
                KTApp.block("#kt_content", {
                    overlayColor: "#000000",
                    type: "v2",
                    state: "primary",
                    message: "Processing...",
                    css: {
                        padding: 0,
                        margin: 0,
                        width: "30%",
                        top: "40%",
                        left: "35%",
                        textAlign: "center",
                        color: "#000",
                        border: "3px solid #aaa",
                        backgroundColor: "#fff",
                        cursor: "wait"
                    }
                });

                setTimeout(function() {
                    $("#_batch_upload button").removeAttr("disabled");
                    $("#_batch_upload button").removeClass("disabled");

                    KTApp.unblock("#kt_content");
                }, 500);
            } else {
                KTApp.block("#kt_content", {
                    overlayColor: "#000000",
                    type: "v2",
                    state: "primary",
                    message: "Processing...",
                    css: {
                        padding: 0,
                        margin: 0,
                        width: "30%",
                        top: "40%",
                        left: "35%",
                        textAlign: "center",
                        color: "#000",
                        border: "3px solid #aaa",
                        backgroundColor: "#fff",
                        cursor: "wait"
                    }
                });

                setTimeout(function() {
                    $("#_batch_upload button").attr("disabled", "disabled");
                    $("#_batch_upload button").addClass("disabled");

                    KTApp.unblock("#kt_content");
                }, 500);
            }
        });
    };

    var status = function() {
        $(document).on("change", "#import_status", function() {
            $("#export_csv_status").val($(this).val());
        });
    };

    var _filterPurchaseOrder = function() {
        var dTable = $("#{{ cookiecutter.module }}_table").DataTable();

        function _colFilter(n) {
            dTable
                .column(n)
                .search($("#_column_" + n).val())
                .draw();
        }

        $("._filter").on("keyup change clear", function() {
            console.log("yow");
            _colFilter($(this).data("column"));
        });
    };

    var _selectProp = function() {
        var _table = $("#{{ cookiecutter.module }}_table").DataTable();
        var _buttons = _table.buttons([".bulkDelete"]);

        $("#select-all").on("click", function() {
            if ($(this).is(":checked")) {
                $(".delete_check").prop("checked", true);
            } else {
                $(".delete_check").prop("checked", false);
            }
        });

        $("#{{ cookiecutter.module }}_table tbody").on(
            "change",
            'input[type="checkbox"]',
            function() {
                if (!this.checked) {
                    var el = $("input#select-all").get(0);

                    if (el && el.checked && "indeterminate" in el) {
                        el.indeterminate = true;
                    }
                }
            }
        );

        $(document).on("change", 'input[name="id[]"]', function() {
            var _checked = $('input[name="id[]"]:checked').length;
            if (_checked < 0) {
                _table.button(0).disable();
            } else {
                _table.button(0).enable(_checked > 0);
            }
        });

        $("#bulkDelete").click(function() {
            var deleteids_arr = [];
            // Read all checked checkboxes
            $('input[name="id[]"]:checked').each(function() {
                deleteids_arr.push($(this).val());
            });

            // Check checkbox checked or not
            if (deleteids_arr.length > 0) {
                swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url: base_url + "{{ cookiecutter.module }}/bulkDelete",
                            type: "POST",
                            dataType: "JSON",
                            data: { deleteids_arr: deleteids_arr },
                            success: function(res) {
                                if (res.status) {
                                    $("#{{ cookiecutter.module }}_table")
                                        .DataTable()
                                        .ajax.reload();
                                    swal.fire(
                                        "Deleted!",
                                        res.message,
                                        "success"
                                    );
                                } else {
                                    swal.fire("Oops!", res.message, "error");
                                }
                            }
                        });
                    } else if (result.dismiss === "cancel") {
                        swal.fire(
                            "Cancelled",
                            "Your imaginary file is safe :)",
                            "error"
                        );
                    }
                });
            }
        });
    };

    var processStatusAction = function() {
        $(document).on('click', '.process-action', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var action = $(this).data('action');
            var table = $(this).data('table');
            var field = $(this).data('field');
            var value = $(this).data('value');
            var actor = $(this).data('actor');

            var action_label = '';
            var data = {
                table: table,
                id: id,
                field: field,
                value: value,
                actor: actor
            }

            switch (action) {
                case "1":
                    action_label = 'Change status to New Request';
                    break;
                case "2":
                    action_label = 'Change status to Approved';
                    break;
                case "3":
                    action_label = 'Change status to Denied';
                    break;
                case "4":
                    action_label = 'Change status to Cancelled';
                    break;
            }

            swal.fire({
                title: action_label,
                text: "This will change the status of this request",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes, change the status',
                cancelButtonText: 'No',
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: base_url + "generic_api/authorized_update",
                        type: "POST",
                        dataType: "JSON",
                        data: data,
                        success: function(res) {
                            if (res.status) {
                                swal.fire({
                                    title: 'Status changed!',
                                    text: res.message,
                                    type: 'success'
                                }).then((result) => {
                                    location.reload();
                                });
                            } else {
                                swal.fire(
                                    'Oops!',
                                    res.message,
                                    'error'
                                )
                            }
                        }
                    })
                } else if (result.dismiss === 'cancel') {
                    swal.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            })
        })
    }

    var processStatusActionWithSupervision = function() {
        $(document).on('click', '.process-action-with-supervision', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var action = $(this).data('action');
            var table = $(this).data('table');
            var field = $(this).data('field');
            var value = $(this).data('value');
            var actor = $(this).data('actor');
            var validator = $(this).data('validator');
            var modal_confirm = $("#password_confirm_modal");
            var data = {
                table: table,
                id: id,
                field: field,
                value: value,
                actor: actor
            }

            swal.fire({
                title: "Cancel own Request",
                text: "This will change the status of this request",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes, change the status',
                cancelButtonText: 'No',
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    modal_confirm.modal('show');
                    filter_app.confirm_form.user_id = validator;
                    status_data = data;
                }
            })
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            confirmDelete();
            PurchaseOrderTable();
            _add_ons();
            _filterPurchaseOrder();
            upload_guide();
            status();
            _selectProp();
            processStatusAction();
            processStatusActionWithSupervision();
        }
    };
})();

jQuery(document).ready(function() {
    PurchaseOrder.init();
});

var status_data = {};

var filter_app = new Vue({
    el: '#{{ cookiecutter.module }}_content',
    data: {
        confirm_form: {
            identity: "",
            password: "",
            user_id: null
        },
    },
    watch: {},
    methods: {
        confirmIdentity() {
            var url = base_url + "generic_api/check_credentials";
            $.ajax({
                url: url,
                type: "POST",
                dataType: "JSON",
                data: this.confirm_form,
                success: function(res) {
                    if (res.status) {
                        var d = status_data;
                        $.ajax({
                            url: base_url + "generic_api/authorized_update",
                            type: "POST",
                            dataType: "JSON",
                            data: d,
                            success: function(r) {
                                if (r.status) {
                                    swal.fire({
                                        title: 'Status changed!',
                                        text: r.message,
                                        type: 'success'
                                    }).then((result) => {
                                        location.reload();
                                    });
                                } else {
                                    swal.fire(
                                        'Oops!',
                                        r.message,
                                        'error'
                                    )
                                }
                            }
                        })
                    } else {
                        swal.fire({
                            title: 'Ooops!',
                            text: res.message,
                            type: 'danger'
                        })
                    }
                }
            })
        }
    },
    mounted() {}
});