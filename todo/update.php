<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';
include_once '../objects/todo.php';
include_once  '../config/responseStatus.php';

const TASK_STATUS = 0;

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);

$data = json_decode(file_get_contents("php://input"));
//curl -i -X POST -H "Content-Type: application/json" -d "{\"id\":\"1\", \"status\":\"0\"}" http://localhost/phpTodoList/todo/update.php

if(isset($data->id) && isset($data->status)) {
	$id = $data->id;
	$status = $data->status;
	if($status == TASK_STATUS) {
		$task->setId($id);
		$task->setStatus($status);
		if ($task->markTaskCompleted()) {
			http_response_code(ResponseStatus::HTTP_OK);
			echo json_encode(array("message" => "Задача был обновлён."), JSON_UNESCAPED_UNICODE);
		} else {
			http_response_code(ResponseStatus::HTTP_INTERNAL_SERVER_ERROR);
			echo json_encode(array("message" => "Невозможно обновить задача."), JSON_UNESCAPED_UNICODE);
		}
	} else {
		http_response_code(ResponseStatus::HTTP_BAD_REQUEST);
		echo json_encode(array("message" => "Ошибка в запросе. Значение статуса 'выполненной' задачи = 0"), JSON_UNESCAPED_UNICODE);
	}
} else {
	http_response_code(ResponseStatus::HTTP_BAD_REQUEST);
	echo json_encode(array("message" => "Невозможно обновить задачу. Ошибка в запросе"), JSON_UNESCAPED_UNICODE);
}

