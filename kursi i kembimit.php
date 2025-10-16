<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $monedha = $_POST['monedha'];
    $vlera = $_POST['vlera'];
    $kursi = $_POST['kursi'];

    if (is_numeric($vlera) && is_numeric($kursi)) {
        $lek = $vlera * $kursi;

        // Emri i plotë i monedhës për shfaqje më të bukur
        switch ($monedha) {
            case "EUR":
                $emriMonedhes = "Euro (€)";
                break;
            case "USD":
                $emriMonedhes = "Dollar Amerikan ($)";
                break;
            case "GBP":
                $emriMonedhes = "Paund Britanik (£)";
                break;
            case "CHF":
                $emriMonedhes = "Frangë Zvicerane (CHF)";
                break;
            case "JPY":
                $emriMonedhes = "Jen Japonez (¥)";
                break;
            case "CAD":
                $emriMonedhes = "Dollar Kanadez (C$)";
                break;
            default:
                $emriMonedhes = "Monedhë e panjohur";
        }

        echo "<h2>Rezultati i konvertimit:</h2>";
        echo "<p><strong>$vlera</strong> $emriMonedhes = <strong>" . number_format($lek, 2) . "</strong> Lekë (ALL)</p>";
    } else {
        echo "<h2>❌ Ju lutem shkruani vetëm numra!</h2>";
    }
} else {
    echo "<h2>⚠️ Nuk keni dërguar të dhëna nga formulari.</h2>";
}
?>
