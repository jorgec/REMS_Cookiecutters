<!-- CONTENT HEADER -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">View {{ cookiecutter.module_name }}</h3>
        </div>
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__wrapper">
                <a href="
                    <?php echo site_url('{{ cookiecutter.module }}/form/'.$data['id']);?>" class="btn btn-label-success btn-elevate btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <a href="<?php echo site_url('{{ cookiecutter.module }}'); ?>"
                   class="btn btn-label-instagram btn-sm btn-elevate">
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
                    <div class="kt-widget13">                        
                        {% for field, details in cookiecutter.fields.items() %}{% if details.meta.form_fillable == "True" %}
                        <div class="kt-widget13__item">
                            <span class="kt-widget13__desc">
                                {{ details.meta.label }}
                            </span>
                            <span class="kt-widget13__text kt-widget13__text--bold">                            
                                {% if details.meta.is_one %}<?php echo $data['{{ details.meta.module }}']['name'];?>{% else %}<?php echo $data['{{ field }}']; ?>{% endif %}
                            </span>
                        </div>
                        {% endif %}{% endfor %}
                        
                        <!-- ==================== end: Add model details ==================== -->
                    </div>
                    <!--end::Portlet-->
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-widget13__item">
                                    <span class="kt-widget13__desc">
                                        Created
                                    </span>
                        <span class="kt-widget13__text kt-widget13__text--bold"><?php echo $data['created_at']; ?> by <?php echo get_person_name($data['created_by'], 'staff');?></span>
                    </div>
                    <div class="kt-widget13__item">
                                    <span class="kt-widget13__desc">
                                        Updated
                                    </span>
                        <span class="kt-widget13__text kt-widget13__text--bold"><?php echo $data['updated_at']; ?> by <?php echo get_person_name($data['updated_by'], 'staff');?></span>
                    </div>
                </div>
            </div>
            <!--end::Portlet-->

        </div>

        <div class="col-md-6">
            <div class="kt-portlet">
                <div class="kt-portlet__body">

                    <!--begin::Portlet-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Items
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Unit Cost</th>
                                        <th>SobTotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td><?= $item['item']['name']; ?></td>
                                            <td><?= $item['quantity']; ?></td>
                                            <td><?= mrr_item_status_lookup($item['status']);?></td>
                                            <td><?= money_php($item['unit_cost']); ?></td>
                                            <td><?= money_php($item['total_cost']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- begin:: Footer -->
