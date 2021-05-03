<!-- CONTENT HEADER -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                {{ cookiecutter.module_name }}
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc"><?php echo (!empty($totalRec)) ? $totalRec : 0; ?> TOTAL</span>
                <form class="kt-margin-l-20" id="kt_subheader_search_form">
                    <div class="kt-input-icon kt-input-icon--right kt-subheader__search">
                        <input type="text" class="form-control" placeholder="Search {{ cookiecutter.module_name }}..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--right">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                        <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" id="Path-2" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                        <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" id="Path" fill="#000000" fill-rule="nonzero"></path>
                                    </g>
                                </svg>

                                <!--<i class="flaticon2-search-1"></i>-->
                            </span>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <a href="<?php echo site_url('{{ cookiecutter.module_slug }}/form'); ?>" class="btn btn-label-primary btn-elevate btn-sm">
                <i class="fa fa-plus"></i> Add {{ cookiecutter.module_name }}
            </a>
            <button class="btn btn-label-primary btn-elevate btn-sm" data-toggle="modal" data-target="#filterModal">
                <i class="fa fa-filter"></i> Filter
            </button>

            <button type="button" class="btn btn-label-primary btn-elevate btn-sm" id="bulkDelete" disabled>
                <i class="fa fa-trash"></i> Delete Selected
            </button>
        </div>
    </div>
</div>


<!-- CONTENT -->
<div class="kt-container--fluid kt-grid__item kt-grid__item--fluid" id="payment_voucherContent">
    <?php $this->load->view('_filter'); ?>
</div>

<!-- FILTER MODAL -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="advanceSearch">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-control-label">Name</label>
                            <div class="kt-input-icon  kt-input-icon--left">
                                <input type="text" class="form-control form-control-sm _filter" placeholder="Name" id="_column_2" data-column="2" autocomplete="off">
                                <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i class="la la-user"></i></span></span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label">Transaction Type:</label>
                            <?php echo form_dropdown('filterTransactiontype', Dropdown::get_static('payment_request_type'), set_value('filterOccupationtype', ''), 'class="form-control" id="filterTransactiontype"'); ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="apply_filter" form="advanceSearch">Apply</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>