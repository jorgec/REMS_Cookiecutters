<?php 
defined('BASEPATH') or exit('No direct script access allowed.');

class Migration_Initial_{{ cookiecutter.module_plural }} extends CI_Migration {
    protected $tbl = "{{ cookiecutter.module_plural }}";
    protected $fields = array(
        {% for field, details in cookiecutter.fields.items() %}
            "{{ field }}" =>  array(
                {% for key, value in details.db.items() %}
                    {% if value == "True" or value == "False" %}"{{ key }}" => {{ value }},
                    {% else %}"{{ key }}" => "{{ value }}",
                    {% endif %}
                {% endfor %}
            ),
        {% endfor %}
    );

    public function up() {     
        if (! $this->db->table_exists($this->tbl)) {
            $this->dbforge->add_field($this->fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table($this->tbl, TRUE);
        }
        
    }

    public function down() {
        if ($this->db->table_exists($this->tbl)) {
            $this->dbforge->drop_table($this->tbl);
        }
    }
}
