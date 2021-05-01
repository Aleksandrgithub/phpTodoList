<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include '../Database/transaction.php';
include '../Model/task.php';
include '../Transport/response.php';

use Model\Task\Task as Task;
use Transport\Response\Status as ResponseStatus;
use Model\Task\Status as TaskStatus;
use Database\Transaction as Transaction;

$transaction = new Transaction();
$data = json_decode(file_get_contents("php://input"));

if(isset($data->id) && isset($data->status)) {
	$id = $data->id;
	$status = $data->status;
	if($status == TaskStatus::COMPLETED) {
		$task = $transaction->read($id);
		if($task) {
			if($task->getStatus() == 1) {
				if ($transaction->update($task)) {
					http_response_code(ResponseStatus::HTTP_OK);
					echo json_encode(array("message" => "Task has been updated."), JSON_UNESCAPED_UNICODE);
				} else {
					http_response_code(ResponseStatus::HTTP_INTERNAL_SERVER_ERROR);
					echo json_encode(array("message" => "Unable to update task."), JSON_UNESCAPED_UNICODE);
				}
			} else {
				http_response_code(ResponseStatus::HTTP_BAD_REQUEST);
				echo json_encode(array("message" => "Unable to update the task. The task is already marked as completed."), JSON_UNESCAPED_UNICODE);
			}
		} else {
			http_response_code(ResponseStatus::HTTP_BAD_REQUEST);
			echo json_encode(array("message" => "Unable to update the task. There is no task with this number."), JSON_UNESCAPED_UNICODE);
		}
	} else {
		http_response_code(ResponseStatus::HTTP_BAD_REQUEST);
		echo json_encode(array("message" => "There was an error in the request. Status value of 'completed' task = 0"), JSON_UNESCAPED_UNICODE);
	}
} else {
	http_response_code(ResponseStatus::HTTP_BAD_REQUEST);
	echo json_encode(array("message" => "Unable to update task. Error in the request, indicate the number and status of the task to be updated in the request"), JSON_UNESCAPED_UNICODE);
}

