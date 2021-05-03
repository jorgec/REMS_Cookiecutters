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
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                        <path
                                            d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                            id="Path-2" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                        <path
                                            d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                            id="Path" fill="#000000" fill-rule="nonzero"></path>
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
            <?php if($this->ion_auth->is_admin()): ?>
            <a href="<?php echo site_url('{{ cookiecutter.module_slug }}/create'); ?>" class="btn btn-label-primary btn-elevate btn-sm">
                <i class="fa fa-plus"></i> Add {{ cookiecutter.module_name }}
            </a>
            <button class="btn btn-label-primary btn-elevate btn-sm" data-toggle="modal" data-target="#filterModal">
                <i class="fa fa-filter"></i> Filter
            </button>
            <button type="button" id="_batch_upload_btn" class="btn btn-label-primary btn-elevate btn-sm"
                data-toggle="collapse" data-target="#_batch_upload" aria-expanded="true" aria-controls="_batch_upload">
                <i class="fa fa-upload"></i> Import
            </button>
            <button type="button" class="btn btn-label-primary btn-elevate btn-sm" data-toggle="modal"
                data-target="#_export_option">
                <i class="fa fa-download"></i> Export
            </button>
            <button type="button" class="btn btn-label-primary btn-elevate btn-sm" id="bulkDelete" disabled>
                <i class="fa fa-trash"></i> Delete Selected
            </button>
            <?php endif;?>
        </div>
    </div>
</div>

<!-- Batch Upload -->
<div id="_batch_upload" class="collapse kt-margin-b-35 kt-margin-t-10">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__body">
            <form class="kt-form" id="_export_csv" action="<?php echo site_url('{{ cookiecutter.module_slug }}/export_csv'); ?>" method="POST"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">File Type</label>
                            <div class="kt-input-icon  kt-input-icon--left">
                                <select class="form-control form-control-sm" name="update_existing_data">
                                    <option value=""> -- Update Existing Data -- </option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i
                                            class="la la-cloud-upload"></i></span></span>
                            </div>
                            <?php echo form_error('update_existing_data'); ?>
                            <span class="form-text text-muted"></span>
                        </div>
                    </div>
                </div>
            </form>
            <form class="kt-form" id="_upload_form" action="<?php echo site_url('{{ cookiecutter.module_slug }}/import'); ?>" method="POST"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">Upload CSV file:</label>
                            <label class="form-control-label text-muted">Note: Maximum of 1,000 items only per
                                file.</label>
                            <input type="file" name="csv_file" class="" size="1000" accept="*.csv">
                            <span class="form-text text-muted"></span>
                        </div>
                    </div>
                </div>
            </form>
            <div class="form-group form-group-last row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-brand btn-success btn-elevate btn-sm"
                                form="_upload_form">
                                <i class="fa fa-upload"></i> Upload
                            </button>
                        </div>
                        <div class="col-lg-6 kt-align-right">
                            <button type="submit"
                                class="btn btn-brand btn-success btn-elevate btn-icon btn-icon-lg btn-sm"
                                form="_export_csv">
                                <i class="fa fa-file-csv"></i>
                            </button>
                            <button type="button"
                                class="btn btn-brand btn-success btn-elevate btn-icon btn-icon-lg btn-sm"
                                data-toggle="modal" data-target="#upload_guide">
                                <i class="fa fa-info-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  Batch Upload Guide -->
<div class="modal fade" id="upload_guide" tabindex="-1" role="dialog" aria-labelledby="upload_guide_label"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="upload_guide_label">{{ cookiecutter.module_name }} Upload Guide</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <table
                    class="table table-head-bg-brand table-striped table-hover table-bordered table-condensed table-checkable"
                    id="_upload_guide_modal">
                    <thead>
                        <tr class="text-center">
                            <th width="1%" scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Format</th>
                            <th scope="col">Option</th>
                            <th scope="col">Required</th>
                        </tr>
                    </thead>
                    <?php if (isset($_fillables) && $_fillables): ?>

                    <tbody>
                        <?php foreach ($_fillables as $_fkey => $_fill): ?>
                        <?php
            $_no = isset($_fill['no']) && $_fill['no'] ? $_fill['no'] : '';
            $_name = isset($_fill['name']) && $_fill['name'] ? $_fill['name'] : '';
            $_type = isset($_fill['type']) && $_fill['type'] ? $_fill['type'] : '';
            $_required = isset($_fill['required']) && $_fill['required'] ? $_fill['required'] : '';
            $_dropdown = isset($_fill['dropdown']) && $_fill['dropdown'] && !empty($_fill['dropdown']) ? $_fill['dropdown'] : '';
        ?>

                        <tr>
                            <td><?php echo @$_no; ?></td>
                            <td class="_ug_name"><?php echo @$_name; ?></td>
                            <td><?php echo @$_type; ?></td>
                            <td>
                                <?php if ($_type === 'datetime'): ?>
                                yyyy-mm-dd (e.g. 2020-01-28)
                                <?php endif;?>
                            </td>
                            <td class="_ug_option">


                                <?php if ($_dropdown): ?>
                                <?php echo form_dropdown('dropdown', $_dropdown, '', 'class="form-control"'); ?>

                                <!-- <ul class="_ul"> -->
                                <?php //foreach ($_dropdown as $_dkey => $_drop): ?>
                                <!-- <li><?php //echo @$_drop; ?></li> -->
                                <?php //endforeach;?>
                                <!-- </ul> -->

                                <?php endif;?>


                            </td>
                            <td>
                                <?php if ($_required === 'Yes'): ?>
                                <span class="kt-font-danger">Yes</span>
                                <?php elseif ($_required === 'No'): ?>
                                No
                                <?php endif;?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                    <?php endif;?>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-elevate btn-outline-hover-brand btn-sm btn-icon-sm"
                    data-dismiss="modal">
                    <i class="la la-close"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="kt-container--fluid kt-grid__item kt-grid__item--fluid" id="{{ cookiecutter.module_slug }}_content">
    <?php $this->load->view('_filter'); ?>
