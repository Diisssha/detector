<?php
require_once "./fn/Groups.php";
use Core\Fn\Groups\Groups;

header('Content-Type: application/json');
echo json_encode(Groups::getGroups());
