<?php
header("Content-Type: application/json; charset=UTF-8");

include '../Database/transaction.php';
include '../Model/task.php';
include '../Transport/response.php';

use Model\Task\Task as Task;
use Database\Transaction as Transaction;
use Transport\Response\Status as Status;

$transaction = new Transaction();
$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
	$id = $data->id;
	if ($transaction->checkTaskExist($id) > 0) {
		$task = $transaction->read($id);
		http_response_code(Status::HTTP_OK);
		echo json_encode($task->getTask(), JSON_UNESCAPED_UNICODE);
	} else {
		http_response_code(Status::HTTP_NOT_FOUND);
		echo json_encode(array("message" => "Task with this number does not exist"), JSON_UNESCAPED_UNICODE);
	}
} else {
	http_response_code(Status::HTTP_BAD_REQUEST);
	echo json_encode(array("message" => "Unable to read the task. Error in the request, indicate the number of the task to be read in the request"), JSON_UNESCAPED_UNICODE);
}
