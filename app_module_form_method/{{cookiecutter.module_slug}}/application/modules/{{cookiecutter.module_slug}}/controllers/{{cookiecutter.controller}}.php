<?php
defined('BASEPATH') or exit('No direct script access allowed');

class {{ cookiecutter.controller }} extends MY_Controller
{
    private $fields = [
        // Add fields based on the table columns
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim',
        ),
        /* ==================== begin: Add model fields ==================== */

        /* ==================== end: Add model fields ==================== */
    ];

    public function __construct()
    {
        parent::__construct();

        ${{ cookiecutter.module_slug }}_models = array('{{ cookiecutter.module_slug }}/{{ cookiecutter.model_name }}' => '{{ cookiecutter.model_variable }}');

        // Load models
        $this->load->model('auth/Ion_auth_model', 'M_auth');
        $this->load->model('user/User_model', 'M_user');
        $this->load->model(${{ cookiecutter.module_slug }}_models);


        // Load pagination library
        $this->load->library('ajax_pagination');

        // Format Helper
        $this->load->helper(['format', 'images']);// Load Helper


        // Per page limit
        $this->perPage = 12;

        $this->_table_fillables = $this->{{ cookiecutter.model_variable }}->fillable;
        $this->_table_columns = $this->{{ cookiecutter.model_variable }}->__get_columns();

        $this->u_additional = [
            'updated_by' => $this->user->id,
            'updated_at' => NOW
        ];

        $this->additional = [
            'is_active' => 1,
            'created_by' => $this->user->id,
            'created_at' => NOW
        ];
    }

    public function template($page = "")
    {

        $this->template->build($page);
    }

    public function index()
    {
        $_fills = $this->_table_fillables;
        $_colms = $this->_table_columns;

        $this->view_data['_fillables'] = $this->__get_fillables($_colms, $_fills);
        $this->view_data['_columns'] = $this->__get_columns($_fills);

        // Get record count
        // $conditions['returnType'] = 'count';
        $this->view_data['totalRec'] = $totalRec = $this->{{ cookiecutter.model_variable }}->count_rows();

        // Pagination configuration
        $config['target'] = '#{{ cookiecutter.module_slug }}_content';
        $config['base_url'] = base_url('{{ cookiecutter.module_slug }}/paginationData');
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = '{{ cookiecutter.module_function }}Pagination';

        // Initialize pagination library
        $this->ajax_pagination->initialize($config);

        // Get records
        $this->view_data['records'] = $this->{{ cookiecutter.model_variable }}->as_array()->order_by('id', 'DESC')
            ->limit($this->perPage, 0)
            ->get_all();

        $this->template->build('index', $this->view_data);
    }

    public function paginationData()
    {
        if ($this->input->is_ajax_request()) {

            // Input from General Search
            $keyword = $this->input->get('keyword');
            $page = $this->input->get('page');

            // Input from Advanced Filter
            $values = $this->input->get();
            $offset = 0;


            if ($page) {
                $offset = $page;
            }

            $totalRec = $this->{{ cookiecutter.model_variable }}->count_rows();
            $where = array();

            // Pagination configuration
            $config['target'] = '#{{ cookiecutter.module_slug }}_content';
            $config['base_url'] = base_url('{{ cookiecutter.module_slug }}/paginationData');
            $config['total_rows'] = $totalRec;
            $config['per_page'] = $this->perPage;
            $config['link_func'] = '{{ cookiecutter.module_function }}Pagination';

            unset($values['page']);
            unset($values['keyword']);

            // Query
            if ($values) {
                foreach ($values as $key => $n_value) {
                    if ($n_value)
                        $this->db->where($key, $n_value);
                }
            }

            $totalRec = $this->{{ cookiecutter.model_variable }}->count_rows();

            // Pagination configuration
            $config['total_rows'] = $totalRec;

            // Initialize pagination library
            $this->ajax_pagination->initialize($config);

            // Query
            if ($values) {
                foreach ($values as $key => $n_value) {
                    if ($n_value)
                        $this->db->where($key, $n_value);
                }
            }
            $this->view_data['records'] = $records = $this->{{ cookiecutter.model_variable }}->order_by('id', 'DESC')
                ->limit($this->perPage, 0)
                ->get_all();

            $this->load->view('{{ cookiecutter.module_slug }}/_filter', $this->view_data, false);
        }
    }

    public function view($id = FALSE, $type = '')
    {

        if ($id) {

            $this->view_data['info'] = $this->{{ cookiecutter.model_variable }}->get($id);


            if ($this->view_data['info']) {

                if ($type == "debug") {

                    vdebug($this->view_data);

                }

                $this->template->build('view', $this->view_data);

            } else {

                show_404();
            }

        } else {

            show_404();
        }
    }

    public function form($id = FALSE)
    {
        $method = "Create";
        if ($id) {
            $method = "Update";
        }

        if ($this->input->post()) {

            $response['status'] = 0;
            $response['msg'] = 'Oops! Please refresh the page and try again.';

            $this->form_validation->set_rules($this->fields);

            if ($this->form_validation->run() === TRUE) {

                $oof = $this->input->post();

                if ($id) {
                    $additional = [
                        'updated_by' => $this->user->id,
                        'updated_at' => NOW
                    ];

                    ${{ cookiecutter.module_slug }}_id = $this->{{ cookiecutter.model_variable }}->update($oof + $additional, $id);

                } else {
                    $additional = [
                        'created_by' => $this->user->id,
                        'created_at' => NOW
                    ];

                    $this->db->trans_start(); # Starting transaction
                    $this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well

                    ${{ cookiecutter.module_slug }}_id = $this->{{ cookiecutter.model_variable }}->insert($oof + $additional);

                    $this->db->trans_complete(); # Completing transaction
                }

                /*Optional*/
                if ($this->db->trans_status() === FALSE) {
                    # Something went wrong.
                    $this->db->trans_rollback();
                    $response['status'] = 0;
                    $response['message'] = 'Error!';
                } else {
                    # Everything is Perfect.
                    # Committing data to the database.
                    $this->db->trans_commit();
                    $response['status'] = 1;
                    $response['message'] = '{{ cookiecutter.module_name }} Successfully ' . $method . 'd!';
                }

            } else {
                $response['status'] = 0;
                $response['message'] = validation_errors();
            }

            echo json_encode($response);
            exit();
        }

        $this->view_data['method'] = $method;

        if ($id) {
            $this->view_data['info'] = $data = $this->{{ cookiecutter.model_variable }}->get($id);
        }

        $this->template->build('form', $this->view_data);
    }

    public function delete()
    {
        $response['status'] = 0;
        $response['message'] = 'Oops! Please refresh the page and try again.';

        $id = $this->input->post('id');
        if ($id) {

            $list = $this->{{ cookiecutter.model_variable }}->get($id);
            if ($list) {

                $deleted = $this->{{ cookiecutter.model_variable }}->delete($list['id']);
                if ($deleted !== FALSE) {

                    $response['status'] = 1;
                    $response['message'] = '{{ cookiecutter.model_name }} successfully deleted';
                }
            }
        }

        echo json_encode($response);
        exit();
    }

    public function bulkDelete()
    {
        $response['status'] = 0;
        $response['message'] = 'Oops! Please refresh the page and try again.';

        if ($this->input->is_ajax_request()) {
            $delete_ids = $this->input->post('deleteids_arr');

            if ($delete_ids) {
                foreach ($delete_ids as $value) {

                    $deleted = $this->{{ cookiecutter.model_variable }}->delete($value);
                }
                if ($deleted !== FALSE) {

                    $response['status'] = 1;
                    $response['message'] = '{{ cookiecutter.model_name }} successfully deleted';
                }
            }
        }

        echo json_encode($response);
        exit();
    }
}

