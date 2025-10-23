<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $monedha = $_POST['monedha'];   
    $vlera   = $_POST['vlera'];     
    $kursi   = $_POST['kursi'];     
    if (is_numeric($vlera) && is_numeric($kursi)) {

        $lek = $vlera * $kursi;

        echo "<h2>Shuma e konvertuar (${monedha} → LEK) është: "
             . number_format($lek, 2) . " Lek (ALL)</h2>";

    } else {
        echo "<h2>Ju lutem shkruani vetëm numra!</h2>";
    }

} else {
    echo "Nuk keni dërguar të dhëna.";
}
?>
