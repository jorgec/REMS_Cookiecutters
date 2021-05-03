<?php
defined('BASEPATH') or exit('No direct script access allowed');

class {{ cookiecutter.model_name }} extends MY_Model {
    public $table = '{{ cookiecutter.module_plural }}'; // you MUST mention the table name
    public $primary_key = 'id';
    public $fillable = [
        'name',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
        'deleted_by',
        'deleted_at',
        ];
    public $protected = ['id']; // ...Or you can set an array with the fields that cannot be filled by insert/update
    public $rules = [];

    public $fields = [
        'name' => array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        /* ==================== begin: Add model fields ==================== */

        /* ==================== end: Add model fields ==================== */
    ];

    public function __construct()
    {
        parent::__construct();

        $this->soft_deletes = true;
        $this->return_as = 'array';

        $this->rules['insert'] = $this->fields;
        $this->rules['update'] = $this->fields;

        // for relationship tables
        // $this->has_many['table_name'] = array();
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