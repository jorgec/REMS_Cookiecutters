<?php
defined('BASEPATH') or exit('No direct script access allowed');

class {{ cookiecutter.controller }} extends MY_Controller
{
    private $fields = [
        array(
            'field' => 'info[name]',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        /* ==================== begin: Add model fields ==================== */

        /* ==================== end: Add model fields ==================== */

    ];

    public function __construct()
    {
        parent::__construct();

        // Load models
        $this->load->model('{{ cookiecutter.model_name }}', '{{ cookiecutter.model_variable }}');
        $this->load->model('auth/Ion_auth_model', 'M_auth');
        $this->load->model('user/User_model', 'M_user');


        // Load pagination library
        $this->load->library('ajax_pagination');

        // Format Helper
        $this->load->helper(['format', 'images']);// Load Helper

        // Per page limit
        $this->perPage = 12;

        $this->_table_fillables = $this->{{ cookiecutter.model_variable }}->fillable;
        $this->_table_columns = $this->{{ cookiecutter.model_variable }}->__get_columns();
        $this->_table = '{{ cookiecutter.module_plural }}';

    }

    public function get_all()
    {
        $data['row'] = $this->{{ cookiecutter.model_variable }}->get_all();

        echo json_encode($data);
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
        $this->view_data['records'] = $this->{{ cookiecutter.module_slug }}
            ->limit($this->perPage, 0)
            ->get_all();
        $this->css_loader->queue(['vendors/custom/datatables/datatables.bundle.css']);
        $this->js_loader->queue(['vendors/custom/datatables/datatables.bundle.js']);

        $this->template->build('index', $this->view_data);
    }

    public function paginationData()
    {
        if ($this->input->is_ajax_request()) {

            // Input from General Search
            $keyword = $this->input->post('keyword');

            // Input from Advanced Filter
            $name = $this->input->post('name');
             /* ==================== begin: Add model fields ==================== */

             /* ==================== end: Add model fields ==================== */

            $page = $this->input->post('page');

            if (!$page) {
                $offset = 0;
            } else {
                $offset = $page;
            }

            $totalRec = $this->{{ cookiecutter.module_slug }}->count_rows();
            $where = array();

            // Pagination configuration
            $config['target'] = '#{{ cookiecutter.module_slug }}_content';
            $config['base_url'] = base_url('{{ cookiecutter.module_slug }}/paginationData');
            $config['total_rows'] = $totalRec;
            $config['per_page'] = $this->perPage;
            $config['link_func'] = '{{ cookiecutter.module_function }}Pagination';

            // Query
            if (!empty($keyword)):
                $this->db->group_start();
                $this->db->like('last_name', $keyword, 'both');
                $this->db->or_like('first_name', $keyword, 'both');
                $this->db->or_like('middle_name', $keyword, 'both');
                $this->db->group_end();
            endif;

            if (!empty($name)):
                $this->db->group_start();
                $this->db->like('last_name', $name, 'both');
                $this->db->or_like('first_name', $name, 'both');
                $this->db->or_like('middle_name', $name, 'both');
                $this->db->group_end();
            endif;

            $totalRec = $this->{{ cookiecutter.module_slug }}->count_rows();

            // Pagination configuration
            $config['total_rows'] = $totalRec;

            // Initialize pagination library
            $this->ajax_pagination->initialize($config);

            // Query
            if (!empty($keyword)):
                $this->db->group_start();
                $this->db->like('last_name', $keyword, 'both');
                $this->db->or_like('first_name', $keyword, 'both');
                $this->db->or_like('middle_name', $keyword, 'both');
                $this->db->group_end();
            endif;


            if (!empty($civil_status_id) && !empty($civil_status_id)):
                $this->db->where('civil_status_id', $civil_status_id);
                $where['civil_status_id'] = $civil_status_id;
            endif;

            $this->view_data['records'] = $records = $this->{{ cookiecutter.module_slug }}
                ->limit($this->perPage, $offset)
                ->get_all();


            $this->load->view('{{ cookiecutter.module_slug }}/_filter', $this->view_data, false);
        }
    }

    public function view($id = FALSE)
    {
        $this->css_loader->queue('//www.amcharts.com/lib/3/plugins/export/export.css');

        $this->js_loader->queue([
            '//www.amcharts.com/lib/3/amcharts.js',
            '//www.amcharts.com/lib/3/serial.js',
            '//www.amcharts.com/lib/3/radar.js',
            '//www.amcharts.com/lib/3/pie.js',
            '//www.amcharts.com/lib/3/plugins/tools/polarScatter/polarScatter.min.jss',
            '//www.amcharts.com/lib/3/plugins/animate/animate.min.js',
            '//www.amcharts.com/lib/3/plugins/export/export.min.js',
            '//www.amcharts.com/lib/3/themes/light.js'
        ]);

        if ($id) {

            $this->view_data['info'] = $this->{{ cookiecutter.module_slug }}
                ->get($id);

            if ($this->view_data['info']) {
                $this->template->build('view', $this->view_data);
            } else {
                show_404();
            }

        } else {

            show_404();
        }
    }

    public function create()
    {
        if ($this->input->post()) {
            $_input = $this->input->post();
            $_input['created_by'] = $this->session->userdata['user_id'];

            $result = $this->{{ cookiecutter.module_slug }}->from_form()->insert($_input);

            if ($result === false) {

                // Validation
                $this->notify->error('Oops something went wrong.');
            } else {

                // Success
                $this->notify->success('{{ cookiecutter.module_name }} successfully created.', '{{ cookiecutter.module_slug }}');
            }
        }

        $this->template->build('create');
    }

    public function update($id = false)
    {
        if ($id) {

            $this->view_data['{{ cookiecutter.module_slug }}'] = $data = $this->{{ cookiecutter.module_slug }}->get($id);

            if ($data) {

                if ($this->input->post()) {

                    $_input = $this->input->post();
                    $_input['updated_by'] = $this->session->userdata['user_id'];

                    $result = $this->{{ cookiecutter.module_slug }}->from_form()->update($_input, $data['id']);

                    if ($result === false) {

                        // Validation
                        $this->notify->error('Oops something went wrong.');
                    } else {

                        // Success
                        $this->notify->success('Successfully Updated.', '{{ cookiecutter.module_slug }}');

                    }
                }

                $this->template->build('update', $this->view_data);
            } else {

                show_404();
            }
        } else {

            show_404();
        }
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
                    $response['message'] = '{{ cookiecutter.module_name }} successfully deleted';
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
                    $response['message'] = '{{ cookiecutter.module_name }} successfully deleted';
                }
            }
        }

        echo json_encode($response);
        exit();
    }

    function export()
    {

        $_db_columns	=	[];
        $_alphas			=	[];
        $_datas				=	[];

        $_titles[]	=	'#';

        $_start	=	3;
        $_row		=	2;
        $_no		=	1;

        ${{ cookiecutter.module_plural }}	=	$this->{{ cookiecutter.model_variable }}->as_array()->get_all();
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

    function export_csv()
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

                $_group	=	$this->{{ cookiecutter.model_variable }}->as_array()->get_all();
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
                        'name' => $upload_data[1],
                        /* ==================== begin: Add model fields ==================== */

                        /* ==================== end: Add model fields ==================== */
                    );

                    ${{ cookiecutter.module_slug }}_id = $upload_data[0];
                    ${{ cookiecutter.module_slug }} = $this->{{ cookiecutter.model_variable }}->get(${{ cookiecutter.module_slug }}_id);

                    if(${{ cookiecutter.module_slug }}){
                        $result = $this->{{ cookiecutter.model_variable }}->update($fields, ${{ cookiecutter.module_slug }}_id);
                    }

                } else {

                    if( ! is_numeric($upload_data[0]))
                    {
                        $fields = array(
                            'name' => $upload_data[0],
                            /* ==================== begin: Add model fields ==================== */

                            /* ==================== end: Add model fields ==================== */
                        );

                        $result = $this->{{ cookiecutter.model_variable}}->insert($fields);
                    } else {
                        $fields = array(
                            'name' => $upload_data[1],
                            /* ==================== begin: Add model fields ==================== */

                            /* ==================== end: Add model fields ==================== */
                        );

                        $result = $this->{{ cookiecutter.model_variable }}->insert($fields);
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
}
