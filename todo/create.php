<?php
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/todo.php';

$database = new Database();
$db = $database->getConnection();

$todo = new Todo($db);

if (isset($_GET['task'])) {
	$task = $_GET['task'];
	if(mb_strlen($task) <= 1000) {
		$todo->description = $task;
		if($todo->create()){
			http_response_code(201);
			echo json_encode(array("message" => "Задача была создан."), JSON_UNESCAPED_UNICODE);
		} else {
			http_response_code(503);
			echo json_encode(array("message" => "Невозможно создать задачу."), JSON_UNESCAPED_UNICODE);
		}
	} else {
		http_response_code(400);
		exit("Невозможно создать задачу с описанием больше чем 1000 символов");
	}
} else {
	http_response_code(400);
	echo json_encode(array("message" => "Невозможно создать задачу. Ошибка в запросе."), JSON_UNESCAPED_UNICODE);
}
?>
