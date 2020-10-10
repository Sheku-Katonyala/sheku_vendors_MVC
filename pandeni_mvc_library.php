<script>
function display_element(elementid){document.getElementById(elementid).style.display="block";}
function hide_element(elementid){document.getElementById(elementid).style.display="none";}
function form_validate(elelmentclass)
{
var num_textboxes=document.getElementsByClassName(elelmentclass).length;
var tt="";
var elem_arr=[];
for(var a=0;a<num_textboxes;a++)
{
tt+=document.getElementsByClassName(elelmentclass)[a].value;
elem_arr.push(document.getElementsByClassName(elelmentclass)[a].value);
}




}



</script>

<?php
function view_members($members_table,$products_table)
{
require("_sql_verband.php");
$table1=$base->query("SELECT * FROM {$members_table} ORDER BY Username DESC");
echo "
<table>";
$rrow1=0;
while($table1_arr=$table1->fetch_assoc())
{
if($rrow1%2==0){$elemclass="table_grid_0";}
else{$elemclass="table_grid_1";}
echo "

<tr class='{$elemclass}' style='border-bottom:5px solid'>
<td><a href='?memberid={$table1_arr["Username"]}'><img src='members_Username_{$table1_arr["Username"]}.jpg' class='member_pic' /></a></td>
<td>";

foreach($table1_arr as $table1_arr_k=>$table1_arr_v)
{
if($table1_arr_k=="Username"){continue;}
echo "{$table1_arr_v}<br />";
}
echo "<a class='title_page' href='?memberid={$table1_arr["Username"]}'>View Full Profile</a></td>";

echo "<td style='border-left:1px solid;'>";

/*-----------------------------------------------------------------------*/

$table_arr1=$base->query("SELECT * FROM {$products_table} WHERE Username='{$table1_arr["Username"]}' ORDER BY ID DESC");



while($table_arr1arr=$table_arr1->fetch_assoc())
{


echo "<ol style='display:inline-block;list-style:none;padding:0px;'>";
foreach($table_arr1arr as $table_arr1arr_k=>$table_arr1arr_v)
{
 
if($table_arr1arr_k=="Product_Name"){echo "<li>
<table>
<tr><td><img src='product_ID_{$table_arr1arr["ID"]}.jpg' class='product_images' />
<div style='background-color:white;'>
{$table_arr1arr_v}<br />
<a class='price_span'>{$table_arr1arr["Currency_Name"]} {$table_arr1arr["Price"]}</a>
</div>

</td>

</tr>

</table>
</li>



";}


}

echo "</ol>";



}

echo "
</td>
</tr>
";



$rrow1++;
}

echo "


</table>";
}




function add_new_products($members_table,$products_table)
{
require("_sql_verband.php");
$table1=$base->query("DESCRIBE {$members_table}");
echo "
<form action='?' method='post' enctype='multipart/form-data'>
<span class='title_span'>Add Product's Details</span>";


$table2=$base->query("select * FROM $products_table limit 1");
echo "<table>";
$th_arr=array();
while($tableth=$table2->fetch_field())
{
array_push($th_arr,"{$tableth->name}");
}


for($a=0;$a<5;$a++)
{
if($a%2==0){$tt="table_grid_0";}
else{$tt="table_grid_1";}
echo "<tr class='{$tt}'>";
for($a2=0;$a2<count($th_arr);$a2++)
{

//if($th_arr[$a2]=="Username"){continue;}



if($th_arr[$a2]=="ID")
{
echo "<td><input type='checkbox' name='tickbox[{$a}]' value='{$a}' /><input type='file' name='voeg{$th_arr[$a2]}[{$a}]' /></td>";
continue;
}
if($th_arr[$a2]=="Currency_Name")
{
echo "<td>
<select onchange='form_validate(\"the_textboxes\") class='the_textboxes' name='voeg{$th_arr[$a2]}[{$a}]' />


";
$ccuren=$base->query("SELECT * FROM currency_settings ORDER BY COUNTRY ASC");
while($ccuren_arr=$ccuren->fetch_assoc())
{
echo "<option value='{$ccuren_arr["Currency"]}'>{$ccuren_arr["Country"]}({$ccuren_arr["Currency"]})</option>";
}
echo"
</select>
</td>";
continue;
}
if($th_arr[$a2]=="Price")
{
echo "<td>
<input onblur='form_validate(\"the_textboxes\")' class='the_textboxes' style='width:80px;' onblur='form_validate(\"the_textboxes\")' type='number' name='voeg{$th_arr[$a2]}[{$a}]' placeholder='{$th_arr[$a2]}'  />
.<input type='number' name='voeg{$th_arr[$a2]}_cents[{$a}]' style='width:40px;' maxlength='2' value='00' />
</td>";
continue;
}
if($th_arr[$a2]=="Username")
{
echo "<td style='display:none;'><input onblur='form_validate(\"the_textboxes\")' class='the_textboxes' onblur='form_validate(\"the_textboxes\")' type='text' name='voeg{$th_arr[$a2]}[{$a}]' placeholder='{$th_arr[$a2]}' value='{$_GET["memberid"]}'  /></td>";
continue;
}
echo "<td><input onblur='form_validate(\"the_textboxes\")' class='the_textboxes' onblur='form_validate(\"the_textboxes\")' type='text' name='voeg{$th_arr[$a2]}[{$a}]' placeholder='{$th_arr[$a2]}'  /></td>";





}
echo "</tr>";
}

echo "</table>";
echo "<input type='submit' style='' id='submit_button' name='submit_button' value='Submit' /> 
<input type='reset' onclick='display_element(\"members_div\");display_element(\"divproducts\");hide_element(\"signup_div\");' value='Cancel' />
";

echo "</form>";

if(isset($_POST["submit_button"]))
{


for($z=0;$z<count($_POST["tickbox"]);$z++)
{
if(
$_POST["voegProduct_Name"][$z]=="" ||
$_POST["voegPrice"][$z]=="" ||
$_POST["voegCurrency_Name"][$z]=="" ||
$_POST["voegUsername"][$z]==""
)
{
echo "<script>alert('ERROR! Make sure you have filled row ".($z+1)."');display_element(\"signup_div\");hide_element(\"divproducts\");</script>";

header("refresh:0;url=index.php?memberid={$_POST["voegUsername"][0]}");
return 0;
}
$insert2=$base->query("INSERT INTO $products_table 
(Product_Name,Price,Currency_Name,Username)
VALUES
(
'".mysqli_real_escape_string($base,$_POST["voegProduct_Name"][$z])."',
'".mysqli_real_escape_string($base,$_POST["voegPrice"][$z]).".".mysqli_real_escape_string($base,$_POST["voegPrice_cents"][$z])."',
'".mysqli_real_escape_string($base,$_POST["voegCurrency_Name"][$z])."',
'".mysqli_real_escape_string($base,$_POST["voegUsername"][$z])."'

);

");



$maxid=$base->query("SELECT ID FROM $products_table ORDER BY ID DESC limit 1");
$maxid_arr=$maxid->fetch_assoc();
if (move_uploaded_file($_FILES["voegID"]["tmp_name"][$z], "". basename($_FILES["voegID"]["name"][$z])))
{
rename(basename($_FILES["voegID"]["name"][$z]),"product_ID_{$maxid_arr['ID']}.jpg");
}


}
if($_POST["tickbox"][0]!="" || $_POST["tickbox"][1]!="" || $_POST["tickbox"][2]!="" || $_POST["tickbox"][3]!="" || $_POST["tickbox"][4]!="")
{
echo "<script>alert('Data Added Successfully')</script>";
}
else
{
echo "<script>alert('ERROR! Please tick all rows to submit')</script>";
}

header("refresh:0;url=index.php");
}


}



function view_full_member($tablenaam,$products_table)
{
require("_sql_verband.php");
$qquery1=$base->query("select * from $tablenaam WHERE Username='{$_GET["memberid"]}'");
echo "<table><tr><td><img src='members_Username_{$_GET["memberid"]}.jpg' class='member_pic' /></td><td>";
while($qquery1_arr=$qquery1->fetch_assoc())
{
foreach($qquery1_arr as $qquery1_arr_k=>$qquery1_arr_v)
{
echo "{$qquery1_arr_v}<br />";
}
}
echo "</td></tr></table>";
echo "<div id='divproducts'><span class='span_title'>Products</span>
<a href='#' class='a_button' onclick='display_element(\"signup_div\");hide_element(\"divproducts\");'>Click Here To Add Products</a> 
<a class='span_title' href='?'>Go Back</a>

<br />";
$query2=$base->query("select * from $products_table WHERE Username='{$_GET["memberid"]}'");
while($query2arr=$query2->fetch_assoc())
{
echo "<div style='border:1px solid silver;display:inline-block;'>";
foreach($query2arr as $query2arrk=>$query2arrv)
{

if($query2arrk=="Username" || $query2arrk=="Currency_Name"){continue;}

if($query2arrk=="ID"){
echo "
<img src='product_ID_{$query2arrv}.jpg' class='product_images' /><br />
";
continue;
}
if($query2arrk=="Product_Name")
{
echo "
{$query2arrv}<br />
";
continue;
}

if($query2arrk=="Price")
{
echo "<i style='color:green;'>{$query2arr["Currency_Name"]} {$query2arr["Price"]}</i>";
continue;
}

echo "{$query2arrv}<br />";

}
echo "</div>";
}
echo "</div>";
}

?>

<div class='page_div' id='members_div'><?php if(!isset($_GET["memberid"])){view_members("members","members_products") ;}?></div>
<div class='page_div' id='dontknow' style=''><?php if(isset($_GET["memberid"])){view_full_member("members","members_products");}?></div>
<div class='page_div' id='signup_div' style='display:none;'><?php add_new_products("members","members_products"); ?></div>