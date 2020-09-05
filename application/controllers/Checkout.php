<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkout extends CI_Controller
{

	function  __construct()
	{
		parent::__construct();

		// Load form library & helper
		$this->load->library('form_validation');
		$this->load->helper('form');

		// Load cart library
		$this->load->library('cart');

		// Load product model
		$this->load->model('product');

		$this->controller = 'checkout';

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, OPTIONS");
		$this->load->model('dropdown');
	}

	function index()
	{
		// Redirect if the cart is empty
		if ($this->cart->total_items() <= 0) {
			redirect('products/');
		}

		$custData = $data = array();

		// If order request is submitted
		$submit = $this->input->post('placeOrder');
		if (isset($submit)) {
			// Form field validation rules
			$this->form_validation->set_rules('firstname', 'Firstname', 'required');
			$this->form_validation->set_rules('lastname', 'Lastname', 'required');
			$this->form_validation->set_rules('phone', 'Phone', 'required');
			$this->form_validation->set_rules('street', 'Street', 'required');
			// $this->form_validation->set_rules('province', 'province', 'required');

			// Prepare customer data
			$custData = array(
				'firstname'	 => strip_tags($this->input->post('firstname')),
				'lastname'	 => strip_tags($this->input->post('lastname')),
				'street'	 => strip_tags($this->input->post('street')),
				'brgy'	 => strip_tags($this->input->post('barangay')),
				'city'	 => strip_tags($this->input->post('city')),
				'province'	 => strip_tags($this->input->post('province')),
				'country'	 => strip_tags($this->input->post('country')),
				'phone'	 => strip_tags($this->input->post('phone')),
				'phone2'	 => strip_tags($this->input->post('phone2'))
			);

			// Validate submitted form data
			if ($this->form_validation->run() == true) {
				// Insert customer data
				$insert = $this->product->insertCustomer($custData);

				// Check customer data insert status
				if ($insert) {
					// Insert order
					$order = $this->placeOrder($insert);

					// If the order submission is successful
					if ($order) {
						$this->session->set_userdata('success_msg', 'Order placed successfully.');
						redirect($this->controller . '/orderSuccess/' . $order);
					} else {
						$data['error_msg'] = 'Order submission failed, please try again.';
					}
				} else {
					$data['error_msg'] = 'Some problems occured, please try again.';
				}
			}
		}

		// Customer data
		$data['custData'] = $custData;

		// Retrieve cart data from the session
		$data['cartItems'] = $this->cart->contents();

		$data['countries'] = $this->dropdown->getCountryRows();
		// print_r($data['countries']);
		// $data['cod'] = $this->dropdown->getCodRows();
		// print_r($data['cod']);

		// Pass products data to the view
		$this->load->view($this->controller . '/index', $data);
	}

	function placeOrder($custID)
	{
		// Insert order data
		$ordData = array(
			'customer_id' => $custID,
			'grand_total' => $this->cart->total()
		);
		$insertOrder = $this->product->insertOrder($ordData);

		if ($insertOrder) {
			// Retrieve cart data from the session
			$cartItems = $this->cart->contents();

			// Cart items
			$ordItemData = array();
			$i = 0;
			foreach ($cartItems as $item) {
				$ordItemData[$i]['order_id'] 	= $insertOrder;
				$ordItemData[$i]['product_id'] 	= $item['id'];
				$ordItemData[$i]['quantity'] 	= $item['qty'];
				$ordItemData[$i]['sub_total'] 	= $item["subtotal"];
				$i++;
			}

			if (!empty($ordItemData)) {
				// Insert order items
				$insertOrderItems = $this->product->insertOrderItems($ordItemData);

				if ($insertOrderItems) {
					// Remove items from the cart
					$this->cart->destroy();

					// Return order ID
					return $insertOrder;
				}
			}
		}
		return false;
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

	function orderSuccess($ordID)
	{
		// Fetch order data from the database
		$data['order'] = $this->product->getOrder($ordID);

		// Load order details view
		$this->load->view($this->controller . '/order-success', $data);
	}

	function chk_cod()
	{
		// if(!$this->Login_model->is_login()) $this->exit_err('Invalid Access!');
		$citymunid = $this->input->post("city", TRUE);
		$brgyid = $this->input->post("barangay", TRUE);

		$citymun_code = $this->dropdown
			->get_value(
				'ph_citymun',
				'citymun_code',
				array('citymunid' => $citymunid),
				'citymun ASC'
			);

		$where = "status = 1
			AND citymun_code = " . $citymun_code . "
			AND NOT EXISTS(
				SELECT branchid FROM noncod_areas
				WHERE brgyid = " . $brgyid . "
			)
		";

		$cod_branch = $this->dropdown
			->get_value(
				'cod_areas',
				'branchid',
				$where,
				'branchid ASC'
			);

		if ($cod_branch) {
			$cod = 'COD';
		} else {
			$where = array(
				'brgyid' => $brgyid,
				'deliver' => 'COD'
			);

			// $cod_area = $this->My_model->get_row('cod_areas_lbc',$where);

			// if($cod_area) {
			// 	$cod = "COD via LBC";
			// } else {
			// 	$cod = 'Not COD.';
			// }
		}
		//$cod = $this->db->last_query();
		echo json_encode(array(
			'cod'		=> $cod,
			'query' => $this->db->last_query()
		));
	}
}
