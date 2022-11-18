<?php
// First, import the needed library and load the Reader of XLSX.
echo  nl2br ("<b>First, import the needed library and load the Reader of XLSX </b>\n\n");

echo  nl2br ("require 'vendor/autoload.php'\n");
echo nl2br ("use PhpOffice\PhpSpreadsheet\Spreadsheet\n");
echo nl2br ('$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx()'."\n\n\n");

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

// Read the excel file using the load() function. Here test.xlsx is the file name.
echo  nl2br ("<b>Read the excel file using the load() function </b>\n\n");

echo nl2br ('$spreadsheet = $reader->load("php/upload/abkürzungen.xlsx")'."\n\n\n");
$spreadsheet = $reader->load("php/upload/abkürzungen.xlsx");


// Get the first sheet in the Excel file and convert it to an array using the toArray() function. And Get the Number of rows in the sheet using the count() function.
echo  nl2br ("<b>Get the first sheet in the Excel file and convert it to an array using the toArray() function. And Get the Number of rows in the sheet using the count() function </b>\n\n");

echo  nl2br ('$d=$spreadsheet->getSheet(0)->toArray()'."\n");
echo  nl2br ('count($d)'."\n\n");
$d=$spreadsheet->getSheet(0)->toArray();
echo nl2br (count($d)."\n\n\n");


// If you want to iterate all the rows in the excel file, then first convert it to an array and iterate using for or foreach.

echo  nl2br ("<b>If you want to iterate all the rows in the excel file, then first convert it to an array and iterate using for or foreach.</b> \n\n");

echo nl2br ('$sheetData = $spreadsheet->getActiveSheet()->toArray()'."\n\n\n");
$sheetData = $spreadsheet->getActiveSheet()->toArray();


echo  nl2br ("<b>Remove titles from array.</b> \n\n");
echo  nl2br ('unset($sheetData[0])'."\n\n\n");
unset($sheetData[0]);

$i=1;
foreach ($sheetData as $t) {
 // process element here;
// access column by index
	echo $i."---".$t[0].",".$t[1].",".$t[2].",".$t[3]." <br>";
	$i++;
}
?>