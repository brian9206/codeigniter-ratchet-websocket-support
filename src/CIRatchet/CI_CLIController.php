<?php
namespace CIRatchet;

class CI_CLIController extends \CI_Controller {
	public function __construct() {
		parent::__construct();
		
		if (!$this->input->is_cli_request()) {
			show_404();
			return;
		}
	}
}