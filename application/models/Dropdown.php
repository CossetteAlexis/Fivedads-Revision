<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dropdown extends CI_Model
{
	function __construct()
	{
		$this->countryTbl = 'countries';
		$this->provinceTbl = 'province';
		$this->cityTbl = 'cities';
		$this->barangayTbl = 'barangay';
		$this->codTbl = 'cod_areas';
	}

	/*
     * Get country rows from the countries table
     */
	function getCountryRows($params = array())
	{
		$this->db->select('c.id, c.name');
		$this->db->from($this->countryTbl . ' as c');

		//fetch data by conditions
		if (array_key_exists("conditions", $params)) {
			foreach ($params['conditions'] as $key => $value) {
				if (strpos($key, '.') !== false) {
					$this->db->where($key, $value);
				} else {
					$this->db->where('c.' . $key, $value);
				}
			}
		}
		$this->db->where('c.status', '1');

		$query = $this->db->get();
		$result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;

		//return fetched data
		return $result;
	}

	/*
     * Get province rows from the countries table
     */
	function getProvinceRows($params = array())
	{
		$this->db->select('s.id, s.name');
		$this->db->from($this->provinceTbl . ' as s');

		//fetch data by conditions
		if (array_key_exists("conditions", $params)) {
			foreach ($params['conditions'] as $key => $value) {
				if (strpos($key, '.') !== false) {
					$this->db->where($key, $value);
				} else {
					$this->db->where('s.' . $key, $value);
				}
			}
		}

		$query = $this->db->get();
		$result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;

		//return fetched data
		return $result;
	}

	/*
     * Get city rows from the countries table
     */
	function getCityRows($params = array())
	{
		$this->db->select('c.id, c.name');
		$this->db->from($this->cityTbl . ' as c');

		//fetch data by conditions
		if (array_key_exists("conditions", $params)) {
			foreach ($params['conditions'] as $key => $value) {
				if (strpos($key, '.') !== false) {
					$this->db->where($key, $value);
				} else {
					$this->db->where('c.' . $key, $value);
				}
			}
		}

		$query = $this->db->get();
		$result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;

		//return fetched data
		return $result;
	}

	function getBarangayRows($params = array())
	{
		$this->db->select('b.id, b.name');
		$this->db->from($this->barangayTbl . ' as b');

		//fetch data by conditions
		if (array_key_exists("conditions", $params)) {
			foreach ($params['conditions'] as $key => $value) {
				if (strpos($key, '.') !== false) {
					$this->db->where($key, $value);
				} else {
					$this->db->where('b.' . $key, $value);
				}
			}
		}

		$query = $this->db->get();
		$result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;

		//return fetched data
		return $result;
	}

	function getCodRows()
	{
		$this->db->select('area');
		$this->db->from($this->codTbl);
		$this->db->where('status !=', '0');
		$query = $this->db->get();
		return $query->result_array();
	}
}
