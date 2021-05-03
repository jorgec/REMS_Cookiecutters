<?php
defined('BASEPATH') or exit('No direct script access allowed');

class {{ cookiecutter.controller }} extends MY_Controller
{

    private $__errors = array(
        'create_master' => null,
        'create_slave' => null,
        'update_master' => null,
        'update_slave' => null,
    );

    private $_lib = null;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('{{ cookiecutter.model_name }}', '_model');
        
        $this->load->helper('form');
        $this->load->library('{{ cookiecutter.module_function }}Library');
        $this->_lib = new {{ cookiecutter.module_function }}Library();

        $this->_table_fillables = $this->_model->fillable;      
        $this->_form_fillables = $this->_model->form_fillables;  
        $this->_table_columns = $this->_model->__get_columns();
    }

    #region private methods
    private function __get_obj($id, $with_relations=TRUE)
    {
        return $this->_lib->get_obj($id, $with_relations);
    }

    private function __search($params)
    {
        return $this->_lib->search($params);
    }

    private function process_create_master($data, $additional)
    {
        $data['reference'] = uniqid{{ cookiecutter.model_name }}();

        $form_data = $data + additional;
        $this->form_validation->set_data($form_data);
        $this->form_validation->set_rules($this->_model->fields);

        if ($this->form_validation->run() === true) {

            return $this->_lib->create_master($data, $additional);
        }else{
            $this->_form_errors['create_master'] = validation_errors();
            return false;
        }
    }

    private function process_create_slave($data, $references, $additional)
    {
        $this->load->model('{{ cookiecutter.module }}_item/{{ cookiecutter.model }}_item_model', 'M_item');
        if(property_exists($this->M_item, 'form_fillables')){
            $fillables = $this->M_item->form_fillables;
        }else{
            $fillables = $this->M_item->fillable;
        }

        $item = [];
        foreach($fillables as $field){
            if(key_exists($field, $data)){
                $item[$field] = $data[$field];
            }else{
                if(key_exists($field, $references)){
                    $item[$field] = $references[$field];
                }
            }
        }

        return $this->M_item->insert($item);
    }

    private function process_update_master($id, $data, $additional)
    {
        return $this->_lib->update_master($id, $data, $additional);
    }

    function process_update_slave($data, $additional, $references)
    {
        $id = isset($data['id']) ? $data['id'] : null;
        $this->load->model('{{ cookiecutter.module }}_item/{{ cookiecutter.model }}_item_model', 'M_item');

        $temp_data = $data + $additional;
        $update_data = [];
        if(property_exists($this->M_item, 'form_fillables')){
            $fillables = $this->M_item->form_fillables;
        }else{
            $fillables = $this->M_item->fillable;
        }
        foreach ($fillables as $key) {
            if (array_key_exists($key, $temp_data)) {
                $update_data[$key] = $temp_data[$key];
            }
        }

        if ($id) {
            // return $this->db->update('material_receiving_items');
            return $this->M_item->update($update_data, $id);
        } else {
            $additional = [
                'created_by' => $additional['updated_by'],
                'created_at' => $additional['updated_at']
            ];

            return $this->process_create_slave($data, $references, $additional);
        }
    }

    private function process_purge_deleted($items, $additional)
    {
        $this->load->model('{{ cookiecutter.module }}_item/{{ cookiecutter.model }}_item_model', 'M_item');
        if ($items) {
            foreach ($items as $item) {
                if ($item) {
                    $this->M_item->delete($item);
                }
            }
        }
    }
    # endregion


    // API
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

        if(property_exists($this->_model, 'form_fillables')){
            $fillables = $this->_model->form_fillables;
        }else{
            $fillables = $this->_model->fillable;
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

    public function process_create()
    {
        header('Content-Type: application/json');
        if ($this->input->post()) {
            $__request = $this->input->post('request');
            $request = [];
            $items = $this->input->post('items');

            if(property_exists($this->_model, 'form_fillables')){
                $fillables = $this->_model->form_fillables;
            }else{
                $fillables = $this->_model->fillable;
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

            $request_object = $this->process_create_master($request, $additional);
            if ($request_object) {
                $references = array(
                    '{{ cookiecutter.module_slug }}_id' => $request_object,
                );
                foreach ($items as $item) {
                    $this->process_create_slave($item, $references, $additional);
                }
            }

            $this->db->trans_complete(); # Completing request
            if ($this->db->trans_status() === false || !$request_object) {
                # Something went wrong.
                $this->db->trans_rollback();
                $response['status'] = 0;
                $response['message'] = $this->__errors['create_master'] + $this->__errors['create_slave'];
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
    
    public function process_update($id)
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

            if(property_exists($this->_model, 'form_fillables')){
                $fillables = $this->_model->form_fillables;
            }else{
                $fillables = $this->_model->fillable;
            }

            foreach ($fillables as $key) {
                if (array_key_exists($key, $__request)) {
                    $request[$key] = $__request[$key];
                }
            }

            $this->db->trans_start();
            $this->db->trans_strict(false);
            $request_object = $this->process_update_master($id, $request, $additional);
            if ($request_object) {
                $references = [
                    '{{ cookiecutter.module_slug }}_id' => $id,
                ];
                foreach ($items as $item) {
                    $this->process_update_slave($item, $additional, $references);
                }
            }
            $deleted_items = $this->input->post('deleted_items');

            $this->db->trans_complete(); # Completing request
            if ($this->db->trans_status() === false) {
                # Something went wrong.
                $this->db->trans_rollback();
                $response['status'] = 0;
                $response['message'] = 'Error!';
            } else {
                # Everything is Perfect.
                # Committing data to the database.
                $this->db->trans_commit();
                $this->process_purge_deleted($deleted_items, $additional);

                $response['status'] = 1;
                $response['message'] = 'Successfully saved!';
            }

            echo json_encode($response);
            exit();

        }
    }

    // http

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
            $column_group = $this->_model->count_rows();
            if ($column_group) {
                $this->view_data['total'] = $column_group;
            }

        }

        $this->css_loader->queue(['vendors/custom/datatables/datatables.bundle.css']);
        $this->js_loader->queue([
            'vendors/custom/datatables/datatables.bundle.js',
            'js/vue2.js',
            'js/axios.min.js',
            'js/utils.js'
        ]);        

        $this->template->build('index', $this->view_data);
    }


    public function form($id = false)
    {
        if(property_exists($this->_model, 'form_fillables')){
            $fillables = $this->_model->form_fillables;
        }else{
            $fillables = $this->_model->fillable;
        }
        if ($id) {
            $method = "Update";
            $obj = $this->__get_obj($id);
            if(in_array('reference', $fillables)){
                $reference = $obj['reference'];
            }else{
                $reference = null;
            }

            $form_data = fill_form_data($fillables, $obj);
            {% for field, details in cookiecutter.fields.items() %}
                {% if details.meta.is_one == "True" %}$this->view_data['{{ details.meta.module }}'] = $obj['{{ details.meta.module }}'];{% endif %}
            {% endfor %}

        } else {
            $method = "Create";
            $obj = null;
            $reference = null;
            $form_data = fill_form_data($fillables);
        }
        $is_editable = 1;

        $this->view_data['fillables'] = $fillables;
        $this->view_data['current_user'] = $this->user->id;
        $this->view_data['method'] = $method;
        $this->view_data['obj'] = $obj;
        $this->view_data['id'] = $id ? $id : null;
        $this->view_data['form_data'] = $form_data;
        $this->view_data['reference'] = $reference;

        $this->js_loader->queue([
            'js/vue2.js',
            'js/axios.min.js',
            'js/utils.js'
        ]);

        $this->template->build('form', $this->view_data);

        
    }

    public function delete()
    {
        $response['status'] = 0;
        $response['message'] = 'Oops! Please refresh the page and try again.';

        $id = $this->input->post('id');
        if ($id) {

            $list = $this->_model->get($id);
            if ($list) {

                $deleted = $this->_model->delete($list['id']);
                if ($deleted !== false) {

                    $response['status'] = 1;
                    $response['message'] = '{{ cookiecutter.module_name }} Successfully Deleted';
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
                    $data = [
                      'deleted_by' => $this->session->userdata['user_id']
                    ];
                    $this->db->update('item_group', $data, array('id' => $value));
                    $deleted = $this->_model->delete($value);
                }
                if ($deleted !== false) {

                    $response['status'] = 1;
                    $response['message'] = '{{ cookiecutter.module_name }} Successfully Deleted';
                }
            }
        }

        echo json_encode($response);
        exit();
    }

    public function view($id = FALSE)
    {
        if ($id) {
            $this->css_loader->queue(['vendors/custom/datatables/datatables.bundle.css']);
            $this->js_loader->queue(['vendors/custom/datatables/datatables.bundle.js']);

            $this->view_data['data'] = $this->__get_obj($id);

            if ($this->view_data['data']) {

                $this->template->build('view', $this->view_data);
            } else {

                show_404();
            }
        } else {
            show_404();
        }
    }

    public function import() {

        $file = $_FILES['csv_file']['tmp_name'];
        $inputFileType = PHPExcel_IOFactory::identify($file);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($file);

        $sheetData = $objPHPExcel->getActiveSheet()->toArray();
        $err = 0;


        foreach($sheetData as $key => $upload_data)
        {

            if($key > 0)
            {

                if ($this->input->post('status') == '1'){
                    $fields = array(
                        'name' => $upload_data[0],
                        /* ==================== begin: Add model fields ==================== */

                        /* ==================== end: Add model fields ==================== */
                    );

                    ${{ cookiecutter.module_slug }}_id = $upload_data[0];
                    ${{ cookiecutter.module_slug }} = $this->_model->get(${{ cookiecutter.module_slug }}_id);

                    if(${{ cookiecutter.module_slug }}){
                        $result = $this->_model->update($fields, ${{ cookiecutter.module_slug }}_id);
                    }

                } else {

                    if( ! is_numeric($upload_data[0]))
                    {
                        $fields = array(
                            'name' => $upload_data[1],
                            /* ==================== begin: Add model fields ==================== */

                            /* ==================== end: Add model fields ==================== */
                        );

                        $result = $this->{{ cookiecutter.model_variable}}->insert($fields);
                    } else {
                        $fields = array(
                            'name' => $upload_data[0],
                            /* ==================== begin: Add model fields ==================== */

                            /* ==================== end: Add model fields ==================== */
                        );

                        $result = $this->_model->insert($fields);
                    }

                }
                if ($result === FALSE) {

                    // Validation
                    $this->notify->error('Oops something went wrong.');
                    $err = 1;
                    break;
                }
            }
        }

        if($err == 0)
        {
            $this->notify->success('CSV successfully imported.', '{{ cookiecutter.module_slug }}');
        }
        else{
            $this->notify->error('Oops something went wrong.');
        }

        header('Location: '. base_url().'{{ cookiecutter.module_slug }}');
        die();
    }

    public function export_csv()
    {
        if ( $this->input->post() && ($this->input->post('update_existing_data') !== '') ) {

            $_ued	=	$this->input->post('update_existing_data');

            $_is_update	=	$_ued === '1' ? TRUE : FALSE;

            $_alphas		=	[];
            $_datas			=	[];

            $_titles[]	=	'id';

            $_start	=	3;
            $_row		=	2;

            $_filename	=	'{{ cookiecutter.module_name }} CSV Template.csv';

            $_fillables	=	$this->_table_fillables;
            if ( !$_fillables ) {

                $this->notify->error('Something went wrong. Please refresh the page and try again.', '{{ cookiecutter.module_slug }}');
            }

            foreach ( $_fillables as $_fkey => $_fill ) {

                if ( (strpos( $_fill, 'created_') === FALSE) && (strpos( $_fill, 'updated_') === FALSE) && (strpos( $_fill, 'deleted_') === FALSE) ) {

                    $_titles[]	=	$_fill;
                } else {

                    continue;
                }
            }

            if ( $_is_update ) {

                $_group	=	$this->_model->as_array()->get_all();
                if ( $_group ) {

                    foreach ( $_titles as $_tkey => $_title ) {

                        foreach ( $_group as $_dkey => $li ) {

                            $_datas[$li['id']][$_title]	=	isset($li[$_title]) && ($li[$_title] !== '') ? $li[$_title] : '';
                        }
                    }
                }
            } else {

                if ( isset($_titles[0]) && $_titles[0] && strtolower($_titles[0]) === 'id' ) {

                    unset($_titles[0]);
                }
            }

            $_alphas			=	$this->__get_excel_columns(count($_titles));
            $_xls_columns	=	array_combine($_alphas, $_titles);
            $_firstAlpha	=	reset($_alphas);
            $_lastAlpha		=	end($_alphas);

            $_objSheet	=	$this->excel->getActiveSheet();
            $_objSheet->setTitle('{{ cookiecutter.module_name }}');
            $_objSheet->setCellValue('A1', '{{ cookiecutter.module_name.upper() }}');
            $_objSheet->mergeCells('A1:'.$_lastAlpha.'1');

            foreach ( $_xls_columns as $_xkey => $_column ) {

                $_objSheet->setCellValue($_xkey.$_row, $_column);
            }

            if ( $_is_update ) {

                if ( isset($_datas) && $_datas ) {

                    foreach ( $_datas as $_dkey => $_data ) {

                        foreach ( $_alphas as $_akey => $_alpha ) {

                            $_value	=	isset($_data[$_xls_columns[$_alpha]]) ? $_data[$_xls_columns[$_alpha]] : '';

                            $_objSheet->setCellValue($_alpha.$_start, $_value);
                        }

                        $_start++;
                    }
                } else {

                    $_objSheet->setCellValue($_firstAlpha.$_start, 'No Record Found');
                    $_objSheet->mergeCells($_firstAlpha.$_start.':'.$_lastAlpha.$_start);

                    $_style	=	array(
                        'font'  => array(
                            'bold'	=>	FALSE,
                            'size'	=>	9,
                            'name'	=>	'Verdana'
                        )
                    );
                    $_objSheet->getStyle($_firstAlpha.$_start.':'.$_lastAlpha.$_start)->applyFromArray($_style)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                }
            }

            foreach ( $_alphas as $_alpha ) {

                $_objSheet->getColumnDimension($_alpha)->setAutoSize(TRUE);
            }

            $_style	=	array(
                'font'  => array(
                    'bold'	=>	TRUE,
                    'size'	=>	10,
                    'name'	=>	'Verdana'
                )
            );
            $_objSheet->getStyle('A1:'.$_lastAlpha.$_row)->applyFromArray($_style)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="'.$_filename.'"');
            header('Cache-Control: max-age=0');
            $_objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            @ob_end_clean();
            $_objWriter->save('php://output');
            @$_objSheet->disconnectWorksheets();
            unset($_objSheet);
        } else {

            show_404();
        }
    }

    function export() {

        $_db_columns	=	[];
        $_alphas			=	[];
        $_datas				=	[];

        $_titles[]	=	'#';

        $_start	=	3;
        $_row		=	2;
        $_no		=	1;

        ${{ cookiecutter.module_plural }}	=	$this->_model->as_array()->get_all();
        if ( ${{ cookiecutter.module_plural }} ) {

            foreach ( ${{ cookiecutter.module_plural }} as $_lkey => ${{ cookiecutter.module_slug }} ) {

                $_datas[${{ cookiecutter.module_slug }}['id']]['#']	=	$_no;

                $_no++;
            }

            $_filename	=	'list_of_{{ cookiecutter.module_plural }}_'.date('m_d_y_h-i-s',time()).'.xls';

            $_objSheet	=	$this->excel->getActiveSheet();

            if ( $this->input->post() ) {

                $_export_column	=	$this->input->post('_export_column');
                if ( $_export_column ) {

                    foreach ( $_export_column as $_ekey => $_column ) {

                        $_db_columns[$_ekey]	=	isset($_column) && $_column ? $_column : '';
                    }
                } else {

                    $this->notify->error('Something went wrong. Please refresh the page and try again.', '{{ cookiecutter.module_slug }}');
                }
            } else {

                $_filename	=	'list_of_{{ cookiecutter.module_plural }}_'.date('m_d_y_h-i-s',time()).'.csv';

                // $_db_columns	=	$this->M_land_inventory->fillable;
                $_db_columns	=	$this->_table_fillables;
                if ( !$_db_columns ) {

                    $this->notify->error('Something went wrong. Please refresh the page and try again.', '{{ cookiecutter.module_slug }}');
                }
            }

            if ( $_db_columns ) {

                foreach ( $_db_columns as $key => $_dbclm ) {

                    $_name	=	isset($_dbclm) && $_dbclm ? $_dbclm : '';

                    if ( (strpos( $_name, 'created_') === FALSE) && (strpos( $_name, 'updated_') === FALSE) && (strpos( $_name, 'deleted_') === FALSE) && ($_name !== 'id') ) {

                        if ( (strpos( $_name, '_id') !== FALSE) ) {

                            $_column	=	$_name;

                            $_name	=	isset($_name) && $_name ? str_replace('_id', '', $_name) : '';

                            $_titles[]	=	$_title =	isset($_name) && $_name ? str_replace('_', ' ', $_name) : '';

                        } elseif ( (strpos( $_name, 'is_') !== FALSE) ) {

                            $_column	=	$_name;

                            $_name	=	isset($_name) && $_name ? str_replace('is_', '', $_name) : '';

                            $_titles[]	=	$_title =	isset($_name) && $_name ? str_replace('_', ' ', $_name) : '';

                            foreach ( ${{ cookiecutter.module_plural }} as $_lkey => ${{ cookiecutter.module_slug }} ) {

                                $_datas[${{ cookiecutter.module_slug }}['id']][$_title]	=	isset(${{ cookiecutter.module_slug }}[$_column]) && (${{ cookiecutter.module_slug }}[$_column] !== '') ? Dropdown::get_static('bool', ${{ cookiecutter.module_slug }}[$_column], 'view') : '';
                            }
                        } else {

                            $_titles[]	=	$_title =	isset($_name) && $_name ? str_replace('_', ' ', $_name) : '';

                            foreach ( ${{ cookiecutter.module_plural }} as $_lkey => ${{ cookiecutter.module_slug }} ) {

                                if ( $_name === 'status' ) {

                                    $_datas[${{ cookiecutter.module_slug }}['id']][$_title]	=	isset(${{ cookiecutter.module_slug }}[$_name]) && ${{ cookiecutter.module_slug }}[$_name] ? Dropdown::get_static('inventory_status', ${{ cookiecutter.module_slug }}[$_name], 'view') : '';
                                } else {

                                    $_datas[${{ cookiecutter.module_slug }}['id']][$_title]	=	isset(${{ cookiecutter.module_slug }}[$_name]) && ${{ cookiecutter.module_slug }}[$_name] ? ${{ cookiecutter.module_slug }}[$_name] : '';
                                }
                            }
                        }
                    } else {

                        continue;
                    }
                }

                $_alphas	=	$this->__get_excel_columns(count($_titles));

                $_xls_columns	=	array_combine($_alphas, $_titles);
                $_firstAlpha	=	reset($_alphas);
                $_lastAlpha		=	end($_alphas);

                foreach ( $_xls_columns as $_xkey => $_column ) {

                    $_title	=	($_column !== 'ID') ? ucwords(strtolower($_column)) : $_column;

                    $_objSheet->setCellValue($_xkey.$_row, $_title);
                }

                $_objSheet->setTitle('List of {{ cookiecutter.module_name }}');
                $_objSheet->setCellValue('A1', 'LIST OF {{ cookiecutter.module_name.upper() }}');
                $_objSheet->mergeCells('A1:'.$_lastAlpha.'1');

                if ( isset($_datas) && $_datas ) {

                    foreach ( $_datas as $_dkey => $_data ) {

                        foreach ( $_alphas as $_akey => $_alpha ) {

                            $_value	=	isset($_data[$_xls_columns[$_alpha]]) ? $_data[$_xls_columns[$_alpha]] : '';

                            $_objSheet->setCellValue($_alpha.$_start, $_value);
                        }

                        $_start++;
                    }
                } else {

                    $_objSheet->setCellValue($_firstAlpha.$_start, 'No Record Found');
                    $_objSheet->mergeCells($_firstAlpha.$_start.':'.$_lastAlpha.$_start);

                    $_style	=	array(
                        'font'  => array(
                            'bold'	=>	FALSE,
                            'size'	=>	9,
                            'name'	=>	'Verdana'
                        )
                    );
                    $_objSheet->getStyle($_firstAlpha.$_start.':'.$_lastAlpha.$_start)->applyFromArray($_style)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                }

                foreach ( $_alphas as $_alpha ) {

                    $_objSheet->getColumnDimension($_alpha)->setAutoSize(TRUE);
                }

                $_style	=	array(
                    'font'  => array(
                        'bold'	=>	TRUE,
                        'size'	=>	10,
                        'name'	=>	'Verdana'
                    )
                );
                $_objSheet->getStyle('A1:'.$_lastAlpha.$_row)->applyFromArray($_style)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="'.$_filename.'"');
                header('Cache-Control: max-age=0');
                $_objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                @ob_end_clean();
                $_objWriter->save('php://output');
                @$_objSheet->disconnectWorksheets();
                unset($_objSheet);
            } else {

                $this->notify->error('Something went wrong. Please refresh the page and try again.', '{{ cookiecutter.module_slug }}');
            }
        } else {

            $this->notify->error('No Record Found', '{{ cookiecutter.module_slug }}');
        }
    }

}
