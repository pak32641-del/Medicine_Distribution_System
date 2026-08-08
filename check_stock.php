<?php
session_start();
include("connection.php");

$data = json_decode(file_get_contents("php://input"), true);

$response = [
    "problem" => false,
    "items" => []
];

foreach($data as $index => $item){

    $product_id = intval($item["id"]);

    $q = mysqli_query($conn,
        "SELECT quantity FROM products WHERE product_id='$product_id' LIMIT 1"
    );

    $row = mysqli_fetch_assoc($q);
    $available = $row['quantity'];

    if($item["qty"] > $available){

        $response["problem"] = true;

        $response["items"][] = [
          "index" => $index,
          "available" => $available,
          "problem" => true
        ];
    }
}

echo json_encode($response);
?>