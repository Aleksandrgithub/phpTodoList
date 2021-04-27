<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';
include_once  '../config/responseStatus.php';
include_once '../objects/todo.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);

$data = json_decode(file_get_contents("php://input"));
//curl -i -X POST -H "Content-Type: application/json" -d "{\"description\":\"newTask\"}" http://localhost/phpTodoList/todo/create.php

if (isset($data->description)) {
	$description = $data->description;
	if(mb_strlen($description) <= 1000) {
		$task->setDescription($description);
		if($lastId = $task->create()){
			http_response_code(ResponseStatus::HTTP_CREATED);
			echo json_encode(array("message" => "Задача была создан. id = $lastId"), JSON_UNESCAPED_UNICODE);
		} else {
			http_response_code(ResponseStatus::HTTP_INTERNAL_SERVER_ERROR);
			echo json_encode(array("message" => "Невозможно создать задачу."), JSON_UNESCAPED_UNICODE);
		}
	} else {
		http_response_code(ResponseStatus::HTTP_BAD_REQUEST);
		exit("Невозможно создать задачу с описанием больше чем 1000 символов");
	}
} else {
	http_response_code(ResponseStatus::HTTP_BAD_REQUEST);
	echo json_encode(array("message" => "Невозможно создать задачу. Ошибка в запросе"), JSON_UNESCAPED_UNICODE);
}
?>
