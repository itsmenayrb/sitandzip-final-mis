<?php

	session_start();
	require_once 'Config.php';


	class Session extends Config {

		protected $session;

		public function __construct() {

			$this->session = new Config();

			if(!$this->session->is_loggedin())
			{
				$session->redirect('../index.php');
			}
		}

	}
?>