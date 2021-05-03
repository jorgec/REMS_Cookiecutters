<?php
$name = isset($info['name']) && $info['name'] ? $info['name'] : '';
// ==================== begin: Add model fields ====================

// ==================== end: Add model fields ====================

?>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Name <span class="kt-font-danger">*</span></label>
            <div class="kt-input-icon kt-input-icon--left">
                <input type="text" class="form-control" name="name" value="<?php echo set_value('name', $name); ?>" placeholder="Name" autocomplete="off">
                <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i class="la la-info"></i></span>
            </div>
            <?php echo form_error('name'); ?>
            <span class="form-text text-muted"></span>
        </div>
    </div>
    <!-- ==================== begin: Add form model fields ==================== -->

    <!-- ==================== end: Add form model fields ==================== -->
</div>