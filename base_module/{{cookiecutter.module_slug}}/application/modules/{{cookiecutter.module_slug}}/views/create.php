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
<!--begin::Form-->
<form role="form" method="POST" class="kt-form kt-form--label-right" id="form">
    <input type="hidden" id="id" name="id" value="<?php echo $info['id'] ?>" readonly>
    <input type="hidden" id="transaction_id" name="transaction_id" value="8716" readonly>
    <!-- CONTENT HEADER -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title"><?= $method ?> {{ cookiecutter.module_name }}</h3>
            </div>
            <div class="kt-subheader__toolbar">
                <div class="kt-subheader__wrapper">
                    <button type="submit" class="btn btn-label-success btn-elevate btn-sm">
                        <i class="fa fa-plus-circle"></i> Update
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
        <div class="col-sm-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <?php $this->load->view('components/create/_create_main'); ?>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    <!-- begin:: Footer -->
</form>
<!--end::Form-->