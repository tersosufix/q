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
<script src="script.js"></script>
<?
$login=$_POST['login'];
$password=$_POST['password'];
if ($login == "admin" and $password == "q123123"){
    

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
   global $dev;
   global $line;
   global $ds;
   global $de;
foreach ($result as $row){
echo "Отладочная информация: ";

print_r($row);
echo "<br /><hr><section class='data-select'></section>";
echo "<strong>Линия:</strong>
".$line."<br />";
echo "<strong>Тип оборудования:</strong> <mark>".$row['Device_Type']."</mark><br />";
echo "<strong>Начало запроса:</strong> ".date("d-m-Y H:i",strtotime($ds))."<br />";
echo "<strong>Конец запроса:</strong> ".date("d-m-y H:i",strtotime($de))."<br />";
echo "По вашему запросу, <strong>всего</strong>";
if (date('Y-m-d H:i',$ds) >= date('Y-m-d 21:00') and date('Y-m-d H:i',$de) <=date('Y-m-d 09:00')){
echo " за ночную смену ";
}
else {
echo " за дневную смену ";
};
echo "Бутылок прошло:<mark>".$row['Ok']."</mark><br />";
echo "<strong>Сброшено</strong>:<mark>". $row['Rejected']."</mark><br />";
echo "<strong>Системно сброшено</strong>:<mark>". $row['QC_Rejected']."</mark><br />";

echo "<br /><hr>";
}
}

$time_val1= date("Y-m-d\TH:i",strtotime("-1 day",strtotime(date('d.m.Y\T09:00',time()))));
$time_val2= date("Y-m-d\TH:i",strtotime(date('d.m.Y\T21:00',time())));

?>
 
<table cellpadding="2px" cellspacing="1px" class="table table-hover">
<tr align="left" style="font-size: 14px;"><th>Начальная дата</th><th>Конечная дата и время</th><th>Номер линии</th><th>Тип контрольного оборудования</th><th></th></tr>
<tr align="left" style="font-size: 10px;"><th>Формат:ГГГГ-ММ-ДДTЧЧ:ММ</th><th>Формат:ГГГГ-ММ-ДДTЧЧ:ММ</th><th></th><th></th><th></th></tr>

<form action="index.php" method="post">
    
<td><input type="datetime-local" class="form-control" name="date_start" value="<? echo $time_val1;?>"></input></td>
<td><input type="datetime-local" class="form-control" name="date_end" value="<? echo $time_val2;?>"></input></td>
</div>
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
<section class='comme-input'>
    <input type="hidden" name="req_info" value="yes" />
 <td>  <button class="btn btn-primary"> Запрос</button></td>
 </section>
</tr>
</table>
</form>
<?
}
else {
?>
<form action="index.php" method="post">
    <table>
        <tr><th>Логин</th><th>Пароль</th><th></th></tr>
        <tr>
    <td><input type="text" name="login" /></td>
    <td><input type="password" name="password" /></td>
    <td><button class="btn btn-primary">Войти</button></td>
    </tr>
    </table>
</form>   
<?
};
?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


</body>
</html>

