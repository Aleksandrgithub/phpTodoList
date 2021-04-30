<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include '../Database/transaction.php';
include '../Model/task.php';

use Model\Task\Task as Task;
use Model\Task\Status as Status;
use Database\Transaction as Transaction;

$transaction = new Transaction();
$task = new Task();
$data = json_decode(file_get_contents("php://input"));

if(isset($data->id) && isset($data->status)) {
	$id = $data->id;
	$status = $data->status;
	if($status == Status::COMPLETED) {
		$task->setId($id);
		$task->setStatusCompleted($status);
		if($transaction->checkTaskExist($id)) {
			if($transaction->checkTaskStatus($id)) {
				if ($transaction->update($task)) {
					http_response_code(200);
					echo json_encode(array("message" => "Task has been updated."), JSON_UNESCAPED_UNICODE);
				} else {
					http_response_code(500);
					echo json_encode(array("message" => "Unable to update task."), JSON_UNESCAPED_UNICODE);
				}
			} else {
				http_response_code(400);
				echo json_encode(array("message" => "Unable to update the task. The task is already marked as completed."), JSON_UNESCAPED_UNICODE);
			}
		} else {
			http_response_code(400);
			echo json_encode(array("message" => "Unable to update the task. There is no task with this number."), JSON_UNESCAPED_UNICODE);
		}
	} else {
		http_response_code(400);
		echo json_encode(array("message" => "There was an error in the request. Status value of 'completed' task = 0"), JSON_UNESCAPED_UNICODE);
	}
} else {
	http_response_code(400);
	echo json_encode(array("message" => "Unable to update task. Error in the request, indicate the number and status of the task to be updated in the request"), JSON_UNESCAPED_UNICODE);
}

