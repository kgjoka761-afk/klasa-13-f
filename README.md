[kembimi valutor.php](https://github.com/user-attachments/files/22791646/kembimi.valutor.php)
<?php
// convert.php
// Vendos këtë file në të njëjtin folder me index.html dhe sigurohu që serveri të ekzekutojë PHP.

// Helper: pastro inputin e string (heq hapësira, e bën të uniformë)
function clean_number_string($s) {
    // hiq hapësirat
    $s = trim($s);
    // zevendeso presjen me pikë për decimal (pranon si 12,5 dhe 12.5)
    $s = str_replace(',', '.', $s);
    // hiq çdo karakter përveç shifrave, shkronjës minus dhe pikës decimale
    // lejo edhe simbolin minus në fillim për rasti (por më poshtë do ta refuzojmë nëse negative)
    $s = preg_replace('/[^0-9\.\-]/', '', $s);
    return $s;
}

function safe_html($s) {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$result = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // marrim të dhënat raw
    $raw_euro = isset($_POST['euro']) ? $_POST['euro'] : '';
    $raw_rate = isset($_POST['rate']) ? $_POST['rate'] : '';

    // sanitizojmë inputet
    $euro_str = clean_number_string($raw_euro);
    $rate_str = clean_number_string($raw_rate);

    // kontroll themelor: fushat required
    if ($euro_str === '' || $rate_str === '') {
        $error = "Të dy fushat (Euro dhe Koeficienti) janë të detyrueshme.";
    } else {
        // validim numeric
        if (!is_numeric($euro_str) || !is_numeric($rate_str)) {
            $error = "Të dhënat duhet të jenë numra të vlefshëm (p.sh. 12.5 ose 12,50).";
        } else {
            // convert to float
            $euro = floatval($euro_str);
            $rate = floatval($rate_str);

            // kontroll: vlera negative nuk pranohet
            if ($euro < 0 || $rate <= 0) {
                $error = "Shuma duhet të jetë >= 0 dhe koeficienti duhet të jetë > 0.";
            } else {
                // llogaritja
                $converted = $euro * $rate;
                // formatim i rezultatit me 2 decimal (mund ta ndryshosh)
                $formatted_converted = number_format($converted, 2, '.', ',');
                $formatted_euro = number_format($euro, 2, '.', ',');
                $formatted_rate = number_format($rate, 4, '.', ',');
                $result = [
                    'euro' => $formatted_euro,
                    'rate' => $formatted_rate,
                    'converted' => $formatted_converted
                ];
            }
        }
    }
}
?>
<!doctype html>
<html lang="sq">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Rezultati: Këmbim Valutore</title>
  <style>
    body { font-family: Arial, sans-serif; padding:24px; max-width:720px; margin:auto; }
    .box { padding:18px; border-radius:8px; box-shadow: 0 0 6px rgba(0,0,0,0.06); }
    .error { background:#ffecec; color:#b00000; padding:12px; margin-bottom:12px; border-radius:6px; }
    .success { background:#eef9ee; color:#0b6b11; padding:12px; margin-bottom:12px; border-radius:6px; }
    a { display:inline-block; margin-top:12px; }
  </style>
</head>
<body>
  <h1>Rezultati i Konvertimit</h1>

  <div class="box">
    <?php if ($error): ?>
      <div class="error"><?php echo safe_html($error); ?></div>
      <a href="index.html">&larr; Kthehu te forma</a>

    <?php elseif ($result): ?>
      <div class="success">
        <p>Shuma në Euro: <strong><?php echo safe_html($result['euro']); ?> EUR</strong></p>
        <p>Koeficienti i këmbimit (EUR → ALL): <strong><?php echo safe_html($result['rate']); ?></strong></p>
        <p style="font-size:18px; margin-top:10px;">Shumen e konvertuar ne <strong>Lek (ALL): <?php echo safe_html($result['converted']); ?></strong></p>
      </div>
      <a href="index.html">&larr; Kthehu dhe bëj një konvertim tjetër</a>

    <?php else: ?>
      <p>Asnjë të dhënë e dërguar. Përdor <a href="index.html">formularin</a> për të bërë konvertimin.</p>
    <?php endif; ?>
  </div>
</body>
</html>
