<?php
    $id = isset($info['id']) && $info['id'] ? $info['id'] : 'N/A';
?>

<div class="kt-subheader kt-grid__item" id="kt_subheader">
	<div class="kt-container kt-container--fluid">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">{{ cookiecutter.module_name }} Details</h3>
		</div>
		<div class="kt-subheader__toolbar">
			<div class="kt-subheader__wrapper">
                <a href="<?php echo site_url('{{ cookiecutter.module_slug }}/form/' . $id); ?>" class="btn btn-label-success btn-elevate btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
				<a href="<?php echo site_url('{{ cookiecutter.module_slug }}'); ?>" class="btn btn-label-instagram btn-sm btn-elevate">
					<i class="fa fa-reply"></i> Back
				</a>
			</div>
		</div>
	</div>
</div>

<div class="kt-grid kt-wizard-v3 kt-wizard-v3--white" id="{{ cookiecutter.module_slug }}_view" data-ktwizard-state="step-first">
	<div class="kt-portlet">
		<div class="kt-portlet__body kt-portlet__body--fit">
			<div class="kt-grid__item">

				<!--begin: Form Wizard Nav -->
				<div class="kt-wizard-v3__nav">
                    <div class="kt-wizard-v3__nav-items">
                        <!--begin: Form Wizard Nav Item -->
                        <a class="kt-wizard-v3__nav-item" data-ktwizard-type="step" data-ktwizard-state="current">
                            <div class="kt-wizard-v3__nav-body">
                                <div class="kt-wizard-v3__nav-label">
                                    General Information
                                </div>
                                <div class="kt-wizard-v3__nav-bar"></div>
                            </div>
                        </a>
                        <!--end: Form Wizard Nav Item -->
					</div>
				</div>
				<!--end: Form Wizard Nav -->
			</div>
		</div>
	</div>

	<div class="kt-grid__item kt-grid__item--fluid --kt-wizard-v3__wrapper">

		<!--begin: Form Wizard Step 1-->
		<div class="kt-wizard-v3__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
			<?php $this->load->view('view/_general_information'); ?>
		</div>
		<!--end: Form Wizard Step 1-->

	</div>
</div>