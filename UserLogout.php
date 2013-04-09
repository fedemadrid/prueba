<?php

require_once(dirname(__FILE__).'/lib/Autoload.php');

session_destroy();
header('Location: index.php');