<?php
$id = isset($data['id']) && $data['id'] ? $data['id'] : '';
$name = isset($data['name']) && $data['name'] ? $data['name'] : '';
// ==================== begin: Add model fields ====================

// ==================== end: Add model fields ====================
?>
<!-- CONTENT HEADER -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">View {{ cookiecutter.module_name }}</h3>
        </div>
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__wrapper">
                <a href="<?php echo site_url('{{ cookiecutter.module_slug }}/update/'.$id);?>" class="btn btn-label-success btn-elevate btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <a href="<?php echo site_url('{{ cookiecutter.module_slug }}');?>" class="btn btn-label-instagram btn-sm btn-elevate">
                    <i class="fa fa-reply"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-md-6">

            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__body">

                    <!--begin::Portlet-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    General Information
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            <!--begin::Form-->
                            <div class="kt-widget13">
                                <div class="kt-widget13__item">
                                    <span class="kt-widget13__desc">
                                        Name
                                    </span>
                                    <span class="kt-widget13__text kt-widget13__text--bold"><?php echo $name; ?></span>
                                </div>
                                <!-- ==================== begin: Add fields details  ==================== -->

                                <!-- ==================== end: Add model details ==================== -->
                            </div>
                            <!--end::Form-->
                        </div>
                    </div>
                    <!--end::Portlet-->
                </div>
            </div>
            <!--end::Portlet-->

        </div>

        <div class="col-md-6">

        </div>
    </div>
</div>
<!-- begin:: Footer -->
