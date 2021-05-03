<!--begin::Form-->
<form method="POST" class="kt-form kt-form--label-right" id="form_{{ cookiecutter.module_slug }}" enctype="multipart/form-data"
      action="<?php form_open('{{ cookiecutter.module_slug }}/form/' . @$info['id']); ?>">
    <!-- CONTENT HEADER -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title"><?= $method ?> {{ cookiecutter.module_name}}</h3>
            </div>
            <div class="kt-subheader__toolbar">
                <div class="kt-subheader__wrapper">
                    <button type="submit" class="btn btn-label-success btn-elevate btn-sm" form="form_{{ cookiecutter.module_slug }}"
                            data-ktwizard-type="action-submit">
                        <i class="fa fa-plus-circle"></i> Submit
                    </button>
                    <a href="<?php echo site_url('{{ cookiecutter.module_slug }}'); ?>" class="btn btn-label-instagram btn-elevate btn-sm">
                        <i class="fa fa-reply"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class=" kt-portlet__body">
                    <?php $this->load->view('view/_form'); ?>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    <!-- begin:: Footer -->
</form>
<!--end::Form-->