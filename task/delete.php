<?php
header("Content-Type: application/json; charset=UTF-8");

include  '../config/response.php';
include  '../config/database.php';
include '../objects/todo.php';

use Todo\Task as Task;
use Database\Transaction as Transaction;
use Response\Status as Status;

$transaction = new Transaction();
$task = new Task();
$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
	$id = $data->id;
	$task->setId($id);
	if ($transaction->delete($task->getId())) {
		http_response_code(Status::HTTP_OK);
		echo json_encode(array("message" => "The task has been deleted."), JSON_UNESCAPED_UNICODE);
	} else {
		http_response_code(Status::HTTP_INTERNAL_SERVER_ERROR);
		echo json_encode(array("message" => "Failed to delete task."));
	}
} else {
	http_response_code(Status::HTTP_BAD_REQUEST);
	echo json_encode(array("message" => "Unable to delete the task. Error in the request, indicate the number of the task to be deleted in the request"), JSON_UNESCAPED_UNICODE);
}
?>
