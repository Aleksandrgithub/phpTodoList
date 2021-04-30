<?php
header("Content-Type: application/json; charset=UTF-8");

include '../Database/transaction.php';
include '../Model/task.php';
include '../Transport/response.php';

use Model\Task\Task as Task;
use Database\Transaction as Transaction;
use Transport\Response\Status as Status;;

$transaction = new Transaction();
$todo = $transaction->readCompleted();

if ($todo > 0) {
	http_response_code(Status::HTTP_OK);
	echo json_encode($todo, JSON_UNESCAPED_UNICODE);
} else {
	http_response_code(Status::HTTP_NOT_FOUND);
	echo json_encode(array("message" => "The completed task list is empty"), JSON_UNESCAPED_UNICODE);
}