</div>

<!-- EXPORT -->
<div class="modal fade" id="_export_option" tabindex="-1" role="dialog" aria-labelledby="_export_option_label"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="_export_option_label">Export Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" id="_export_form" target="_blank" action="<?php echo site_url('{{ cookiecutter.module_slug }}/export'); ?>"
                    method="POST">
                    <div class="row">
                        <?php if (isset($_columns) && $_columns) : ?>

                        <div class="col-lg-12">
                            <div class="kt-checkbox-list">
                                <label class="kt-checkbox kt-checkbox--bold">
                                    <input type="checkbox" id="_export_select_all"> Field
                                    <span></span>
                                </label>
                                <label class="kt-checkbox kt-checkbox--bold"></label>
                            </div>
                        </div>

                        <?php foreach ($_columns as $key => $_column) : ?>

                        <?php if ($_column) : ?>

                        <?php
                                    $_offset    =    '';
                                    if ($_column === reset($_columns)) {

                                        $_offset    =    'offset-lg-1';
                                    }
                                    ?>

                        <div class="col-lg-4">
                            <div class="kt-checkbox-list">
                                <?php foreach ($_column as $_ckey => $_clm) : ?>

                                <?php
                                                $_label    =    isset($_clm['label']) && $_clm['label'] ? $_clm['label'] : '';
                                                $_value    =    isset($_clm['value']) && $_clm['value'] ? $_clm['value'] : '';
                                                ?>

                                <label class="kt-checkbox kt-checkbox--bold">
                                    <input type="checkbox" name="_export_column[]" class="_export_column"
                                        value="<?php echo @$_value; ?>"> <?php echo @$_label; ?>
                                    <span></span>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>

                        <!-- Additional Fields -->
                        <div class="col-lg-4">
                            <div class="kt-checkbox-list">
                                <label class="kt-checkbox kt-checkbox--bold">
                                    <input type="checkbox" name="_export_column[]" class="_export_column"
                                        value="employment"> Employment Information
                                    <span></span>
                                </label>
                                <label class="kt-checkbox kt-checkbox--bold">
                                    <input type="checkbox" name="_export_column[]" class="_export_column"
                                        value="identifications"> Proof of Identification
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <?php else : ?>

                        <div class="col-lg-10 offset-lg-1">
                            <div class="form-group form-group-last">
                                <div class="alert alert-solid-danger alert-bold fade show" role="alert" id="form_msg">
                                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                    <div class="alert-text">
                                        Something went wrong. Please contact your system administrator.
                                    </div>
                                    <div class="alert-close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"><i class="la la-close"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="kt-form__actions btn-block">
                    <button type="button" class="btn btn-secondary btn-sm btn-elevate btn-font-sm pull-left"
                        data-dismiss="modal">
                        <i class="fa fa-times"></i> Close
                    </button>
                    <button type="submit"
                        class="btn btn-success btn-elevate btn-outline-hover-brand btn-sm btn-font-sm pull-right"
                        form="_export_form">
                        <i class="fa fa-file-export"></i> Export
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER MODAL -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
    aria-hidden="true">
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
                        <!-- Sample Filter
                        <div class="form-group col-md-6">
                            <label class="form-control-label">Buyer Type:</label>
                            <?php echo form_dropdown('filterBuyertype', Dropdown::get_static('buyer_type'), set_value('filterOccupationtype', ''), 'class="form-control" id="filterBuyertype"'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label">Occupation Type:</label>
                            <?php echo form_dropdown('filterOccupationtype', Dropdown::get_static('occupation_type'), set_value('filterOccupationtype', ''), 'class="form-control" id="filterOccupationtype"'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label">Occupation Location:</label>
                            <?php echo form_dropdown('filterOccupationlocation', Dropdown::get_static('occupation_location'), set_value('filterOccupationlocation', ''), 'class="form-control" id="filterOccupationlocation"'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label">Civil Status:</label>
                            <?php echo form_dropdown('filterCivilstatus', Dropdown::get_static('civil_status'), set_value('filterCivilstatus', ''), 'class="form-control" id="filterCivilstatus"'); ?>
                        </div>
                        -->
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