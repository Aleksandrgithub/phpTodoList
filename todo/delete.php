<?php
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/todo.php';
include_once  '../config/responseStatus.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);

$data = json_decode(file_get_contents("php://input"));
//curl -i -X POST -H "Content-Type: application/json" -d "{\"id\":\"1\"}" http://localhost/phpTodoList/todo/delete.php

if (isset($data->id)) {
	$id = $data->id;
	$task->setId($id);
	if ($task->delete()) {
		http_response_code(ResponseStatus::HTTP_OK);
		echo json_encode(array("message" => "Задача была удалена."), JSON_UNESCAPED_UNICODE);
	} else {
		http_response_code(ResponseStatus::HTTP_INTERNAL_SERVER_ERROR);
		echo json_encode(array("message" => "Не удалось удалить задачу."));
	}
} else {
	http_response_code(ResponseStatus::HTTP_BAD_REQUEST);
	echo json_encode(array("message" => "Невозможно удалить задачу. Ошибка в запросе"), JSON_UNESCAPED_UNICODE);
}
?>
