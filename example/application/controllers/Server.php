<?php
use Ratchet\ConnectionInterface;
use CIRatchet\CI_CLIController;
use CIRatchet\WebSocketServer;

class Server extends CI_CLIController {
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		echo "Start\n";
		$server = new TestWebSocketServer();
		$server->run(8087);
	}
}

class TestWebSocketServer extends WebSocketServer {
	public function __construct() {
		parent::__construct();
	}
	
	public function onOpen(ConnectionInterface $conn) {
		parent::onOpen($conn);
		
		echo "Connected.\n";
	}
	
	public function onMessage(ConnectionInterface $conn, $msg) {
		parent::onMessage($conn, $msg);
		
		$ctrl = $this->loadController("Test");
		$ctrl->test($conn);
	}
	
	public function onClose(ConnectionInterface $conn) {
		parent::onClose($conn);
		
		echo "Disconnected.\n";
	}
	
	public function onError(ConnectionInterface $conn, \Exception $e) {
		parent::onError($conn, $e);
	}
}