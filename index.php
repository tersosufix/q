<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">

<html>
<head>
    <title></title>
    
    <link href="style.css" rel="stylesheet">
    <meta charset="utf-8">
    <link rel="stylesheet" href="src/css/bootstrap.min.css" 
<script src="http://code.highcharts.com/highcharts.js"></script>
<script   src="https://code.jquery.com/jquery-2.2.3.js"   integrity="sha256-laXWtGydpwqJ8JA+X9x2miwmaiKhn8tVmOVEigRNtP4="   crossorigin="anonymous"></script>
</head>
<body>

<?
require_once("./db_param.php");




    $dev="";
    if ($_POST['devN']==1){ $dev= "'1','2'";  }
    elseif ($_POST['devN']==2)    {     $dev= "'3'"; }
    else {        $dev= "'4'";    }
    $line=$_POST['lineN'];
    


$ds=$_POST['date_start'];
$de=$_POST['date_end'];
$q=("SELECT Device_Type, Device_Number, sum(Ok) as Ok, sum(Rejected) as Rejected, sum(QC_Rejected) as QC_Rejected, DATE_FORMAT(time, '%Y-%m-%dT%H:%i') as custom_date
FROM `Iteration_TotalStats` where Line_Id = $line and Device_Number IN ($dev) and time > '$ds' and time < '$de'");

$result=$dbcon->query($q);


//если нажимаем "запрос", то вызываем функцию выводящую результат запроса


if (isset($_POST['req_info'])){ get_data($result);}
//Собственно сама функция выводящая результат запроса
function get_data($result){
foreach ($result as $row){
echo "Отладочная информация: ";
echo $row['timespan'] . "\t" . $row['visits']. "\n";
print_r($row);
echo "<br /><hr>";
echo "<br /> По вашему запросу, <strong>всего</strong> бутылок прошло:<mark>". $row['Ok']."</mark><br />";
echo "<strong>Сброшено</strong>:<mark>". $row['Rejected']."</mark><br />";
echo "<strong>Системно сброшено</strong>:<mark>". $row['QC_Rejected']."</mark><br />";
echo "Рандомный формат времени". $row['custom_date'];
echo "<br /><hr>";
}
}
if (date('Y-m-d H:i') >=strtotime('Y-m-d 09:00') and date('Y-m-d H:i') <=strtotime('Y-m-d 21:00',date('Y-m-d H:i'))){
echo "Сейчас дневная смена";
}
else {

echo date('Y-m-d H:i');
echo "Сейчас ночная смена";
}
$time_val1= date("Y-m-d\TH:i",strtotime("-1 day",strtotime(date('d.m.Y\T09:00',time()))));
$time_val2= date("Y-m-d\TH:i",strtotime(date('d.m.Y\T21:00',time())));
$date = "ГГГГ-ММ-ДД";

$d = new DateTime($time_val1);

$d->modify("-1 day");

echo $d->format("Y-m-d\TH:i")
?>

<table cellpadding="2px" cellspacing="1px" class="table table-hover">
<tr align="left" style="font-size: 14px;"><th>Начальная дата</th><th>Конечная дата и время</th><th>Номер линии</th><th>Тип контрольного оборудования</th><th></th></tr>
<tr align="left" style="font-size: 10px;"><th>Формат:ГГГГ-ММ-ДДTЧЧ:ММ</th><th>Формат:ГГГГ-ММ-ДДTЧЧ:ММ</th><th></th><th></th><th></th></tr>
<form action="index.php" method="post">
<td><input type="datetime-local" class="form-control" name="date_start" value="<? echo $time_val1;?>"></input></td>
<td><input type="datetime-local" class="form-control" name="date_end" value="<? echo $time_val2;?>"></input></td>
<?




?>
<td><select name='lineN' size="1" class="form-control">
    <?for($ln=1;$ln<9;$ln++):?>
    <option value="<?echo $ln?>" <?if($ln == 4){echo 'selected';}?>><?echo $ln?></option>
    <?endfor?>
    </select></td>
<td><select name='devN' size="1" class="form-control">
<option value="1" selected="selected">M1(все на линии)</option>
<option value="2">iCam</option>
<option value="3">SealCam</option>
</select></td>
    <input type="hidden" name="req_info" value="yes" />
 <td>  <input type="submit" value="Запрос" class="btn btn-primary"/></td>

</tr>
</table>
</form>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<p>123</p>
</body>
</html>

