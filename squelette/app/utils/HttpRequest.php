<?php

namespace app\utils;

class HttpRequest extends AbstractHttpRequest{

	public function __construct(){
		if(isset($_SERVER['GET'])){
			$this->get = $_SERVER['GET'];
		}

		if(isset($_SERVER['REQUEST_METHOD'])){
			$this->method = $_SERVER['REQUEST_METHOD'];
		}
		if(isset($_SERVER['PATH_INFO'])){
			$this->path_info = $_SERVER['PATH_INFO'];
		}

		if(isset($_SERVER['POST'])){
			$this->post = $_SERVER['POST'];
		}

		if(isset($_SERVER['QUERY_STRING'])){
			$this->query = $_SERVER['QUERY_STRING'];
		}

		if(isset($_SERVER['SCRIPT_NAME'])){
			$this->script_name = $_SERVER['SCRIPT_NAME'];
		}
	}

	public function getRoot(){
		return dirname($this->script_name);
	}

	public function getController(){
		$delimiter = "/";
		$pos1 = strpos($this->path_info, $delimiter);
		$pos2 = strpos($this->path_info, $delimiter, $pos1+1);
		return substr($this->path_info, $pos1+1, ($pos2)-1);
	}

	public function getAction(){
		$delimiter = "/";
		$pos1 = strpos($this->path_info, $delimiter);
		$pos2 = strpos($this->path_info, $delimiter, $pos1+1);
		return substr($this->path_info, $pos2+1, strlen($this->path_info)-$pos2);
	}
}
