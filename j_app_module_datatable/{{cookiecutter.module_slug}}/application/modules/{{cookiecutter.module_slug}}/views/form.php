<script type="text/javascript">
    window.object_request_id = "<?php echo $id;?>";
    window.object_request_fillables = {};
    window.current_user_id = "<?=current_user_id();?>";
    window.object_status = "<?php echo $form_data['status'];?>";
    <?php foreach($fillables as $fillable):?>
    window.object_request_fillables["<?php echo $fillable;?>"] = null;
    <?php endforeach;?>
    window.is_editable = <?=$is_editable;?>;    
</script>
<div id="{{ cookiecutter.module }}_app">
    <!--begin::Form-->
    <form method="POST" class="kt-form kt-form--label-right" id="form_{{ cookiecutter.module }}" enctype="multipart/form-data"
          action="<?php form_open('{{ cookiecutter.module }}/form/' . @$obj['id']); ?>">
        <!-- CONTENT HEADER -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title"><?= $method ?> {{ cookiecutter.module_name }}</h3>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <button type="submit" class="btn btn-label-success btn-elevate btn-sm"
                                form="form_{{ cookiecutter.module }}"
                                data-ktwizard-type="action-submit" @click.prevent="submitRequest()">
                            <i class="fa fa-plus-circle"></i> Submit
                        </button>
                        <a href="<?php echo site_url('{{ cookiecutter.module }}'); ?>"
                           class="btn btn-label-instagram btn-elevate btn-sm">
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
                        <?php $this->load->view('form/_info'); ?>
                        <?php $this->load->view('form/_items'); ?>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
        <!-- begin:: Footer -->
    </form>
    <!--end::Form-->
</div>