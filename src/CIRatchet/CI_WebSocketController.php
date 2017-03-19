<?php
namespace CIRatchet;

class CI_WebSocketController {
	public function __get($key) {
		return get_instance()->$key;
	}
}