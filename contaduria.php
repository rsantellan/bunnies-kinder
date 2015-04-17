<?php
error_reporting(E_ALL);
$database = 'bunnyski_site';
$username = 'root';
$password = 'root';
$conn = new PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
/*
$sqlCuentas = 'SELECT id, referenciabancaria, debe, pago, diferencia FROM cuenta';
$sqlFacturasTotal = 'select cuenta_id, sum(total) as factura from facturaFinal where cuenta_id = ? group by cuenta_id';
$sqlCobrosTotal = 'select cuenta_id, sum(monto) as cobro from cobro where cuenta_id = ? group by cuenta_id';
$stmtCuentas = $conn->prepare($sqlCuentas);
$stmtCuentas->execute();
$stmtFacturas = $conn->prepare($sqlFacturasTotal);
$stmtCobros = $conn->prepare($sqlCobrosTotal);
while($row = $stmtCuentas->fetch())
{
    $stmtFacturas->execute(array($row['id']));
    $rowFactura = $stmtFacturas->fetch();
    
    $stmtCobros->execute(array($row['id']));
    $rowCobro = $stmtCobros->fetch();
    $diferenciaCalculada = (float) $rowFactura['factura'] - (float) $rowCobro['cobro'];
    if($diferenciaCalculada != (float) $row['diferencia'])
    {
    var_dump(sprintf("[TOTALES]Cuenta: %s, Debe: %s , Pago: %s, Diferencia: %s. Total facturas: %s, Total cobros: %s, diferencia calculada: %s", $row['id'], $row['debe'], $row['pago'], $row['diferencia'], $rowFactura['factura'], $rowCobro['cobro'], $diferenciaCalculada));
    }
}
*/
$sqlCuentas = 'SELECT id, referenciabancaria, debe, pago, diferencia FROM cuenta';
$sqlFacturasTotal = 'select cuenta_id, sum(total) as factura from facturaFinal where cuenta_id = ? and year = 2015 group by cuenta_id';
$sqlCobrosTotal = "select cuenta_id, sum(monto) as cobro from cobro where cuenta_id = ? and fecha > '2015-01-01'  group by cuenta_id";
$stmtCuentas = $conn->prepare($sqlCuentas);
$stmtCuentas->execute();
$stmtFacturas = $conn->prepare($sqlFacturasTotal);
$stmtCobros = $conn->prepare($sqlCobrosTotal);
while($row = $stmtCuentas->fetch())
{
    $stmtFacturas->execute(array($row['id']));
    $rowFactura = $stmtFacturas->fetch();
    
    $stmtCobros->execute(array($row['id']));
    $rowCobro = $stmtCobros->fetch();
    $diferenciaCalculada = (float) $rowFactura['factura'] - (float) $rowCobro['cobro'];
    
    if($diferenciaCalculada != (float) $row['diferencia'])
    {
        var_dump(sprintf("[2015]Cuenta: %s, Debe: %s , Pago: %s, Diferencia: %s. Total facturas: %s, Total cobros: %s, diferencia calculada: %s", $row['id'], $row['debe'], $row['pago'], $row['diferencia'], $rowFactura['factura'], $rowCobro['cobro'], $diferenciaCalculada));
    }
    
    
}
