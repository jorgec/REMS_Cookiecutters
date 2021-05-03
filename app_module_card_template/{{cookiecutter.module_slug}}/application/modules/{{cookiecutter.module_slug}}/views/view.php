<?php
    // {{ cookiecutter.module_name }} Information
    $id = isset($info['id']) && $info['id'] ? $info['id'] : 'N/A';
    $name = isset($info['name']) && $info['name'] ? $info['name'] : 'N/A';
    /* ==================== begin: Add model fields ==================== */

    /* ==================== end: Add model fields ==================== */
?>

<!-- CONTENT HEADER -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">View {{ cookiecutter.module_name }}</h3>
        </div>
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__wrapper">
                <?php if($this->ion_auth->is_admin()): ?>
                    <a href="<?php echo site_url('{{ cookiecutter.module_slug }}/update/' . $id); ?>" class="btn btn-label-success btn-elevate btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                <?php endif; ?>
                <a href="<?php echo site_url('{{ cookiecutter.module_slug }}'); ?>" class="btn btn-label-instagram btn-sm btn-elevate">
                    <i class="fa fa-reply"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

    <!--begin:: Portlet-->
    <div class="kt-portlet ">
        <div class="kt-portlet__body">
            <div class="kt-widget kt-widget--user-profile-3">
                <div class="kt-widget__top">
                    <!-- <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-font-light kt-hidden-">
                        <?php echo get_initials($first_name . ' ' . $last_name); ?>
                    </div> -->
                    <?php if (get_image('{{ cookiecutter.module_slug }}', 'images', $image)) : ?>
                        <div class="kt-widget__media kt-hidden-">
                            <img src="<?php echo base_url(get_image('{{ cookiecutter.module_slug }}', 'images', $image)); ?>" width="110px" height="110px" />
                        </div>
                    <?php else : ?>
                        <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-font-light kt-hidden-">
                            <?php echo get_initials($name); ?>
                        </div>
                    <?php endif; ?>
                    <div class="kt-widget__content">
                        <div class="kt-widget__head">
                            <span class="kt-widget__username"><?php echo ucwords($name); ?></span>
                        </div>

                        <div class="kt-widget__desc">
                            <?php echo ucwords('Your Text Here'); ?>
                        </div>
                    </div>
                    <div class="kt-widget__stats kt-margin-t-20">
                        <div class="kt-widget__icon">
                            <i class="flaticon-piggy-bank"></i>
                        </div>
                        <div class="kt-widget__details">
                            <span class="kt-widget__title kt-font-bold">Total Paid</span><br>
                            <span class="kt-widget__value">P250,000.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#basic_information" role="tab" aria-selected="true">
                            <i class="flaticon2-user-outline-symbol"></i> Basic Information
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#contact_information" role="tab" aria-selected="false">
                            <i class="flaticon-support"></i> Contact Info
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="tab-content kt-margin-t-20">
                <!--Begin:: Tab Content-->
                <div class="tab-pane active" id="basic_information" role="tabpanel-1">
                    <div class="kt-form__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="row ">
                                    <div class="col">
                                        <div class="form-group form-group-xs row">
                                            <label class="col col-form-label text-right">Label Here:</label>
                                            <div class="col">
                                                <span class="form-control-plaintext kt-font-bolder"><!-- <?php echo Dropdown::get_static('buyer_type', $buyer_type_id, 'view'); ?> --></span>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-xs row">
                                            <label class="col col-form-label text-right">Label Here:</label>
                                            <div class="col">
                                                <span class="form-control-plaintext kt-font-bolder"><!-- <?php echo ucwords($last_name); ?> --></span>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-xs row">
                                            <label class="col col-form-label text-right">Label Here:</label>
                                            <div class="col">
                                                <span class="form-control-plaintext kt-font-bolder"><!-- <?php echo ucwords($birth_place); ?> --></span>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-xs row">
                                            <label class="col col-form-label text-right">Label Here:</label>
                                            <div class="col">
                                                <span class="form-control-plaintext kt-font-bolder"><!-- <?php echo Dropdown::get_static('civil_status', $civil_status_id, 'view'); ?> --></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group form-group-xs row">
                                            <label class="col-4 col-form-label text-right">&nbsp;</label>
                                            <div class="col-8">
                                                <span class="form-control-plaintext kt-font-bolder">&nbsp;</span>
                                            </div>
                                        </div>

                                        <div class="form-group form-group-xs row">
                                            <label class="col-4 col-form-label text-right">Label Here:</label>
                                            <div class="col-8">
                                                <span class="form-control-plaintext kt-font-bolder"><!-- <?php echo ucwords($first_name); ?> --></span>
                                            </div>
                                        </div>

                                        <div class="form-group form-group-xs row">
                                            <label class="col-4 col-form-label text-right">Label Here:</label>
                                            <div class="col-8">
                                                <span class="form-control-plaintext kt-font-bolder"><!-- <?php echo $birth_date; ?> --></span>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-xs row">
                                            <label class="col-4 col-form-label text-right">Label Here:</label>
                                            <div class="col">
                                                <span class="form-control-plaintext kt-font-bolder"><!-- <?php echo Dropdown::get_static('nationality', $nationality, 'view'); ?> --></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group form-group-xs row">
                                            <label class="col-4 col-form-label text-right">&nbsp;</label>
                                            <div class="col-8">
                                                <span class="form-control-plaintext kt-font-bolder">&nbsp;</span>
                                            </div>
                                        </div>

                                        <div class="form-group form-group-xs row">
                                            <label class="col-4 col-form-label text-right">Label Here:</label>
                                            <div class="col-8">
                                                <span class="form-control-plaintext kt-font-bolder"><!-- <?php echo ucwords($middle_name); ?> --></span>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-xs row">
                                            <label class="col-4 col-form-label text-right">Label Here:</label>
                                            <div class="col-8">
                                                <span class="form-control-plaintext kt-font-bolder"><!-- <?php echo ($gender == '1') ? 'Male' : 'Female'; ?> --></span>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-xs row">
                                            <label class="col-4 col-form-label text-right">Label Here:</label>
                                            <div class="col">
                                                <span class="form-control-plaintext kt-font-bolder"><!-- <?php echo Dropdown::get_static('housing_membership', $housing_membership_id, 'view'); ?> --></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End:: Tab Content-->

                <!--Begin:: Tab Content-->
                <div class="tab-pane" id="contact_information" role="tabpanel-2">
                    <div class="kt-form__body">
                        <div class="kt-section">
                            <div class="kt-section__body">
                                <div class="row justify-content-center">
                                    <div class="col">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End:: Tab Content-->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <!--begin:: Widgets/Order Statistics-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Collections Overview
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body  kt-portlet__body--fit">
                    <div class="row row-no-padding row-col-separator-lg">
                        <div class="col-md-12 col-lg-6 col-xl-3">
                            <!--begin::Total Profit-->
                            <div class="kt-widget24">
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                            Total Collected
                                        </h4>
                                        <span class="kt-widget24__stats kt-font-brand">
                                            PHP 4,003,566.32
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!--end::Total Profit-->
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-3">
                            <!--begin::Total Profit-->
                            <div class="kt-widget24">
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                            Total Open Receivables
                                        </h4>
                                        <span class="kt-widget24__stats kt-font-brand">
                                            PHP 4,003,566.32
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!--end::Total Profit-->
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-3">
                            <!--begin::Total Profit-->
                            <div class="kt-widget24">
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                            Total Over Due Collections
                                        </h4>
                                        <span class="kt-widget24__stats kt-font-brand">
                                            PHP 4,003,566.32
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!--end::Total Profit-->
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-3">
                            <!--begin::Total Profit-->
                            <div class="kt-widget24">
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                           Collections
                                           <br>
                                           <i>(due next 30 days)</i>
                                        </h4>
                                        <span class="kt-widget24__stats kt-font-brand">
                                            PHP 4,003,566.32
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!--end::Total Profit-->
                        </div>
                    </div>
                    <!-- To be Continued -->

                    <div class="row row-no-padding row-col-separator-lg">
                        <div class="col-lg-9">
                            <div id="kt_amcharts_1" style="height: 450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end:: Widgets/Order Statistics-->
        </div>
    </div>
</div>