<?php
defined('BASEPATH') or exit('No direct script access allowed');

class {{ cookiecutter.model_name }} extends MY_Model {
    public $table = '{{ cookiecutter.module_plural }}'; // you MUST mention the table name
    public $primary_key = 'id';
    public $fillable = [
        {% for field, details in cookiecutter.fields|dictsort %}"{{ field }}",
        {% endfor %}
        ];
    public $form_fillables = [
        {% for field, details in cookiecutter.fields|dictsort %}{% if details.meta.form_fillable == "True" %}"{{ field }}",{% endif %}
        {% endfor %}
        ];        
    public $protected = ['id']; // ...Or you can set an array with the fields that cannot be filled by insert/update
    public $rules = [];

    public $fields = [
        {% for field, details in cookiecutter.fields|dictsort %}{% if details.meta.form_fillable == "True" %}
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

        $this->soft_deletes = true;
        $this->return_as = 'array';

        $this->rules['insert'] = $this->fields;
        $this->rules['update'] = $this->fields;

        {% for field, details in cookiecutter.fields|dictsort %}
            {% if details.meta.is_one == "True" %}
        $this->has_one["{{ details.meta.module }}"] = array('foreign_model'=>'{{ details.meta.module }}/{{ details.meta.model }}','foreign_table'=>'{{ details.meta.table }}','foreign_key'=>'id','local_key'=>'{{ details.meta.fk }}');                
            {% endif %}
            {% if details.meta.is_many == "True" %}
        $this->has_many['{{ details.meta.module }}s'] = array('foreign_model'=>'{{ details.meta.module }}/{{ details.meta.model }}','foreign_table'=>'{{ details.meta.table }}','foreign_key'=>'{{ details.meta.fk }}','local_key'=>'id');
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

    public function insert_dummy()
    {
        require APPPATH.'/third_party/faker/autoload.php';
        $faker = Faker\Factory::create();

        $data = [];

        for($x = 0; $x < 10; $x++)
        {
            array_push($data,array(
                'name'=> $faker->word,
            ));
        }
        $this->db->insert_batch($this->table, $data);

    }
}