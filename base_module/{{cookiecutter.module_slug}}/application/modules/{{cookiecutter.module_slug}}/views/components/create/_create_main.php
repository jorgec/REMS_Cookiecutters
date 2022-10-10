<div class="row">
{% for field, details in cookiecutter.fields.items() %}{% if details.meta.form_fillable == "True" %}
    <div class="col-sm-12 col-md-6">
        <div class="form-group my-3">
            <label>{{ details.meta.label }} <span class="kt-font-danger">*</span></label>
            <div class="kt-input-icon kt-input-icon--left">
            {% if details.meta.form_elem is defined %}
                {% if details.meta.form_elem == "suggests" %}
                    <select class="form-control suggests" data-module="{{ details.meta.table }}" id="{{ field }}"
                            name="{{ details.meta.key }}">
                        <?php if (${{field}}): ?>
                            <option value="<?php echo ${{field}}['id']; ?>"
                                    selected><?php echo ${{field}}['name']; ?></option>
                        <?php endif ?>
                    </select>
                    <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i class="la la-user"></i></span>
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
            {% else %}
                <input type="text" class="form-control" id="{{ field }}" name="{{ field }}" placeholder="{{ details.meta.label }}">
                <span class="kt-input-icon__icon kt-input-icon__icon--left"><span><i class="la la-user"></i></span>
            {% endif %}
            </div>
            <span class="form-text text-muted"></span>
        </div>
    </div>
    {% endif %}
{% endfor %}
</div>