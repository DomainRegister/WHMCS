<?php  

// csvimportdomains.php
// very simple php script to barely import domain records in WHMCS
//
// * separator used in csv file must be comma
// * fields in csv must be as follows:
//    userid
//    type 
//    registrationdate
//    domain
//    firstpaymentamount
//    recurringamount
//    registrar
//    registrationperiod
//    expirydate
//    status
//    nextduedate
//   	paymentmethod

//connect to the database 

$db_host = 'localhost';
$db_username = 'dbusername';
$db_password = 'dbpassword';
$db_name = 'dbname';



$connect = mysql_connect($db_host,$db_username,$db_password); 
mysql_select_db($db_name,$connect);       
// 

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    $file = $_FILES[csv][tmp_name]; 
    $handle = fopen($file,"r"); 
     
    //loop through the csv file and insert into database 
    do { 
        if ($data[0]) { 
            mysql_query("INSERT INTO tbldomains (userid, type, registrationdate, domain, firstpaymentamount, recurringamount, registrar, registrationperiod, expirydate, status, nextduedate, 	paymentmethod ) VALUES 
                ( 
                    '".addslashes($data[0])."', 
                    '".addslashes($data[1])."',
                    '".addslashes($data[2])."',
                    '".addslashes($data[3])."',
                    '".addslashes($data[4])."',
                    '".addslashes($data[5])."',
                    '".addslashes($data[6])."',
                    '".addslashes($data[7])."',
                    '".addslashes($data[8])."',
                    '".addslashes($data[9])."',
                    '".addslashes($data[10])."',
                    '".addslashes($data[11])."' 
                ) 
            ");
            echo $data[3]." ";
            echo $data[4]."    ";
            echo "\n";
        } 
    } while ($data = fgetcsv($handle)); 
    // 

    //redirect 
    header('Location: csvimportdomains.php?success=1'); die; 

} 

?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Import a CSV File with PHP & MySQL</title> 
</head> 

<body> 

<?php if (!empty($_GET[success])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?> 

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  Choose your file: <br /> 
  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" /> 
</form> 

</body> 
</html> 
