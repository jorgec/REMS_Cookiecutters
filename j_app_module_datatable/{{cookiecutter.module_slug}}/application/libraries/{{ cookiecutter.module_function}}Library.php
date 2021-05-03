<?php


    class {{ cookiecutter.module_function }}Library
    {
        private $data = null;
        private $_model = null;
        private $CI = null;

        public function __construct()
        {
            $this->CI = &get_instance();
            $this->CI->load->model('{{ cookiecutter.module_slug }}/{{ cookiecutter.model_name }}', '_model');
        }

        public function get_obj($id, $with_relations = TRUE)
        {
            if( $with_relations ){
                $obj = $this->CI->_model{% for field, details in cookiecutter.fields.items() %}
                    {% if details.meta.is_one == "True" %}->with_{{ details.meta.module }}(){% endif %}
                {% endfor %}->get($id);
            }else{
                $obj = $this->CI->_model->get($id);
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
                $this->CI->_model->where('status', $status_list_arr);
            }

            $this->CI->_model->order_by('id', 'DESC');

            if (!$id) {
                {% for field, details in cookiecutter.fields.items() %}
                    ${{field}} = isset($params['{{field}}']) && !empty($params['{{field}}']) ? $params['{{field}}'] : null;
                    if(${{field}}){
                        $this->CI->_model->where('{{field}}', ${{field}});
                    }
                {% endfor %}                

            } else {
                $this->CI->_model->where('id', $id);
            }

            $this->CI->_model->order_by('id', 'DESC');

            if ($with_relations === 'yes') {
                $result = $this->CI->_model
                {% for field, details in cookiecutter.fields.items() %}
                    {% if details.meta.is_one == "True" %}->with_{{ details.meta.module }}(){% endif %}
                {% endfor %}
                ->get_all();
            } else {
                $result = $this->CI->_model->get_all();
            }

            return $result;
        }

        public function create_master($data, $additional)
        {
            $request = $this->CI->db->insert('{{ cookiecutter.module_plural }}', $data + $additional);
            if ($request) {
                return $this->CI->db->insert_id();
            } else {
                return false;
            }
        }

        public function update_master($id, $data, $additional)
        {
            $old_object = $this->CI->_model->get($id);
            return $this->CI->_model->update($data + $additional, $id);
        }

        
        

    }