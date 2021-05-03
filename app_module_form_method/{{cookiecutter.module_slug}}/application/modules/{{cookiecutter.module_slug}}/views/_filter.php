<?php if (!empty($records)) : ?>
    <div class="row" id="transactionList">
        <?php foreach ($records as $r) : ?>
            <?php
                $id = ( $r['id'] ? $r['id'] : "" );
                $name = ( $r['name'] ? $r['name'] : "N/A" );
                /* ==================== begin: Add model fields ==================== */

                /* ==================== end: Add model fields ==================== */

                $is_complete = ($r['is_complete'] ? "Completed" : "Incomplete");
                $status = ( $r['is_complete'] ? "kt-badge--success" : "kt-badge--danger" );
            ?>
        <!--begin:: Portlet-->
        <div class="kt-portlet ">
            <div class="kt-portlet__body">
                <div class="kt-widget kt-widget--user-profile-3">
                    <div class="kt-widget__top">
                        <div class="kt-widget__media kt-hidden">
                            <img src="./assets/media/project-logos/3.png" alt="image">
                        </div>
                        <div
                            class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light kt-hidden-">
                            <?php echo get_initials($name); ?>
                        </div>
                        <div class="kt-widget__content">
                            <div class="kt-widget__head">
                                <a href="<?php echo base_url(); ?>{{ cookiecutter.module_slug }}/view/<?php echo $id?>" class="kt-widget__username">
                                    Name : <?php echo $name; ?>
                                    <i class="flaticon2-correct"></i>
                                </a>
                                <div class="kt-widget__action">
                                    <div class="kt-portlet__head kt-portlet__head--noborder" style="min-height: 0px;">
                                        <div class="kt-portlet__head-label">
                                            <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid">
                                                <input type="checkbox" name="id[]" value="<?php echo $r['id']; ?>" class="m-checkable delete_check" data-id="<?php echo $r['id']; ?>">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="kt-portlet__head-toolbar">
                                            <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                                <i class="flaticon-more-1 kt-font-brand"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="kt-nav">
                                                    <li class="kt-nav__item">
                                                        <a href="<?php echo base_url('{{ cookiecutter.module_slug }}/view/' . $id); ?>" class="kt-nav__link">
                                                            <i class="kt-nav__link-icon flaticon2-checking"></i>
                                                            <span class="kt-nav__link-text">View</span>
                                                        </a>
                                                    </li>
                                                    <li class="kt-nav__item">
                                                        <a href="<?php echo base_url('{{ cookiecutter.module_slug }}/form/' . $id); ?>" class="kt-nav__link">
                                                            <i class="kt-nav__link-icon flaticon2-checking"></i>
                                                            <span class="kt-nav__link-text">Update</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-widget__info">
                                <div class="kt-widget__desc">
                                    <a href="#" class="kt-widget__username">
                                        Label  : <?php echo 'Data Here'; ?>
                                    </a>
                                    <br>
                                    <a href="#" class="kt-widget__username">
                                        Label  : <?php echo 'Data Here'; ?>
                                    </a>
                                    <br>
                                    <a href="#" target="_BLANK" class="kt-widget__username">
                                        Label : <?php echo 'Data Here'; ?>
                                    </a>
                                </div>
                                <div class="kt-widget__desc">
                                    <a href="#" class="kt-widget__username">
                                        Label  : <?php echo 'Data Here'; ?>
                                    </a>
                                    <br>
                                    <a href="#" target="_BLANK" class="kt-widget__username">
                                        Label : <?php echo 'Data Here'; ?>
                                    </a>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-widget__bottom">
                        <div class="kt-widget__item">
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">Date</span>
                                <span class="kt-widget__value"><?php echo view_date('10/10/2020'); ?></span>
                            </div>
                        </div>

                        <div class="kt-widget__item">
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">Amount</span>
                                <span class="kt-widget__value"><?php echo money_php('10000'); ?></span>
                            </div>
                        </div>

                        <div class="kt-widget__item">
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">Amount</span>
                                <span class="kt-widget__value"><?php echo money_php('10000'); ?></span>
                            </div>
                        </div>

                        <div class="kt-widget__item">
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">Rate</span>
                                <span class="kt-widget__value"><?php echo money_php('1000'); ?> (<?php echo "10"."%"; ?>)</span>
                            </div>
                        </div>
                        <div class="kt-widget__item">
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">Status</span>
                                <span class="kt-widget__value">
                                    <span class="kt-badge <?=$status;?> kt-badge--inline kt-badge--pill kt-badge--rounded" style="color:white">
                                        <?=$is_complete;?>
                                        </span>
                                </span>
                            </div>
                        </div>
                         <div class="kt-widget__item">
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">Remarks</span>
                                <span class="kt-widget__value"><?php echo 'Information Here'; ?></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php endforeach; ?>
    </div>

    <div class="row">
        <div class="col-xl-12">

            <!--begin:: Components/Pagination/Default-->
            <div class="kt-portlet">
                <div class="kt-portlet__body">

                    <!--begin: Pagination-->
                    <div class="kt-pagination kt-pagination--brand">
                        <?php echo $this->ajax_pagination->create_links(); ?>

                        <div class="kt-pagination__toolbar">
                            <span class="pagination__desc">
                                <?php echo $this->ajax_pagination->show_count(); ?>
                            </span>
                        </div>
                    </div>

                    <!--end: Pagination-->
                </div>
            </div>

            <!--end:: Components/Pagination/Default-->
        </div>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="kt-portlet kt-callout">
                <div class="kt-portlet__body">
                    <div class="kt-callout__body">
                        <div class="kt-callout__content">
                            <h3 class="kt-callout__title">No Records Found</h3>
                            <p class="kt-callout__desc">
                                Sorry no record were found.
                            </p>
                        </div>
                        <div class="kt-callout__action">
                            <a href="<?php echo base_url('{{ cookiecutter.module_slug }}/form'); ?>" class="btn btn-custom btn-bold btn-upper btn-font-sm btn-brand">Add Record Here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>