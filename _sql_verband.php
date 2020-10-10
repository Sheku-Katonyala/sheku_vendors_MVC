<?php 
error_reporting(0);
$dtbase="sheku_vendors_mvc"; $base=mysqli_connect("127.0.0.1","root","");  mysqli_select_db($base, "$dtbase");

if(!mysqli_select_db($base,"$dtbase")) { 
mysqli_query($base,"create database $dtbase");
$dtbase="sheku_vendors_mvc"; $base=mysqli_connect("127.0.0.1","root","");  mysqli_select_db($base, "$dtbase");
$alltables=$base->query("SHOW tables");
while($alltables_arr=$alltables->fetch_assoc())
{
$base->query("DROP TABLE ".$alltables_arr["Tables_in_{$dtbase}"]);
}
/*-------------------------------*/


$base->query("CREATE TABLE `currency_settings` (
   `ID` int(30) not null auto_increment,
   `Country` varchar(100),
   `Currency` varchar(100),
   PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;");

$base->query("INSERT INTO `currency_settings` (`ID`, `Country`, `Currency`) VALUES 
('1', 'Namibia', 'NAD'),
('2', 'United States of America', 'USD');");

$base->query("CREATE TABLE `members` (
   `Username` int(30) not null auto_increment,
   `Fullname` varchar(100) not null,
   `Cellphone` varchar(100) not null,
   `Email` varchar(100) not null,
   PRIMARY KEY (`Username`),
   UNIQUE KEY (`Cellphone`),
   UNIQUE KEY (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=18;");

$base->query("INSERT INTO `members` (`Username`, `Fullname`, `Cellphone`, `Email`) VALUES 
('1', 'Sheku Katonyala', ' 264813359598', 'pkatonyala@gmail.com'),
('2', 'Shakes Kaox', ' 264820000000', 'shakes@mail222.net');");

$base->query("CREATE TABLE `members_products` (
   `ID` int(30) not null auto_increment,
   `Product_Name` varchar(100),
   `Price` decimal(10,2),
   `Currency_Name` varchar(100),
   `Username` varchar(100),
   PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=19;");

$base->query("INSERT INTO `members_products` (`ID`, `Product_Name`, `Price`, `Currency_Name`, `Username`) VALUES 
('1', 'Math Tutor', '13.00', 'NAD', '1'),
('2', 'Car Racer', '50.00', 'NAD', '1'),
('3', 'Road Signs Tester', '90.00', 'NAD', '1'),
('4', 'Sheku ACC', '59.99', 'NAD', '2'),
('5', 'E-Learning Buddy', '79.99', 'NAD', '2'),
('6', 'Community News Portal', '99.99', 'NAD', '2');
");


header("location:index.php");	
  
} 


?>