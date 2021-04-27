<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/dbTransactions.php';
include_once '../objects/task.php';
include_once  '../config/responseStatus.php';

const TASK_STATUS = 0;

$database = new DbTransactions();

$task = new Task();

$data = json_decode(file_get_contents("php://input"));

if(isset($data->id) && isset($data->status)) {
	$id = $data->id;
	$status = $data->status;
	if($status == TASK_STATUS) {
		$task->setId($id);
		$task->setStatus($status);
		if ($database->markTaskCompleted($task->getStatus(), $task->getId())) {
			http_response_code(ResponseStatus::HTTP_OK);
			echo json_encode(array("message" => "Task has been updated."), JSON_UNESCAPED_UNICODE);
		} else {
			http_response_code(ResponseStatus::HTTP_INTERNAL_SERVER_ERROR);
			echo json_encode(array("message" => "Unable to update task."), JSON_UNESCAPED_UNICODE);
		}
	} else {
		http_response_code(ResponseStatus::HTTP_BAD_REQUEST);
		echo json_encode(array("message" => "There was an error in the request. Status value of 'completed' task = 0"), JSON_UNESCAPED_UNICODE);
	}
} else {
	http_response_code(ResponseStatus::HTTP_BAD_REQUEST);
	echo json_encode(array("message" => "Unable to update task. Error in the request, indicate the number of the task to be deleted in the request"), JSON_UNESCAPED_UNICODE);
}

