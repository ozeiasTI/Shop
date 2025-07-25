<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de Troco</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input { margin: 5px; padding: 5px; }
        .resultado { margin-top: 20px; background: #f1f1f1; padding: 10px; border-radius: 8px; }
    </style>
</head>
<body>

<h2>Calculadora de Troco</h2>

<form method="post">
    <label>Valor da compra (R$):</label><br>
    <input type="number" name="compra" step="0.01" required><br>

    <label>Valor pago (R$):</label><br>
    <input type="number" name="pago" step="0.01" required><br>

    <input type="submit" value="Calcular Troco">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $compra = floatval($_POST['compra']);
    $pago = floatval($_POST['pago']);

    if ($pago < $compra) {
        echo "<p style='color:red;'>Valor pago é insuficiente!</p>";
        return;
    }

    $troco = $pago - $compra;
    echo "<div class='resultado'>";
    echo "<strong>Troco total: R$ " . number_format($troco, 2, ',', '.') . "</strong><br><br>";

    // Transformar para centavos (evita erro com casas decimais)
    $centavos = round($troco * 100);

    // Notas e moedas disponíveis
    $valores = [10000, 5000, 2000, 1000, 500, 200, 100, 50, 25, 10, 5, 1]; // em centavos
    $nomes = [
        "R$ 100", "R$ 50", "R$ 20", "R$ 10", "R$ 5", "R$ 2",
        "R$ 1 (moeda)", "R$ 0,50", "R$ 0,25", "R$ 0,10", "R$ 0,05", "R$ 0,01"
    ];

    for ($i = 0; $i < count($valores); $i++) {
        $qtd = intdiv($centavos, $valores[$i]);
        if ($qtd > 0) {
            echo "$qtd x {$nomes[$i]}<br>";
            $centavos %= $valores[$i];
        }
    }

    echo "</div>";
}
?>

</body>
</html>
