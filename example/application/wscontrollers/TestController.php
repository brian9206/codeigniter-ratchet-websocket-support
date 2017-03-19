<?php
use CIRatchet\CI_WebSocketController;

class TestController extends CI_WebSocketController {
	public function test($conn) {
		$conn->send("Test OK");
	}
}