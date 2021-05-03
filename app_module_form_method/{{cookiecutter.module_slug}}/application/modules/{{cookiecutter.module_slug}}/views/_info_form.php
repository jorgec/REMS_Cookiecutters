<?php
$id = isset($info['id']) && $info['id'] ? $info['id'] : '';
$name = isset($info['name']) && $info['name'] ? $info['name'] : '';
/* ==================== begin: Add model fields ==================== */

/* ==================== end: Add model fields ==================== */
?>
<div class="row">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="">Name</label>
                    <div class="kt-input-icon kt-input-icon--left">
                        <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="<?php echo set_value('name"', @$name); ?>" autocomplete="off">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i class="la la-bookmark"></i></span>
                    </div>
                    <span class="form-text text-muted"></span>
                </div>
            </div>
        </div>
    </div>
</div>
