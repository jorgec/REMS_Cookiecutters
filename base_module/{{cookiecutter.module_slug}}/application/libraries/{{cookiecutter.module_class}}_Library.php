<?php


    class {{ cookiecutter.module_class }}Library
    {
        private $data = null;
        private $_model = null;
        private $CI = null;

        public function __construct()
        {
            $this->CI = &get_instance();
            $this->CI->load->model('{{ cookiecutter.module_slug }}/{{ cookiecutter.model_name }}', 'M_{{cookiecutter.module_class}}');
        }

        public function get_obj($id, $with_relations = TRUE)
        {
            if( $with_relations ){
                $obj = $this->CI->M_{{cookiecutter.module_class}}{% for field, details in cookiecutter.fields.items() %}
                    {% if details.meta.is_one == "True" %}->with_{{ details.meta.module }}(){% endif %}
                {% endfor %}->get($id);
            }else{
                $obj = $this->CI->M_{{cookiecutter.module_class}}->get($id);
            }

            return $obj;
        }


        public function search($params)
        {
            $id = isset($params['id']) ? $params['id'] : null;
            $with_relations = isset($params['with_relations']) ? $params['with_relations'] : 'yes';
            $status_list = isset($params['status_list']) && !empty($params['status_list']) ? $params['status_list'] : null;

            if ($status_list) {
                $status_list_arr = explode(",", $status_list);
                $this->CI->M_{{cookiecutter.module_class}}->where('status', $status_list_arr);
            }

            $this->CI->M_{{cookiecutter.module_class}}->order_by('id', 'DESC');

            if (!$id) {
                {% for field, details in cookiecutter.fields.items() %}
                    ${{field}} = isset($params['{{field}}']) && !empty($params['{{field}}']) ? $params['{{field}}'] : null;
                    if(${{field}}){
                        $this->CI->M_{{cookiecutter.module_class}}->where('{{field}}', ${{field}});
                    }
                {% endfor %}

            } else {
                $this->CI->M_{{cookiecutter.module_class}}->where('id', $id);
            }

            $this->CI->M_{{cookiecutter.module_class}}->order_by('id', 'DESC');

            if ($with_relations === 'yes') {
                $result = $this->CI->M_{{cookiecutter.module_class}}
                {% for field, details in cookiecutter.fields.items() %}
                    {% if details.meta.is_one == "True" %}->with_{{ details.meta.module }}(){% endif %}
                {% endfor %}
                ->get_all();
            } else {
                $result = $this->CI->M_{{cookiecutter.module_class}}->get_all();
            }

            return $result;
        }

        public function create($data, $additional)
        {
            $request = $this->CI->M_{{cookiecutter.module_class}}->insert($data + $additional);
            if ($request) {
                return $request;
            } else {
                return false;
            }
        }

        public function update($id, $data, $additional)
        {
            $old_object = $this->CI->M_{{cookiecutter.module_class}}->get($id);
            return $this->CI->M_{{cookiecutter.module_class}}->update($data + $additional, $id);
        }




    }