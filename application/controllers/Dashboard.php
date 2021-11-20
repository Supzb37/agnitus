<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('Dashboard_model','wm');


	}
	
	public function index()
	{
		$this->load->view('dashboard');
	}

	public function savedata() {
		$response = ['status'=> false, 'msg' => ''];
		$data = $this->input->post('res');

		foreach ($data as $k => $v) {
			$req = [
				'name' => $v['name'], 
				'iso2_code' => $v['iso2Code'],
				'region' => $v['region']['value'], 
				'income_level' => $v['incomeLevel']['value'], 
				'capital_city' => $v['capitalCity'], 
				'latitude' => $v['latitude'], 
				'longitude' => $v['longitude']
			];

			$res = $this->wm->saveFromApi($req);
		}

		if($res) {
			$response = ['status'=> true, 'msg' => 'Successfully Inserted!'];
		} else {
			$response = ['status'=> false, 'msg' => 'Some Error Happened! Try Again Later.'];
		}

		echo json_encode($res);
	}

	public function getdata()
	{

		$data['country_list'] = $this->wm->getdata();
		echo json_encode(array('country_list' => $data['country_list'],'status' => 1));

	}

	public function getCountrydata()
	{
		$id = $this->uri->segment(3);
		$data['getData'] = $this->wm->getDetailData($id);
		//print_r($data['getData']);die;
		echo json_encode(['country_data' => $data['getData']]);
	}

	public function updatedata() {
		$response = ['status'=> false, 'msg' => ''];
		$data = $this->input->post();

		$income_level = $data['income_level'];
		$latitude = $data['latitude'];
		$longitude = $data['longitude'];
		$capital_city = $data['capital_city'];
		$id = $data['id'];
		
		$query = $this->wm->updateData($id, $income_level, $latitude, $longitude, $capital_city);

		

		if($query) {
			$response = ['status'=> true, 'msg' => 'Successfully Inserted!'];
		} else {
			$response = ['status'=> false, 'msg' => 'Some Error Happened! Try Again Later.'];
		}

		echo json_encode($response);
	}
}
