<?php
$number = rand(1, 100);
$elements = ["Elemento1", "Elemento2", "Elemento3", "Elemento4", "Elemento5"];
echo json_encode([
    "random_number" => $number,
    "parity" => $number % 2 === 0 ? "par" : "impar",
    "random_element" => $elements[array_rand($elements)]
]);
?>