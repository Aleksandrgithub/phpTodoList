<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/dbTransactions.php';
include_once  '../config/responseStatus.php';
include_once '../objects/task.php';

use Todo\Task as Task;
use Transactions\DbTransactions as DbTransactions;

$database = new DbTransactions();
$task = new Task();
$data = json_decode(file_get_contents("php://input"));

if (isset($data->description)) {
	$description = $data->description;
	if(mb_strlen($description) <= 1000) {
		$task->setDescription($description);
		if($database->create($task->getDescription())){
			$taskId = $database->getLastInsertId();
			http_response_code(ResponseStatus::HTTP_CREATED);
			echo json_encode(array("message" => "The task has been created. Task number: $taskId"), JSON_UNESCAPED_UNICODE);
		} else {
			http_response_code(ResponseStatus::HTTP_INTERNAL_SERVER_ERROR);
			echo json_encode(array("message" => "Unable to create task."), JSON_UNESCAPED_UNICODE);
		}
	} else {
		http_response_code(ResponseStatus::HTTP_BAD_REQUEST);
		exit("It is impossible to create a task with a description of more than 1000 characters");
	}
} else {
	http_response_code(ResponseStatus::HTTP_BAD_REQUEST);
	echo json_encode(array("message" => "Unable to create task. Error in request"), JSON_UNESCAPED_UNICODE);
}
?>
