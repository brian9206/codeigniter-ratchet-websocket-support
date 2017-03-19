# brian9206/codeigniter-ratchet-websocket-support
Enable CodeIgniter runs on Ratchet for WebSocket support

```
composer require brian9206/codeigniter-ratchet-websocket-support
```

# How to use
First, create your own WebSocketServer
```
<?php
namespace MyApp;
use Ratchet\ConnectionInterface;
use CIRatchet\WebSocketServer;

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
```

Then, create a CLI controller in application/controllers
```
<?php
class Server extends CI_CLIController {
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		echo "Ratchet Start\n";
		$server = new TestWebSocketServer();
		$server->run(8087);
	}
}
```

After that, create a directory under application called 'wscontrollers'
and create your own WebSocket controller under wscontrollers.

Please note that WebSocket controller must be named like XXXController

```
use CIRatchet\CI_WebSocketController;

class TestController extends CI_WebSocketController {
	public function test($conn) {
		$conn->send("Test OK");
	}
}
```

Finally, create a shell script outside your web root directory for starting the ratchet server
```
#!/bin/sh
php public/index.php server
```

Note: server is your CI_CLIController name

