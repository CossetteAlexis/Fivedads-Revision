<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dropdowns extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, OPTIONS");
		$this->load->model('dropdown');
	}

	public function index()
	{
		$data['countries'] = $this->dropdown->getCountryRows();
		$this->load->view('dropdowns/index', $data);
	}

	public function getProvinces()
	{
		$provinces = array();
		$country_id = $this->input->post('country_id');
		if ($country_id) {
			$con['conditions'] = array('country_id' => $country_id);
			$provinces = $this->dropdown->getProvinceRows($con);
		}
		echo json_encode($provinces);
	}

	public function getCities()
	{
		$cities = array();
		$province_id = $this->input->post('province_id');
		if ($province_id) {
			$con['conditions'] = array('province_id' => $province_id);
			$cities = $this->dropdown->getCityRows($con);
		}
		echo json_encode($cities);
	}

	public function getBarangays()
	{
		$barangays = array();
		$city_id = $this->input->post('city_id');
		if ($city_id) {
			$con['conditions'] = array('city_id' => $city_id);
			$barangays = $this->dropdown->getBarangayRows($con);
		}
		echo json_encode($barangays);
	}
}
