<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Buyer_model extends MY_Model {

	public $table = 'buyers'; // you MUST mention the table name
	public $primary_key = 'id'; // you MUST mention the primary key
	public $fillable = [
		'name',
		/* ==================== begin: Add model fields ==================== */

        /* ==================== end: Add model fields ==================== */
		'created_by',
		'created_at',
		'updated_by',
		'updated_at'
	]; // If you want, you can set an array with the fields that can be filled by insert/update

	public $protected = ['id']; // ...Or you can set an array with the fields that cannot be filled by insert/update
	public $rules = [];

	public $fields = [];

	public function __construct()
	{
		parent::__construct();

        $this->soft_deletes = TRUE;
		$this->return_as = 'array';

		// Pagination
		$this->pagination_delimiters = array('<li class="kt-pagination__link--next">','</li>');
		$this->pagination_arrows = array('<i class="fa fa-angle-left kt-font-brand"></i>','<i class="fa fa-angle-right kt-font-brand"></i>');

		$this->rules['insert']	=	$this->fields;
		$this->rules['update']	=	$this->fields;

		// for relationship tables
        // $this->has_many['table_name'] = array();

	}

}
