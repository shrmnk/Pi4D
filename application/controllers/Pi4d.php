<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pi4d extends CI_Controller {

	public function index() {
		$this->version = '2.0';
		
		date_default_timezone_set("Asia/Singapore");
		$this->load->helper('url');
		
		$this->load->view('pi4d/header');
		// Uncomment to show raw results
		//echo('<pre>'.print_r($this->get4DResults(), true).'</pre>');
		$this->load->view('pi4d/results', $this->get4DResults());
		// The footer contains the javascript to refresh page
		$this->load->view('pi4d/footer');
	}
	
	private function get4DResults() {
		try {
			$client = new GuzzleHttp\Client(['base_uri' => 'http://www.live.4d.endpoint/json/']);
			$response = $client->request('GET', 'api_endpoint.asp');
		} catch (GuzzleHttp\Exception\TransferException $e) {
			$this->success = false;
			return array('success' => false, 'reason' => 'Error: '.$e->getMessage());
		}
		
		if($response->getStatusCode() == 200) {
			$this->success = true;
			return $this->processJLive(json_decode($response->getBody()));
		} else {
			$this->success = false;
			return array('success' => false, 'reason' => 'HTTP Response Error '.$response->getStatusCode());
		}
	}
	
	private function processJLive($data = array()) {
		if(!isset($data->result)) return array('success' => false, 'reason' => 'Missing result section');
		
		$arr = array(
			'success' => true,
			'resultdate' => $data->result->date,
			'resulttimestamp' => strtotime($data->result->date),
			'data' => array(
				'top3' => array(),
				'starters' => array(),
				'consolation' => array()
			)
		);
		
		$this->resulttimestamp = strtotime($data->result->date);
		
		foreach($data->result->n as $obj) {
			// Prizes 1 to 3 are top3 prizes
			if($obj->p >= 1 && $obj->p <= 3)
				$arr['data']['top3'][] = $obj->i;
			else if($obj->p >= 4 && $obj->p <= 13)
				$arr['data']['starters'][] = $obj->i;
			else if($obj->p >= 14 && $obj->p <= 23)
				$arr['data']['consolation'][] = $obj->i;
			else {
				$this->success = false;
				return array('success' => false, 'reason' => 'Unknown Prize Number: '.print_r($obj, true));
			}
		}
		
		return $arr;
	}
}
