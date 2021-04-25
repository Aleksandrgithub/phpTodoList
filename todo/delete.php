<?php
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/todo.php';

$database = new Database();
$db = $database->getConnection();

$todo = new Todo($db);

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$todo->id = $id;
	if ($todo->delete()) {
		http_response_code(200);
		echo json_encode(array("message" => "Задача была удалена."), JSON_UNESCAPED_UNICODE);
	} else {
		http_response_code(503);
		echo json_encode(array("message" => "Не удалось удалить задачу."));
	}
} else {
	http_response_code(400);
	echo json_encode(array("message" => "Невозможно удалить задачу. Ошибка в запросе."), JSON_UNESCAPED_UNICODE);
}
?>
