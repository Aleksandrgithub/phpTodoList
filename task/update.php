<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include  '../config/response.php';
include  '../config/database.php';
include '../objects/todo.php';

use Todo\Task as Task;
use Database\Transaction as Transaction;
use Response\Status as Status;

const TASK_STATUS = 0;
$transaction = new Transaction();
$task = new Task();
$data = json_decode(file_get_contents("php://input"));

if(isset($data->id) && isset($data->status)) {
	$id = $data->id;
	$status = $data->status;
	if($status == TASK_STATUS) {
		$task->setId($id);
		$task->setStatus($status);
		if ($transaction->markTaskCompleted($task->getStatus(), $task->getId())) {
			http_response_code(Status::HTTP_OK);
			echo json_encode(array("message" => "Task has been updated."), JSON_UNESCAPED_UNICODE);
		} else {
			http_response_code(Status::HTTP_INTERNAL_SERVER_ERROR);
			echo json_encode(array("message" => "Unable to update task."), JSON_UNESCAPED_UNICODE);
		}
	} else {
		http_response_code(Status::HTTP_BAD_REQUEST);
		echo json_encode(array("message" => "There was an error in the request. Status value of 'completed' task = 0"), JSON_UNESCAPED_UNICODE);
	}
} else {
	http_response_code(Status::HTTP_BAD_REQUEST);
	echo json_encode(array("message" => "Unable to update task. Error in the request, indicate the number of the task to be deleted in the request"), JSON_UNESCAPED_UNICODE);
}

