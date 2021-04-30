<?php
header("Content-Type: application/json; charset=UTF-8");

include '../Database/transaction.php';
include '../Model/task.php';
include '../Transport/response.php';

use Model\Task\Task as Task;
use Database\Transaction as Transaction;
use Transport\Response\Status as Status;;

$page = isset($_GET['page']) ? $_GET['page'] : 1;

if (!empty($_GET['records'])) {
	$recordsPerPage = $_GET['records'];
} else {
	$recordsPerPage = 5;
}

$fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;

$transaction = new Transaction();
$todo = $transaction->readPaging($fromRecordNum, $recordsPerPage);

if ($todo > 0) {
	http_response_code(Status::HTTP_OK);
	echo json_encode($todo, JSON_UNESCAPED_UNICODE);
} else {
	http_response_code(Status::HTTP_NOT_FOUND);
	echo json_encode(array("message" => "The task list is empty"), JSON_UNESCAPED_UNICODE);
}