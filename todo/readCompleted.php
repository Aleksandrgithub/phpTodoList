<?php
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/dbTransactions.php';
include_once '../config/responseStatus.php';

use Transactions\DbTransactions as DbTransactions;

$database = new DbTransactions();
$stmt = $database->readCompleted();
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
	echo json_encode(array("message" => "The list of completed tasks is empty"), JSON_UNESCAPED_UNICODE);
}