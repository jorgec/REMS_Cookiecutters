<?php
defined('BASEPATH') or exit('No direct script access allowed');
defined('APPPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/TraitBaseController.php';

class {{cookiecutter.module_class}} extends MY_Controller
{
    use TraitBaseController;
    public function __construct()
    {
        parent::__construct();

        private $__errors = array(
            'create' => null,
            'update' => null,
        );

        // models
        $this->load->model('{{cookiecutter.module_class}}_model', 'M_{{cookiecutter.module_class}}');

        // libraries
        $this->_lib = new {{ cookiecutter.module_class }}Library();

        // Load pagination library
        $this->load->library('ajax_pagination');

        // Format Helper
        $this->load->helper(['form', 'format', 'images']); // Load Helper

        // Per page limit
        $this->perPage = 12;

        $this->_table_fillables = $this->M_{{cookiecutter.module_class}}->fillable;
        $this->_table_columns = $this->M_{{cookiecutter.module_class}}->__get_columns();

        $this->_create_additional = ['created_by' => $this->user->id, 'created_at' => NOW];
        $this->_update_additional = ['updated_by' => $this->user->id, 'updated_at' => NOW];
    }

    # region public methods
    public function search()
    {
        $result = $this->__search($_GET);

        header('Content-Type: application/json');
        echo json_encode($result);

    }

    public function {{ cookiecutter.show_function_plural }}()
    {
        header('Content-Type: application/json');
        $output = ['data' => ''];

        if(property_exists($this->M_{{cookiecutter.module_class}}, 'form_fillables')){
            $fillables = $this->M_{{cookiecutter.module_class}}->form_fillables;
        }else{
            $fillables = $this->M_{{cookiecutter.module_class}}->fillable;
        }

        $columnsDefault = [];
        foreach($fillables as $field){
            $columnsDefault[$field] = true;
        }
        // optionally add relations

        if (isset($_REQUEST['columnsDef']) && is_array($_REQUEST['columnsDef'])) {
            $columnsDefault = [];
            foreach ($_REQUEST['columnsDef'] as $field) {
                $columnsDefault[$field] = true;
            }
        }

        // get all raw data
        $objects = $this->__search($_GET);
        $data = [];

        if ($objects) {

            foreach ($objects as $d) {
                $data[] = $this->filterArray($d, $columnsDefault);
            }

            // count data
            $totalRecords = $totalDisplay = count($data);

            // filter by general search keyword
            if (isset($_REQUEST['search'])) {
                $data = $this->filterKeyword($data, $_REQUEST['search']);
                $totalDisplay = count($data);
            }

            if (isset($_REQUEST['columns']) && is_array($_REQUEST['columns'])) {
                foreach ($_REQUEST['columns'] as $column) {
                    if (isset($column['search'])) {
                        $data = $this->filterKeyword($data, $column['search'], $column['data']);
                        $totalDisplay = count($data);
                    }
                }
            }

            // sort
            if (isset($_REQUEST['order'][0]['column']) && $_REQUEST['order'][0]['dir']) {
                $column = $_REQUEST['order'][0]['column'];
                $dir = $_REQUEST['order'][0]['dir'];
                usort($data, function ($a, $b) use ($column, $dir) {
                    $a = array_slice($a, $column, 1);
                    $b = array_slice($b, $column, 1);
                    $a = array_pop($a);
                    $b = array_pop($b);

                    if ($dir === 'asc') {
                        return $a > $b ? true : false;
                    }

                    return $a < $b ? true : false;
                });
            }

            // pagination length
            if (isset($_REQUEST['length'])) {
                $data = array_splice($data, $_REQUEST['start'], $_REQUEST['length']);
            }

            // return array values only without the keys
            if (isset($_REQUEST['array_values']) && $_REQUEST['array_values']) {
                $tmp = $data;
                $data = [];
                foreach ($tmp as $d) {
                    $data[] = array_values($d);
                }
            }
            $secho = 0;
            if (isset($_REQUEST['sEcho'])) {
                $secho = intval($_REQUEST['sEcho']);
            }

            $output = array(
                'sEcho' => $secho,
                'sColumns' => '',
                'iTotalRecords' => $totalRecords,
                'iTotalDisplayRecords' => $totalDisplay,
                'data' => $data,
            );

        }

        echo json_encode($output);
        exit();
    }

    public function index()
    {
        $_fills = $this->_table_fillables;
        $_colms = $this->_table_columns;

        $this->view_data['_fillables'] = $this->__get_fillables($_colms, $_fills);
        $this->view_data['_columns'] = $this->__get_columns($_fills);

        $db_columns = $this->_table_columns;
        if ($db_columns) {
            $column = [];
            foreach ($db_columns as $key => $dbclm) {
                $name = isset($dbclmn) && $dbclmn ? $dbclmn : '';

                if ((strpos($name, 'created_') === false) && (strpos($name, 'updated_') === false) && (strpos($name, 'deleted_') === false) && ($name !== 'id')) {
                    if (strpos($name, '_id') !== false) {
                        $column = $name;
                        $column[$key]['value'] = $column;
                        $name = isset($name) && $name ? str_replace('_id', '', $name) : '';
                        $_title = isset($name) && $name ? str_replace('_', ' ', $name) : '';
                        $column[$key]['label'] = ucwords(strtolower($_title));
                    } elseif (strpos($name, 'is_') !== false) {
                        $column = $name;
                        $column[$key]['value'] = $column;
                        $name = isset($name) && $name ? str_replace('is_', '', $name) : '';
                        $_title = isset($name) && $name ? str_replace('_', ' ', $name) : '';
                        $column[$key]['label'] = ucwords(strtolower($_title));
                    } else {
                        $column[$key]['value'] = $name;
                        $_title = isset($name) && $name ? str_replace('_', ' ', $name) : '';
                        $column[$key]['label'] = ucwords(strtolower($_title));
                    }
                } else {
                    continue;
                }
            }

            $column_count = count($column);
            $cceil = ceil(($column_count / 2));

            $this->view_data['columns'] = array_chunk($column, $cceil);
            $column_group = $this->M_{{cookiecutter.module_class}}->count_rows();
            if ($column_group) {
                $this->view_data['total'] = $column_group;
            }

        }

        $this->css_loader->queue(['vendors/custom/datatables/datatables.bundle.css']);
        $this->js_loader->queue(['vendors/custom/datatables/datatables.bundle.js']);

        $this->template->build('index', $this->view_data);
    }

    public function create()
    {
        if(property_exists($this->M_{{cookiecutter.module_class}}, 'form_fillables')){
            $fillables = $this->M_{{cookiecutter.module_class}}->form_fillables;
        }else{
            $fillables = $this->M_{{cookiecutter.module_class}}->fillable;
        }

        $method = "create";
        $obj = null;
        $reference = null;
        $form_data = fill_form_data($fillables);
        $is_editable = 1;

        $this->view_data['fillables'] = $fillables;
        $this->view_data['current_user'] = $this->user->id;
        $this->view_data['method'] = $method;
        $this->view_data['obj'] = $obj;
        $this->view_data['id'] = $id ? $id : null;
        $this->view_data['form_data'] = $form_data;

        $this->template->build('create', $this->view_data);
    }

    public function api_create()
    {
        header('Content-Type: application/json');
        if ($this->input->post()) {
            $__request = $this->input->post('request');
            $request = [];
            $items = $this->input->post('items');

            if(property_exists($this->M_{{cookiecutter.module_class}}, 'form_fillables')){
                $fillables = $this->M_{{cookiecutter.module_class}}->form_fillables;
            }else{
                $fillables = $this->M_{{cookiecutter.module_class}}->fillable;
            }

            foreach ($fillables as $field) {
                if (array_key_exists($field, $__request)) {
                    $request[$field] = $__request[$field];
                }
            }

            $this->db->trans_start();
            $this->db->trans_strict(false);

            $additional = array(
                'created_at' => NOW,
                'created_by' => $this->user->id
            );

            $request_object = $this->process_create($request, $additional);

            $this->db->trans_complete(); # Completing request
            if ($this->db->trans_status() === false || !$request_object) {
                # Something went wrong.
                $this->db->trans_rollback();
                $response['status'] = 0;
                $response['message'] = $this->__errors['create'];
            } else {
                # Everything is Perfect.
                # Committing data to the database.
                $this->db->trans_commit();

                $response['status'] = 1;
                $response['message'] = 'Request Successfully saved!';
            }

            echo json_encode($response);
            exit();
        }
    }

    public function api_update($id)
    {
        header('Content-Type: application/json');
        $additional = [
            'updated_by' => $this->user->id,
            'updated_at' => NOW,
        ];
        if ($this->input->post()) {
            $__request = $this->input->post('request');
            $request = [];
            $items = $this->input->post('items');

            if(property_exists($this->M_{{cookiecutter.module_class}}, 'form_fillables')){
                $fillables = $this->M_{{cookiecutter.module_class}}->form_fillables;
            }else{
                $fillables = $this->M_{{cookiecutter.module_class}}->fillable;
            }

            foreach ($fillables as $key) {
                if (array_key_exists($key, $__request)) {
                    $request[$key] = $__request[$key];
                }
            }

            $this->db->trans_start();
            $this->db->trans_strict(false);
            $request_object = $this->process_update($id, $request, $additional);

            $this->db->trans_complete(); # Completing request
            if ($this->db->trans_status() === false) {
                # Something went wrong.
                $this->db->trans_rollback();
                $response['status'] = 0;
                $response['message'] = $this->__errors['update'];
            } else {
                # Everything is Perfect.
                # Committing data to the database.
                $this->db->trans_commit();

                $response['status'] = 1;
                $response['message'] = 'Successfully updated!';
            }

            echo json_encode($response);
            exit();

        }
    }

    # endregion public methods

    # region private methods
    private function __get_obj($id, $with_relations=TRUE)
    {
        return $this->_lib->get_obj($id, $with_relations);
    }

    private function __search($params)
    {
        return $this->_lib->search($params);
    }

    private function process_create($data, $additional)
    {
        // $data['reference'] = uniqid{{ cookiecutter.model_name }}();

        $form_data = $data + additional;
        $this->form_validation->set_data($form_data);
        $this->form_validation->set_rules($this->M_{{cookiecutter.module_class}}->fields);

        if ($this->form_validation->run() === true) {
            $result = $this->_lib->create($data, $additional);
            if($result){
                return $result;
            }
            return false;
        }else{
            $this->_form_errors['create'] = validation_errors();
            return false;
        }
    }

    private function process_update($id, $data, $additional)
    {
        $result = $this->_lib->update($id, $data, $additional);
        if($result){
            return $result;
        }else{
            return false;
        }
    }
    # endregion private methods

}