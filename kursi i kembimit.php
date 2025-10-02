<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $euro = $_POST['euro'];
    $kursi = $_POST['kursi'];

    if (is_numeric($euro) && is_numeric($kursi)) {
        $lek = $euro * $kursi;
        echo "<h2>Shuma e konvertuar është: " . number_format($lek, 2) . " Lek (ALL)</h2>";
    } else {
        echo "<h2>Ju lutem shkruani vetëm numra!</h2>";
    }
} else {
    echo "Nuk keni dërguar të dhëna.";
}
?>