<?php
    // {{ cookiecutter.module_name }} Information
    $id = isset($info['id']) && $info['id'] ? $info['id'] : '';
    $name = isset($info['name']) && $info['name'] ? $info['name'] : '';
    /* ==================== begin: Add model fields ==================== */

    /* ==================== end: Add model fields ==================== */
?>


<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Name <span class="kt-font-danger">*</span></label>
            <div class="kt-input-icon kt-input-icon--left">
                <input type="text" class="form-control" placeholder="Name" name="info[name]" value="<?php echo set_value('info[name]', @$name); ?>">
                <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i class="la la-pencil-square"></i></span>
            </div>
            <span class="form-text text-muted"></span>
        </div>
    </div>
</div>

