<?php
defined('BASEPATH') or exit('No direct script access allowed');
defined('APPPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/TraitBaseController.php';


class {{cookiecutter.controller}} extends MY_Controller
{
    use TraitBaseController;
    /* Override as necessary
     * use TraitBaseController {
        create as baseCreate; ...
       }
     */

     /* Pluggable properties:
      * - $this->extra_fillables - gets appended to $fillables every time __fetch_fillables() is called
      * - $this->pre_create_view_data - gets appended to $this->view_data[] every time __pre_create_hooks() is called
      * - $this->pre_update_view_data - gets appended to $this->view_data[] every time __pre_update_hooks() is called
      * - $this->extra_create_data - gets appended to $additional on create
      * - $this->extra_update_data - gets appended to $additional on update
      */

    private $_form_errors = array(
        'create' => null,
        'update' => null,
    );

    public function __construct()
    {
        parent::__construct();

        // models
        $this->load->model('{{cookiecutter.module_class}}_model', '_model');

        // libraries
        $this->_lib = new {{ cookiecutter.module_class }}_Library();

        // Load pagination library
        $this->load->library('ajax_pagination');

        // Format Helper
        $this->load->helper(['form', 'format', 'images']); // Load Helper

        // Per page limit
        $this->perPage = 12;

        $this->_table_fillables = $this->_model->fillable;
        $this->_table_columns = $this->_model->__get_columns();

        $this->module_url = site_url("{{cookiecutter.module_slug}}");

        // override or delete as necessary
        $this->globally_allowed_permissions = ['is_read', 'is_create'];

    }

    # region public methods

    # endregion public methods

    # region private methods

    # endregion private methods

}