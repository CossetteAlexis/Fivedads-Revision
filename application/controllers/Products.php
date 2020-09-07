<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{

	function  __construct()
	{
		parent::__construct();

		// Load cart library
		$this->load->library('cart');

		// Load product model
		$this->load->model('product');
	}

	function index()
	{
		$data = array();

		// Fetch products from the database
		$data['products'] = $this->product->getRows();

		// Load the product list view
		$this->load->view('products/index', $data);
	}

	function add()
	{
		$id = $this->input->post('id');
		$product = $this->product->getRows($id);

		$data = array(
			'id'	=> $product['itemid'],
			'qty'	=> 1,
			'price'	=> $product['price'],
			'name'	=> $product['name'],
			'boxes'	=> $product['boxes']
		);
		echo json_encode($data);
	}

	function addToCart()
	{
		$id = $this->input->post('id');
		// Fetch specific product by ID
		$product = $this->product->getRows($id);

		// Add product to the cart
		$data = array(
			'id'	=> $product['itemid'],
			'qty'	=> 1,
			'price'	=> $product['price'],
			'name'	=> $product['name']
			// 'image' => $product['image']
		);
		$this->cart->insert($data);

		// Redirect to the cart page
		redirect('cart/');
	}

	function get_price()
	{
		$id = $this->input->post('id');
		$product = $this->product->getRows($id);
		$price = $product['price'];
		// echo json_encode($price);
		// echo json_encode(implode($price));
		echo $price;
	}
}
