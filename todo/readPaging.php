<?php
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/dbTransactions.php';
include_once '../config/responseStatus.php';

use Transactions\DbTransactions as DbTransactions;

$database = new DbTransactions();
$page = isset($_GET['page']) ? $_GET['page'] : 1;

if (!empty($_GET['records'])) {
	$recordsPerPage = $_GET['records'];
} else {
	$recordsPerPage = 5;
}

$fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;

$stmt = $database->readPaging($fromRecordNum, $recordsPerPage);
$rowCount = $stmt->rowCount();

if ($rowCount > 0) {
	$todosArr = array();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$todoItem = array(
			"id" => $row['id'],
			"description" => html_entity_decode($row['description']),
		);
		array_push($todosArr, $todoItem);
	}
	http_response_code(ResponseStatus::HTTP_OK);
	echo json_encode($todosArr, JSON_UNESCAPED_UNICODE);
} else {
	http_response_code(ResponseStatus::HTTP_NOT_FOUND);
	echo json_encode(array("message" => "No tasks found."), JSON_UNESCAPED_UNICODE);
}