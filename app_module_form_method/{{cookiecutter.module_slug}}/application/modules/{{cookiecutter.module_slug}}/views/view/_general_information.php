<?php
//vdebug($info);
$id = isset($info['id']) && $info['id'] ? $info['id'] : "";
$name = isset($info['name']) && $info['name'] ? $info['name'] : "N/A";
/* ==================== begin: Add model fields ==================== */

/* ==================== end: Add model fields ==================== */

$created_date = view_date($info['created_at']);
$updated_date = view_date($info['updated_at']);
$encoded_by = $info['created_by'];
$updated_by = $info['updated_by'];

$encoder = get_person($encoded_by, 'staff');
$encoder_name = get_fname($encoder);

$updater = get_person($updated_by, 'staff');
$updater_name = get_fname($updater);
?>

<div class="row">
    <div class="col-sm-12">
        <!-- General Information -->
        <div class="kt-portlet">
            <div class="accordion accordion-solid accordion-toggle-svg" id="accord_general_information">
                <div class="card">
                    <div class="card-header" id="head_general_information">
                        <div class="card-title" data-toggle="collapse" data-target="#general_information"
                             aria-expanded="true" aria-controls="general_information">
                            General Information
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
                                    <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                          id="Path-94" fill="#000000" fill-rule="nonzero"/>
                                    <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                          id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3"
                                          transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="kt-separator kt-separator--border-solid kt-separator--space-none"></div>
                    <div id="general_information" class="collapse show" aria-labelledby="head_general_information"
                         data-parent="#accord_general_information">
                        <div class="card-body">
                            <div class="form-group form-group-xs row">
                                <div class="col-sm-6">
                                    <div href="#" class="kt-notification-v2__item">
                                        <div class="kt-notification-v2__itek-wrapper">
                                            <div class="kt-notification-v2__item-title">
                                                <h6 class="kt-portlet__head-title kt-font-primary">Name </h6>
                                            </div>
                                            <div class="kt-notification-v2__item-desc">
                                                <h6 class="kt-portlet__head-title kt-font-dark">
                                                    <?php echo $name; ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-xs row">
                                <div class="col-sm-6">
                                    <div href="#" class="kt-notification-v2__item">
                                        <div class="kt-notification-v2__itek-wrapper">
                                            <div class="kt-notification-v2__item-title">
                                                <h6 class="kt-portlet__head-title kt-font-primary">Encoded By</h6>
                                            </div>
                                            <div class="kt-notification-v2__item-desc">
                                                <h6 class="kt-portlet__head-title kt-font-dark">
                                                    <?php echo $encoder_name; ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div href="#" class="kt-notification-v2__item">
                                        <div class="kt-notification-v2__itek-wrapper">
                                            <div class="kt-notification-v2__item-title">
                                                <h6 class="kt-portlet__head-title kt-font-primary">Date Created</h6>
                                            </div>
                                            <div class="kt-notification-v2__item-desc">
                                                <h6 class="kt-portlet__head-title kt-font-dark">
                                                    <?php echo $created_date; ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-xs row">
                                <div class="col-sm-6">
                                    <div href="#" class="kt-notification-v2__item">
                                        <div class="kt-notification-v2__itek-wrapper">
                                            <div class="kt-notification-v2__item-title">
                                                <h6 class="kt-portlet__head-title kt-font-primary">Last Modified By</h6>
                                            </div>
                                            <div class="kt-notification-v2__item-desc">
                                                <h6 class="kt-portlet__head-title kt-font-dark">
                                                    <?php echo $updater_name; ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div href="#" class="kt-notification-v2__item">
                                        <div class="kt-notification-v2__itek-wrapper">
                                            <div class="kt-notification-v2__item-title">
                                                <h6 class="kt-portlet__head-title kt-font-primary">Last Modified On</h6>
                                            </div>
                                            <div class="kt-notification-v2__item-desc">
                                                <h6 class="kt-portlet__head-title kt-font-dark">
                                                    <?php echo $updated_date; ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>