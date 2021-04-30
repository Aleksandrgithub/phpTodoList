<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include '../Database/transaction.php';
include '../Model/task.php';
include '../Transport/response.php';

use Model\Task\Task as Task;
use Database\Transaction as Transaction;
use Transport\Response\Status as Status;

$transaction = new Transaction();
$task = new Task();
$data = json_decode(file_get_contents("php://input"));

if (isset($data->description)) {
	$description = $data->description;
	if(mb_strlen($description) <= 1000) {
		$task->setDescription($description);
		if($transaction->create($task)){
			$taskId = $transaction->getLastInsertId();
			http_response_code(Status::HTTP_CREATED);
			echo json_encode(array("message" => "The task has been created. Task number: $taskId"), JSON_UNESCAPED_UNICODE);
		} else {
			http_response_code(Status::HTTP_INTERNAL_SERVER_ERROR);
			echo json_encode(array("message" => "Unable to create task."), JSON_UNESCAPED_UNICODE);
		}
	} else {
		http_response_code(Status::HTTP_BAD_REQUEST);
		exit("It is impossible to create a task with a description of more than 1000 characters");
	}
} else {
	http_response_code(Status::HTTP_BAD_REQUEST);
	echo json_encode(array("message" => "Unable to create task. Error in request, indicate the description of the task to be created in the request"), JSON_UNESCAPED_UNICODE);
}
?>
