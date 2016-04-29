<?php
$dh = '192.168.10.9';
$du = 'root';
$dp = '398002';
$dn = 'ProcessMonitor';

    $dbcon= new mysqli($dh,$du,$dp,$dn);
    if ($dbcon->connect_error) die ($dbcon->connect_errno.$dbcon->connect_error);


?>