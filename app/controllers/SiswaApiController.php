<?php 
/**
 * Siswa Page Controller
 * @category  Controller
 */
class SiswaApiController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "siswa";
	}
	/**0
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	
	function apilist(){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("siswa.id", 
			"siswa.nis", 
			"siswa.nama", 
			"siswa.tgl_lahir", 
			"siswa.alamat", 
			"siswa.jenkel", 
			"siswa.kota_id", 
			"siswa.nm_kota", 
			);
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				siswa.id LIKE ? OR 
				siswa.nis LIKE ? OR 
				siswa.nama LIKE ? OR 
				siswa.tgl_lahir LIKE ? OR 
				siswa.alamat LIKE ? OR 
				siswa.jenkel LIKE ? OR
				siswa.nm_kota LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
		}
		
		$records = $db->get($tablename, $pagination, $fields);
		
		if($db->getLastError()){
			$this->set_page_error();
		}
		echo render_json($records);
	}
	
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function apiadd($formdata = null){
		$responseError = array(
			"message" => "Tambah data siswa terlebih dahulu"
		);
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nis' => 'required',
				'nama' => 'required',
				'tgl_lahir' => 'required',
				'alamat' => 'required',
				'jenkel' => 'required',
				'kota_id' => 'required',
				'nm_kota' => 'required',
			);
			$this->sanitize_array = array(
				'nis' => 'sanitize_string',
				'nama' => 'sanitize_string',
				'tgl_lahir' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'jenkel' => 'sanitize_string',
				'kota_id' => 'sanitize_string',
				'nm_kota' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					return render_json(
						array(
							'message' => 'Record added succesfully',
							'rec_id' =>$rec_id,
							'table_name' =>$tablename,
							'model_data' =>$modeldata,
						)
					);
				}
				else{
					$this->set_page_error();
				}
			}
		}
		echo render_json($responseError);
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function apiedit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$responseError = array(
			"message" => "Edit data siswa terlebih dahulu"
		);
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","nis","nama","tgl_lahir","alamat","jenkel","kota_id", "nm_kota");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nis' => 'required',
				'nama' => 'required',
				'tgl_lahir' => 'required',
				'alamat' => 'required',
				'jenkel' => 'required',
				'kota_id' => 'required',
				'nm_kota' => 'required',
			);
			$this->sanitize_array = array(
				'nis' => 'sanitize_string',
				'nama' => 'sanitize_string',
				'tgl_lahir' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'jenkel' => 'sanitize_string',
				'kota_id' => 'sanitize_string',
				'nm_kota' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("siswa.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					return render_json(
						array(
							'message' => 'Record updated successfully',
							'rec_id' =>$rec_id,
							'num_rows' =>$numRows,
							'bool' =>$bool,
							'table_name' =>$tablename,
							'model_data' =>$modeldata,
						)
					);
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("siswa");
					}
				}
			}
		}
		echo render_json($responseError);
	}
	
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function apidelete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("siswa.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		$responseError = array(
			"message" => "Tidak ada siswa yang dihapus"
		);
		if($bool){
			return render_json(
				array(
					'message' => 'Record deleted successfully',
					'rec_id' =>$bool,
					'model_data' => $arr_rec_id,
				)
			);
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		echo render_json($responseError);
	}
}
