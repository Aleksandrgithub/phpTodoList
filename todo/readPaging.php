<?php
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/todo.php';

$database = new Database();
$db = $database->getConnection();

$todo = new Todo($db);

$page = isset($_GET['page']) ? $_GET['page'] : 1;

if (!empty($_GET['records'])) {
	$recordsPerPage = $_GET['records'];
} else {
	$recordsPerPage = 5;
}

$fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;

$stmt = $todo->readPaging($fromRecordNum, $recordsPerPage);
$rowCount = $stmt->rowCount();

if ($rowCount > 0) {
	$todosArr = array();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		extract($row);
		$todoItem = array(
			"id" => $id,
			"description" => html_entity_decode($description),
		);
		array_push($todosArr, $todoItem);
	}
	http_response_code(200);
	echo json_encode($todosArr, JSON_UNESCAPED_UNICODE);
} else {
	http_response_code(404);
	echo json_encode(array("message" => "Задачи не найдены."), JSON_UNESCAPED_UNICODE);
}