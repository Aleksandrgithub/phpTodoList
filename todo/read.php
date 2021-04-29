<?php
header("Content-Type: application/json; charset=UTF-8");

include '../config/database.php';
include '../config/response.php';

use Database\Transaction as Transaction;
use Response\Status as Status;

$transaction = new Transaction();
$stmt = $transaction->read();
$rowCount = $stmt->rowCount();

if ($rowCount>0) {
	$todosArr=array();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$todoItem=array(
			"id" => $row['id'],
			"description" => html_entity_decode($row['description']),
		);
		array_push($todosArr, $todoItem);
	}
	http_response_code(Status::HTTP_OK);
	echo json_encode($todosArr, JSON_UNESCAPED_UNICODE);
} else {
	http_response_code(Status::HTTP_NOT_FOUND);
	echo json_encode(array("message" => "The task list is empty"), JSON_UNESCAPED_UNICODE);
}

