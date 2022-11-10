<?php
defined('BASEPATH') or exit('No direct script access allowed');

class {{cookiecutter.module_class}}_model extends MY_Model
{
    public $table = '{{cookiecutter.model_db}}'; // you MUST mention the table name
    public $primary_key = 'id'; // you MUST mention the primary key
    public $fillable = [
        {% for field, details in cookiecutter.fields.items() %}"{{ field }}",
        {% endfor %}
    ]; // If you want, you can set an array with the fields that can be filled by insert/update

    public $protected = [
        {% for field, details in cookiecutter.fields.items() %}{% if details.meta.form_fillable != "True" %}"{{ field }}",{% endif %}
        {% endfor %}
    ]; // ...Or you can set an array with the fields that cannot be filled by insert/update
    public $rules = [];

    public $fields = [
        {% for field, details in cookiecutter.fields.items() %}{% if details.meta.form_fillable == "True" %}
        "{{ field }}" => array(
            "field" => "{{ field }}",
            "label" => "{{ details.meta.label }}",
            "rules" => "{{ details.meta.rules }}"
        ),{% endif %}
        {% endfor %}
    ];

    public function __construct()
    {
        parent::__construct();

        $this->soft_deletes = TRUE;
        $this->return_as = 'array';

        // Pagination
        $this->pagination_delimiters = array('<li class="kt-pagination__link--next">', '</li>');
        $this->pagination_arrows = array('<i class="fa fa-angle-left kt-font-brand"></i>', '<i class="fa fa-angle-right kt-font-brand"></i>');

        $this->rules['insert']	=	$this->fields;
        $this->rules['update']	=	$this->fields;

        {% for field, details in cookiecutter.fields.items() %}
            {% if details.meta.is_one == "True" %}
                $this->has_one["{{ details.meta.module }}"] = array('foreign_model'=>'{{ details.meta.module }}/{{ details.meta.model }}','foreign_table'=>'{{ details.meta.table }}','foreign_key'=>'{{ details.meta.key }}','local_key'=>'{{ details.meta.fk }}');
            {% endif %}
            {% if details.meta.is_many == "True" %}
                $this->has_many['{{ details.meta.module }}s'] = array('foreign_model'=>'{{ details.meta.module }}/{{ details.meta.model }}','foreign_table'=>'{{ details.meta.table }}','foreign_key'=>'{{ details.meta.fk }}','local_key'=>'{{ details.meta.key }}');
            {% endif %}
        {% endfor %}
    }

    function get_columns() {
        $_return = FALSE;

        if ($this->fillable) {
            $_return = $this->fillable;
        }

        return $_return;
    }
}