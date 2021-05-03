"use strict";
var {{ cookiecutter.module_function }} = (function() {
    var {{ cookiecutter.module_function }}Table = function() {
        var table = $("#{{ cookiecutter.module_slug }}_table");

        // begin first table
        table.DataTable({
            order: [[2, "asc"]],
            pagingType: "full_numbers",
            lengthMenu: [5, 10, 25, 50, 100],
            responsive: true,
            pageLength: 10,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            serverMethod: "post",
            deferRender: true,

            ajax: base_url + "{{ cookiecutter.module_slug }}/{{ cookiecutter.show_function_plural }}",
            dom:
                "<'row'<'col-sm-12 col-md-10'l><'col-sm-12 col-md-2 text-right'<'btn-block'B>>>" +
                // "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    text: '<i class="la la-trash"></i> Delete Selected',
                    className:
                        "btn btn-sm btn-label-primary btn-elevate btn-icon-sm",
                    attr: {
                        id: "bulkDelete"
                    },
                    enabled: false
                }
            ],
            language: {
                lengthMenu: "Show _MENU_",
                infoFiltered: "(filtered from _MAX_ total records)"
            },

            columns: [
                {
                    data: null
                },
                {
                    data: "id"
                },
                {
                    data: "name"
                },
                /* ==================== begin: Add model fields ==================== */

                /* ==================== end: Add model fields ==================== */
                {
                    data: "Actions",
                    responsivePriority: -1
                }
            ],
            columnDefs: [
                {
                    targets: -1,
                    title: "Actions",
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return (
                            `
								<span class="dropdown">
									<a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
									<i class="la la-ellipsis-h"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="` +
                            base_url +
                            `{{ cookiecutter.module_slug }}/form/` +
                            row.id +
                            `"><i class="la la-edit"></i> Update </a>
										<a href="javascript:void(0);" class="dropdown-item remove_{{ cookiecutter.module_slug }}" data-id="` +
                            row.id +
                            `"><i class="la la-trash"></i> Delete </a>
									</div>
								</span>
								<a href="` +
                            base_url +
                            `{{ cookiecutter.module_slug }}/view/` +
                            row.id +
                            `" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
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
    };

    var confirmDelete = function() {
        $(document).on("click", ".remove_{{ cookiecutter.module_slug }}", function() {
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
                        url: base_url + "{{ cookiecutter.module_slug }}/delete/" + id,
                        type: "POST",
                        dataType: "JSON",
                        data: { id: id },
                        success: function(res) {
                            if (res.status) {
                                $("#{{ cookiecutter.module_slug }}_table")
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
                order: [[0, "asc"]],
                pagingType: "full_numbers",
                lengthMenu: [5, 10, 25, 50, 100],
                pageLength: 10,
                responsive: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                deferRender: true,
                ajax: base_url + "{{ cookiecutter.module_slug }}/get_table_schema",
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
        var dTable = $("#{{ cookiecutter.module_slug }}_table").DataTable();

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

    var _filter{{ cookiecutter.module_function }} = function() {
        var dTable = $("#{{ cookiecutter.module_slug }}_table").DataTable();

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
        var _table = $("#{{ cookiecutter.module_slug }}_table").DataTable();
        var _buttons = _table.buttons([".bulkDelete"]);

        $("#select-all").on("click", function() {
            if ($(this).is(":checked")) {
                $(".delete_check").prop("checked", true);
            } else {
                $(".delete_check").prop("checked", false);
            }
        });

        $("#{{ cookiecutter.module_slug }}_table tbody").on(
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
                            url: base_url + "{{ cookiecutter.module_slug }}/bulkDelete/",
                            type: "POST",
                            dataType: "JSON",
                            data: { deleteids_arr: deleteids_arr },
                            success: function(res) {
                                if (res.status) {
                                    $("#{{ cookiecutter.module_slug }}_table")
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

    return {
        //main function to initiate the module
        init: function() {
            confirmDelete();
            {{ cookiecutter.module_function }}Table();
            _add_ons();
            _filter{{ cookiecutter.module_function }}();
            upload_guide();
            status();
            _selectProp();
        }
    };
})();

jQuery(document).ready(function() {
    {{ cookiecutter.module_function }}.init();
});
