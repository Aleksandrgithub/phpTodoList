<?php
header("Content-Type: application/json; charset=UTF-8");

include '../Database/transaction.php';
include '../Model/task.php';
include '../Transport/response.php';

use Model\Task\Task as Task;
use Database\Transaction as Transaction;
use Transport\Response\Status as Status;;

$transaction = new Transaction();
$task = new Task();
$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
	$id = $data->id;
	$task->setId($id);
	if($transaction->checkTaskExist($task->getId())) {
		if ($transaction->delete($task->getId())) {
			http_response_code(Status::HTTP_OK);
			echo json_encode(array("message" => "The task has been deleted."), JSON_UNESCAPED_UNICODE);
		} else {
			http_response_code(Status::HTTP_INTERNAL_SERVER_ERROR);
			echo json_encode(array("message" => "Failed to delete task."));
		}
	} else {
		http_response_code(Status::HTTP_BAD_REQUEST);
		echo json_encode(array("message" => "Unable to delete the task. There is no task with this number."), JSON_UNESCAPED_UNICODE);
	}
} else {
	http_response_code(Status::HTTP_BAD_REQUEST);
	echo json_encode(array("message" => "Unable to delete the task. Error in the request, indicate the number of the task to be deleted in the request"), JSON_UNESCAPED_UNICODE);
}
?>
