<!-- CONTENT HEADER -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">{{ cookiecutter.module_name }}</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <span class="kt-subheader__desc" id="total"></span>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-input-icon kt-input-icon--right kt-subheader__search">
                <input type="text" class="form-control" placeholder="Search {{ cookiecutter.module_name }}..." id="generalSearch">
                <span class="kt-input-icon__icon kt-input-icon__icon--right">
                    <span><i class="flaticon2-search-1"></i></span>
                </span>
            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__wrapper">
                <button type="button" id="_batch_upload_btn" class="btn btn-label-primary btn-elevate btn-sm"
                        data-toggle="collapse" data-target="#_batch_upload" aria-expanded="true"
                        aria-controls="_batch_upload">
                    <i class="fa fa-upload"></i> Import
                </button>
                <button type="button" class="btn btn-label-primary btn-elevate btn-sm" data-toggle="modal"
                        data-target="#_export_option">
                    <i class="fa fa-download"></i> Export
                </button>
            </div>
        </div>
    </div>
</div>

<div class="module__cta">
    <div class="kt-container  kt-container--fluid ">
        <div class="module__create">
                <a href="<?php echo site_url('{{ cookiecutter.module_slug }}/form'); ?>"
                    class="btn btn-label-primary btn-elevate btn-sm">
                    <i class="fa fa-plus"></i> Create {{ cookiecutter.module_name }}
                </a>
        </div>

        <div class="module__filter">
                <button class="btn btn-label-primary btn-elevate btn-sm btn-filter" id="_advance_search_btn"
                    data-toggle="collapse" data-target="#_advance_search" aria-expanded="true" >
                    <i class="fa fa-filter"></i> Filter
                </button>
        </div>
    </div>
</div>

<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
        <!--begin: Advance Search -->
        <div id="_advance_search" class="collapse kt-margin-b-35 kt-margin-t-10">
            <div class="row">
                <div class="col-lg-12">
                    <form class="kt-form">
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="form-control-label">ID</label>
                                <div class="kt-input-icon  kt-input-icon--left">
                                    <input type="text" name="{{ cookiecutter.module_slug }}_id"
                                           class="form-control form-control-sm _filter" placeholder="ID" id="_column_1"
                                           data-column="1">
                                    <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i
                                                    class="la la-object-group"></i></span></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label class="form-control-label">Name</label>
                                <div class="kt-input-icon  kt-input-icon--left">
                                    <input type="text" name="{{ cookiecutter.module_slug }}_name"
                                           class="form-control form-control-sm _filter" placeholder="Name"
                                           id="_column_2"
                                           data-column="2">
                                    <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i
                                                    class="la la-object-group"></i></span></span>
                                </div>
                            </div>
                            <!-- ==================== begin: Add filter fields ==================== -->

                            <!-- ==================== end: Add filter fields ==================== -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end: Advance Search -->

        <!-- Batch Upload -->
        <div id="_batch_upload" class="collapse kt-margin-b-35 kt-margin-t-10">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__body">
                    <form class="kt-form" id="_export_csv" action="<?php echo site_url('{{ cookiecutter.module_slug }}/export_csv'); ?>"
                          method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label">File Type</label>
                                    <div class="kt-input-icon  kt-input-icon--left">
                                        <select class="form-control form-control-sm" name="update_existing_data"
                                                required>
                                            <option value=""> -- Update Existing Data --</option>
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
                    <form class="kt-form" id="_upload_form" action="<?php echo site_url('{{ cookiecutter.module_slug }}/import'); ?>"
                          method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label">Upload CSV file:</label>
                                    <label class="form-control-label text-muted">Note: Maximum of 1,000 items only per
                                        file.</label>
                                    <input type="file" name="csv_file" class="" size="1000" accept="*.csv" required>
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

        <!--begin: Datatable -->
        <table class="table table-striped- table-bordered table-hover table-checkable" id="{{ cookiecutter.module_slug }}_table">
            <thead>
            <tr>
                <th width="1%">
                    <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid">
                        <input type="checkbox" value="all" class="m-checkable" id="select-all">
                        <span></span>
                    </label>
                </th>
                <th>ID</th>
                <th>Name</th>
                <!-- ==================== begin: Add header fields ==================== -->

                <!-- ==================== end: Add header fields ==================== -->
                <th>Action</th>
            </tr>
            </thead>
        </table>
        <!--end: Datatable -->

    </div>
</div>

<!--begin::Modal-->
<!--begin: Export Modal-->
<!-- <div class="modal fade show" id="_export_option" tabindex="-1" role="dialog" aria-labelledby="_export_option_label" aria-hidden="true" style="padding-right: 15px; display: block;"> -->
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
                <form class="kt-form" id="_export_form" target="_blank"
                      action="<?php echo site_url('{{ cookiecutter.module_slug }}/export'); ?>" method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group form-group-last kt-hide">
                                <div class="alert alert-solid-danger alert-bold fade show" role="alert" id="form_msg">
                                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                    <div class="alert-text">
                                        Oh snap! You need select at least one.
                                    </div>
                                    <div class="alert-close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"><i class="la la-close"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($_columns) && $_columns): ?>

                            <div class="col-lg-11 offset-lg-1">
                                <div class="kt-checkbox-list">
                                    <label class="kt-checkbox kt-checkbox--bold">
                                        <input type="checkbox" id="_export_select_all"> Field
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox kt-checkbox--bold"></label>
                                </div>
                            </div>

                            <?php foreach ($_columns as $key => $_column): ?>

                                <?php if ($_column): ?>

                                    <?php
                                    $_offset = '';
                                    if ($_column === reset($_columns)) {

                                        $_offset = 'offset-lg-1';
                                    }
                                    ?>

                                    <div class="col-lg-5 <?php echo isset($_offset) && $_offset ? $_offset : ''; ?>">
                                        <div class="kt-checkbox-list">
                                            <?php foreach ($_column as $_ckey => $_clm): ?>

                                                <?php
                                                $_label = isset($_clm['label']) && $_clm['label'] ? $_clm['label'] : '';
                                                $_value = isset($_clm['value']) && $_clm['value'] ? $_clm['value'] : '';
                                                ?>

                                                <label class="kt-checkbox kt-checkbox--bold">
                                                    <input type="checkbox" name="_export_column[]"
                                                           class="_export_column"
                                                           value="<?php echo @$_value; ?>"> <?php echo @$_label; ?>
                                                    <span></span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>

                            <div class="col-lg-10 offset-lg-1">
                                <div class="form-group form-group-last">
                                    <div class="alert alert-solid-danger alert-bold fade show" role="alert"
                                         id="form_msg">
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
<!--end: Export Modal-->

<!--begin: Guide Modal-->
<!-- <div class="modal fade show" id="upload_guide" tabindex="-1" role="dialog" aria-labelledby="upload_guide_label" aria-hidden="true" style="padding-right: 15px; display: block;"> -->
<div class="modal fade" id="upload_guide" tabindex="-1" role="dialog" aria-labelledby="upload_guide_label"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="upload_guide_label">Upload Guide</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-head-bg-brand table-striped table-hover table-bordered table-condensed table-checkable"
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
                                <td></td>
                                <td class="_ug_option">
                                    <?php if ($_dropdown): ?>

                                        <ul class="_ul">
                                            <?php foreach ($_dropdown as $_dkey => $_drop): ?>

                                                <li><?php echo @$_drop; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($_required === 'Yes'): ?>

                                        <span class="kt-font-danger">Yes</span>
                                    <?php elseif ($_required === 'No'): ?>

                                        No
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    <?php endif; ?>
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
<!--end: Guide Modal-->
<!--end::Modal-->
