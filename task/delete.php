<?php
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/dbTransactions.php';
include_once '../objects/task.php';
include_once  '../config/responseStatus.php';

$database = new DbTransactions();

$task = new Task();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
	$id = $data->id;
	$task->setId($id);
	if ($database->delete($task->getId($id))) {
		http_response_code(ResponseStatus::HTTP_OK);
		echo json_encode(array("message" => "The task has been deleted."), JSON_UNESCAPED_UNICODE);
	} else {
		http_response_code(ResponseStatus::HTTP_INTERNAL_SERVER_ERROR);
		echo json_encode(array("message" => "Failed to delete task."));
	}
} else {
	http_response_code(ResponseStatus::HTTP_BAD_REQUEST);
	echo json_encode(array("message" => "Unable to delete the task. Error in the request, indicate the number of the task to be deleted in the request"), JSON_UNESCAPED_UNICODE);
}
?>
