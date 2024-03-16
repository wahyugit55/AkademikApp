<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * siswa_kota_id_option_list Model Action
     * @return array
     */
	function siswa_kota_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,nama AS label FROM kota ORDER BY nama";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * user_nama_value_exist Model Action
     * @return array
     */
	function user_nama_value_exist($val){
		$db = $this->GetModel();
		$db->where("nama", $val);
		$exist = $db->has("user");
		return $exist;
	}

	/**
     * user_email_value_exist Model Action
     * @return array
     */
	function user_email_value_exist($val){
		$db = $this->GetModel();
		$db->where("email", $val);
		$exist = $db->has("user");
		return $exist;
	}

	/**
     * getcount_totalsiswa Model Action
     * @return Value
     */
	function getcount_totalsiswa(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM siswa";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
     * getcount_lakilaki Model Action
     * @return Value
     */
	function getcount_lakilaki(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS jumlah_laki FROM siswa WHERE jenkel = 1;";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
     * getcount_perempuan Model Action
     * @return Value
     */
	function getcount_perempuan(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS jumlah_laki FROM siswa WHERE jenkel = 2;";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
	* doughnutchart_jeniskelamin Model Action
	* @return array
	*/
	function doughnutchart_jeniskelamin(){
		
		$db = $this->GetModel();
		$chart_data = array(
			"labels"=> array(),
			"datasets"=> array(),
		);
		
		//set query result for dataset 1
		$sqltext = "SELECT CASE 
    WHEN jenkel = '1' THEN 'Laki - Laki'
    WHEN jenkel = '2' THEN 'Perempuan'
    ELSE jenkel
END AS jenis_kelamin,
COUNT(*) AS total_siswa
FROM siswa
GROUP BY jenkel;
";
		$queryparams = null;
		$dataset1 = $db->rawQuery($sqltext, $queryparams);
		$dataset_data =  array_column($dataset1, 'total_siswa');
		$dataset_labels =  array_column($dataset1, 'jenis_kelamin');
		$chart_data["labels"] = array_unique(array_merge($chart_data["labels"], $dataset_labels));
		$chart_data["datasets"][] = $dataset_data;

		return $chart_data;
	}

	/**
	* piechart_kotaasal Model Action
	* @return array
	*/
	function piechart_kotaasal(){
		
		$db = $this->GetModel();
		$chart_data = array(
			"labels"=> array(),
			"datasets"=> array(),
		);
		
		//set query result for dataset 1
		$sqltext = "SELECT kota.id, kota.nama, COUNT(siswa.id) AS total_siswa
FROM kota
LEFT JOIN siswa ON kota.id = siswa.kota_id
GROUP BY kota.id, kota.nama DESC LIMIT 6;";
		$queryparams = null;
		$dataset1 = $db->rawQuery($sqltext, $queryparams);
		$dataset_data =  array_column($dataset1, 'id');
		$dataset_labels =  array_column($dataset1, 'nama');
		$chart_data["labels"] = array_unique(array_merge($chart_data["labels"], $dataset_labels));
		$chart_data["datasets"][] = $dataset_data;

		return $chart_data;
	}

	/**
	* barchart_tahunlahir Model Action
	* @return array
	*/
	function barchart_tahunlahir(){
		
		$db = $this->GetModel();
		$chart_data = array(
			"labels"=> array(),
			"datasets"=> array(),
		);
		
		//set query result for dataset 1
		$sqltext = "SELECT YEAR(tgl_lahir), COUNT(*) FROM siswa GROUP BY YEAR(tgl_lahir) ORDER BY COUNT(*) DESC LIMIT 6;";
		$queryparams = null;
		$dataset1 = $db->rawQuery($sqltext, $queryparams);
		$dataset_data =  array_column($dataset1, 'COUNT(*)');
		$dataset_labels =  array_column($dataset1, 'YEAR(tgl_lahir)');
		$chart_data["labels"] = array_unique(array_merge($chart_data["labels"], $dataset_labels));
		$chart_data["datasets"][] = $dataset_data;

		return $chart_data;
	}

}
