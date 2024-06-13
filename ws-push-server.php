<?php

require_once 'Config.php';
require_once '../vendor/autoload.php';

use server\CommandServer;

$server = new CommandServer('tcp://0.0.0.0:80', Config::$COMMAND_AUTH_TOKEN, 'tcp://0.0.0.0:8000');
$server->run();
