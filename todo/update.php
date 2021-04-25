<?php
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/todo.php';

$database = new Database();
$db = $database->getConnection();

$todo = new Todo($db);

if((isset($_GET['status'])) && isset($_GET['id'])) {
	$id = $_GET['id'];
	$status = $_GET['status'];
	$todo->id = $id;
	$todo->status = $status;
	if ($todo->update()) {
		http_response_code(200);
		echo json_encode(array("message" => "Задача был обновлён."), JSON_UNESCAPED_UNICODE);
	} else {
		http_response_code(503);
		echo json_encode(array("message" => "Невозможно обновить задача."), JSON_UNESCAPED_UNICODE);
	}
} else {
	http_response_code(400);
	echo json_encode(array("message" => "Невозможно обновить задачу. Ошибка в запросе. Пример правильного запроса: http://localhost/phpTodoList/todo/update.php?id=1&status=0"), JSON_UNESCAPED_UNICODE);
}

