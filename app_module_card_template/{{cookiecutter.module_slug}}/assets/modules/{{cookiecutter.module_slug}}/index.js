"use strict";
var {{ cookiecutter.module_function }} = function () {

	var confirmDelete = function () {
		$(document).on('click', '.remove_{{ cookiecutter.module_slug }}', function () {
			var id = $(this).data('id');
            var btn = $(this);

			swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes, delete it!',
				cancelButtonText: 'No, cancel!',
				reverseButtons: true
			}).then(function (result) {
				if (result.value) {

					$.ajax({
						url: base_url + '{{ cookiecutter.module_slug }}/delete/' + id,
						type: 'POST',
						dataType: "JSON",
						data: { id: id },
						success: function (res) {
							if (res.status) {
								btn.closest('div.col-md-4').remove();
								swal.fire(
									'Deleted!',
									res.message,
									'success'
								);
							} else {
								swal.fire(
									'Oops!',
									res.message,
									'error'
								)
							}
						}
					});

				} else if (result.dismiss === 'cancel') {
					swal.fire(
						'Cancelled',
						'Your imaginary file is safe :)',
						'error'
					)
				}
			});
		});
	};

	var _add_ons = function () {

		$('#_export_select_all').on( 'click', function () {

			if ( this.checked ) {

				$('._export_column').each( function () {

					this.checked = true;
				});
			} else {

				$('._export_column').each( function () {

					this.checked = false;
				});
			}
		});

		$('._export_column').on( 'click', function () {

			if ( this.checked == false ) {

				$('#_export_select_all').prop('checked', false);
			}
		});

	};

	var generalSearch = function() {

		// General Search
		function load_data(keyword){
			var page_num = page_num ? page_num : 0;

			var keyword = keyword ? keyword: '';
			$.ajax({
				url: base_url + '{{ cookiecutter.module_slug }}/paginationData/'+page_num,
				method:"POST",
				data:'page='+page_num+'&keyword='+keyword,
				success:function(html){

					KTApp.block('#kt_content', {
						overlayColor: '#000000',
						type: 'v2',
						state: 'primary',
						message: 'Processing...',
						css: {
							padding:	0,
							margin:		0,
							width:		'30%',
							top:		'40%',
							left:		'35%',
							textAlign:	'center',
							color:		'#000',
							border:		'3px solid #aaa',
							backgroundColor:'#fff',
							cursor:		'wait'
						},

					});

					setTimeout(function() {

						$('#{{ cookiecutter.module_slug }}_content').html(html);

						KTApp.unblock('#kt_content');

					}, 2000);

				}
			})
		}

		$('#generalSearch').keyup(function(){

			var keyword = $(this).val();

			if(keyword !== ''){

				load_data(keyword);
			} else {

				load_data();
			}

		});
	};

	var advanceFilter = function() {

		function filter(name){

			var page_num = page_num ? page_num : 0;
			var name = name ? name: '';

			$.ajax({
				url: base_url + '{{ cookiecutter.module_slug }}/paginationData/'+page_num,
				method:"POST",
				data:'page='+page_num+'&name='+name,
				success:function(html){

					$('#filterModal').modal('hide');

					KTApp.block('#kt_content', {
						overlayColor: '#000000',
						type: 'v2',
						state: 'primary',
						message: 'Processing...',
						css: {
							padding:	0,
							margin:		0,
							width:		'30%',
							top:		'40%',
							left:		'35%',
							textAlign:	'center',
							color:		'#000',
							border:		'3px solid #aaa',
							backgroundColor:'#fff',
							cursor:		'wait'
						},

					});

					setTimeout(function() {

						$('#{{ cookiecutter.module_slug }}_content').html(html);

						KTApp.unblock('#kt_content');

					}, 500);


				}
			})
		}

		$('#advanceSearch').submit(function(e){
			e.preventDefault();
			var name = $('#filtername').val();

			if(name !== '' ){
				filter(name);
			} else {

				filter();
			}

		});
	};

	var _exportUploadCSV = function () {

		$('#_export_csv').validate({

			rules: {
				update_existing_data: {
					required: true,
				}
			},
			messages: {
				update_existing_data: {
					required: 'File type is required'
				}
			},
			invalidHandler: function ( event, validator ) {

				event.preventDefault();

				// var alert   =   $('#form_msg');
				// alert.closest('div.form-group').removeClass('kt-hide').show();
				KTUtil.scrollTop();

				toastr.options = {
				  "closeButton": true,
				  "debug": false,
				  "newestOnTop": false,
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
				};

				toastr.error("Please check your fields", "Something went wrong");
			},
			submitHandler: function ( _frm ) {

				_frm[0].submit();
			}
		});

		$('#_upload_form').validate({

			rules: {
				csv_file: {
					required: true,
				}
			},
			messages: {
				csv_file: {
					required: 'CSV file is required'
				}
			},
			invalidHandler: function ( event, validator ) {

				event.preventDefault();

				// var alert   =   $('#form_msg');
				// alert.closest('div.form-group').removeClass('kt-hide').show();
				KTUtil.scrollTop();

				toastr.options = {
				  "closeButton": true,
				  "debug": false,
				  "newestOnTop": false,
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
				};

				toastr.error("Please check your fields", "Something went wrong");
			},
			submitHandler: function ( _frm ) {

				_frm[0].submit();
			}
		});
	}

	var _initUploadGuideModal = function () {

		var _table = $('#_upload_guide_modal');

		_table.DataTable({
			order: [[ 0, 'asc']],
			pagingType: 'full_numbers',
			lengthMenu: [3, 5, 10, 25, 50, 100],
			pageLength : 5,
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: false,
			deferRender: true,
			dom:
						// "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'<'btn-block'B>>>" +
						// "<'row'<'col-sm-12 col-md-6'l>>" +
						"<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
						"<'row'<'col-sm-12'tr>>" +
						"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			language: {
				'lengthMenu': 'Show _MENU_',
        			'infoFiltered': '(filtered from _MAX_ total records)'
			},
			columnDefs: [
				{
					targets: [0, 2, 3, 5],
					className: 'dt-center',
				},
				{
					targets: [0, 2, 3, 4, 5],
					orderable: false,
				},
				{
					targets: [4, 5],
					searchable: false
				},
				{
					targets: 0,
					searchable: false,
					visible: false
				}
			]
		});
	};

	var bulkDelete = function () {

		$(document.body).on('change', '.delete_check' ,function(){

			if (  $('.delete_check:checked').length ) {

				$('#bulkDelete').removeAttr('disabled');

			} else {
				$('#bulkDelete').attr('disabled', 'disabled');
			}

		});

		$('#bulkDelete').click(function(){

			var deleteids_arr = [];

			// Read all checked checkboxes
			$('input[name="id[]"]:checked').each(function () {
			   deleteids_arr.push($(this).val());
			});

			// Check checkbox checked or not
			if(deleteids_arr.length > 0){

				swal.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					type: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes, delete it!',
					cancelButtonText: 'No, cancel!',
					reverseButtons: true
				}).then(function (result) {
					if (result.value) {

						$.ajax({
							url: base_url + '{{ cookiecutter.module_slug }}/bulkDelete/',
							type: 'POST',
							dataType: "JSON",
							data: { deleteids_arr: deleteids_arr },
							success: function (res) {
								if (res.status) {

									Swal.fire({
										title: "Deleted!",
										text: res.message,
										type: "success"
									  }).then((result) => {
										// Reload the Page
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
						});

					} else if (result.dismiss === 'cancel') {
						swal.fire(
							'Cancelled',
							'Your imaginary file is safe :)',
							'error'
						)
					}
				});
			}
		 });
	}

	return {

		//main function to initiate the module
		init: function () {
			confirmDelete();
			_add_ons();
			generalSearch();
			advanceFilter();
			_exportUploadCSV();
			_initUploadGuideModal();
			bulkDelete();
		},
	};

}();

jQuery(document).ready(function () {
	{{ cookiecutter.module_function }}.init();
});

function {{ cookiecutter.module_function }}Pagination(page_num){

	page_num = page_num?page_num:0;

	var keyword = $('#generalSearch').val();

	var name = name ? name: '';


	$.ajax({
		url: base_url + '{{ cookiecutter.module_slug }}/paginationData/'+page_num,
		method:"POST",
		data:'page='+page_num+'&name='+name,
		success:function(html){

			KTApp.block('#kt_content', {
				overlayColor: '#000000',
				type: 'v2',
				state: 'primary',
				message: 'Processing...',
				css: {
					padding:	0,
					margin:		0,
					width:		'30%',
					top:		'40%',
					left:		'35%',
					textAlign:	'center',
					color:		'#000',
					border:		'3px solid #aaa',
					backgroundColor:'#fff',
					cursor:		'wait'
				},

			});

			setTimeout(function() {

				$('#{{ cookiecutter.module_slug }}_content').html(html);

				KTApp.unblock('#kt_content');

			}, 500);
		}
	})
}