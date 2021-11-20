<?php
class Dashboard_model extends CI_Model {

	protected $countryTable = "country";

	public function __construct() {
		parent::__construct();


	}

	public function saveFromApi($data) {
		$r = $this->db->insert($this->countryTable, $data);
		if($r){
			return true;
		} else {
			return false;
		}
	}

	public function getdata(){
		$query = $this->db->query("select id, name, iso2_code, region, income_level, capital_city, latitude, longitude from country");
		return $query->result_array();
	}

	public function getDetailData($id){
		$query = $this->db->query("select id, name, iso2_code, region, income_level, capital_city, latitude, longitude from country where id=".$id);
		return $query->row();
	}

	public function updateData($id, $income_level, $latitude, $longitude, $capital_city){
		$r = $this->db->update($this->countryTable, ['income_level' => $income_level, 'latitude' => $latitude, 'longitude' => $longitude, 'capital_city' => $capital_city], ['id' => $id]);
		if($r){
			return true;
		} else {
			return false;
		}
	}

}


?>