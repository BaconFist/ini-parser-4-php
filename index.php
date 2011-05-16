<?php
require_once 'class.iniFile.php';
require_once 'class.iniSection.php';
require_once 'class.iniParser.php';

$ini = new iniFile('test.ini');
print_r($ini);

?>
