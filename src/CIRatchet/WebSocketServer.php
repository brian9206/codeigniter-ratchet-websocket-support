<?php
namespace CIRatchet;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketServer implements MessageComponentInterface {

	public function __construct() {
	}
	
	public function run($port) {
		$server = IoServer::factory(new HttpServer(new WsServer($this)), $port);
		$server->run();
	}

	public function onOpen(ConnectionInterface $conn) { }

    public function onMessage(ConnectionInterface $conn, $msg) {
		$cookies = $conn->WebSocket->request->getCookies();
		$sessionID = @$cookies[session_name()];
		
		if ($sessionID) {
			session_id($sessionID);
		}
		else {
			session_id('');
		}
	}

    public function onClose(ConnectionInterface $conn) { }

    public function onError(ConnectionInterface $conn, \Exception $e) { }
	
	// factory method
	public function loadController($name) {
		$controllerName = ucfirst($name) . 'Controller';
		require_once(APPPATH . 'wscontrollers/' . $controllerName . '.php');
		
		if (!class_exists($controllerName)) {
			return FALSE;
		}
		
		$ctrl = new $controllerName();
		return $ctrl;
	}
}