<div class="row">
{% for field, details in cookiecutter.fields.items() %}{% if details.meta.form_fillable == "True" %}
    <!-- start {{ field }} -->
    <div class="col-sm-12 col-md-6">
        <div class="form-group my-3">
            <label>{{ details.meta.label }} {% if details.db.NULL != "True" %}<span class="kt-font-danger">*</span>{% endif %}</label>
            <div class="kt-input-icon kt-input-icon--left">
            {% if details.meta.form_elem is defined %}
                {% if details.meta.form_elem == "suggests" %}
                    <select class="form-control suggests" data-module="{{ details.meta.table }}" id="{{ field }}"
                            name="{{ details.meta.key }}">
                            <option value="">{{ details.meta.label }}</option>
                            <?php if ({{ details.meta.suggests_repr }}) : ?>
                            <option value="<?php echo ${{ field }}; ?>" selected><?php echo {{ details.meta.suggests_repr }}; ?></option>
                            <?php endif ?>
                    </select>
                {% endif %}
                {% if details.meta.form_elem == "numeric" %}
                    <input type="number" min="0" step="0.01" class="form-control" id="{{ field }}" name="{{ field }}" placeholder="{{ details.meta.label }}">
                    <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i class="la la-user"></i></span>
                {% endif %}
                {% if details.meta.form_elem == "email" %}
                    <input type="email" class="form-control" id="{{ field }}" name="{{ field }}" placeholder="{{ details.meta.label }}">
                    <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i class="la la-user"></i></span>
                {% endif %}
                {% if details.meta.form_elem == "select" %}
                    <select class="form-control" id="{{ field }}" name="{{ field }}">
                        <option value="">
                            -- replace --
                        </option>
                    </select>
                    <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i class="la la-user"></i></span>
                {% endif %}
                {% if details.meta.form_elem == "static_dropdown" %}
                    <?php echo form_dropdown('{{ field }}', Dropdown::get_static('{{ details.meta.static_dropdown }}'), null, 'class="form-control"'); ?>
                    <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i class="la la-user"></i></span>
                {% endif %}
                {% if details.meta.form_elem == "date" %}
                    <input type="text" class="form-control kt_datepicker" placeholder="{{ details.meta.label }}" name="{{ field }}" id="{{ field }}" value="<?php echo set_value('{{ field }}"', @${{ field }}); ?>" readonly>
                    <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i class="la la-calendar"></i></span>
                {% endif %}
                {% if details.meta.form_elem == "textarea" %}
                    <textarea class="form-control" id="{{ field }}" name="{{ field }}"></textarea>
                    <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i class="la la-user"></i></span>
                {% endif %}
            {% else %}
                <input type="text" class="form-control" id="{{ field }}" name="{{ field }}" placeholder="{{ details.meta.label }}">
                <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i class="la la-user"></i></span>
            {% endif %}
            </div>
            <span class="form-text text-muted"></span>
        </div>
    </div>
    {% endif %}
    <!-- /end {{ field }} -->
{% endfor %}
</div>