<?php

// CREATE TABLE hearts (
// presentatieId TINYTEXT NOT NULL,
// deviceId int NOT NULL,
// CONSTRAINT c_pairs UNIQUE (presentatieId, deviceId)
// )

// DELETE FROM hearts;

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["deviceId"] && $_POST["presentatieId"]) {
    $deviceId = (int) $_POST["deviceId"];
    $presentatieId = $_POST["presentatieId"];
    if (isset($_POST["hearted"]) && $_POST["hearted"] === "true") {
        $sql = "INSERT OR IGNORE INTO hearts (deviceId, presentatieId) VALUES ('{$deviceId}', {$presentatieId});";
    } else {
        $sql = "DELETE FROM hearts WHERE deviceId = '{$deviceId}' AND presentatieId = {$presentatieId};";
    }
    $pdo = new PDO('sqlite:hearts.db');
    $rs = $pdo->query($sql);
}
$sql = "SELECT presentatieId, COUNT(deviceId) as count FROM hearts GROUP BY presentatieId;";
$pdo = new PDO('sqlite:hearts.db');
$rs = $pdo->query($sql);
header("Content-type: application/json");
echo json_encode($rs->fetchAll(PDO::FETCH_ASSOC));
