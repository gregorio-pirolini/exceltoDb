<?php
include 'connect.php';
include 'functions.php';

$location = $_GET['location'];

$log=[]; //where is save uploads
$errors=[];//where is save errors


//functions

function uploadMe($t0,$t1,$t2,$t3,$conn,$i){
	global $log;
    global $errors;
	$errors=[];

$T0 = 	$conn 	->	real_escape_string	(trim($t0));
$T1	=	$conn 	->	real_escape_string	(trim($t1));
$T2	=	$conn 	->	real_escape_string	(trim($t2));
$T3	=	$conn 	->	real_escape_string	(trim($t3));

	checkLaenge($T0,'kurz', 25);
	checkLaenge($T1,'lang',150);
	checkLaenge($T2,'fach',25);
	checkLaenge($T3,'meaning',1000);

	// echo '$errors is ' . (gettype ( $errors ));
	// print_r($errors);

if(count($errors)>0){
	$tmpLog=array('number'=> $i,
				'ERROR'=> $errors,
				'kurz'=>$t0,
				'lang'=>$t1,
				'fach'=>$t2,
				'def'=>$t3
);


 
	array_push( $log, $tmpLog);
	$i++;
	return;
}



	//$sql = "INSERT INTO abk (kurz, lang, fach, meaning) VALUES ('$t0','$t1','$t2','$t3')";
	//! create a prepared statement 
	$sql = "INSERT INTO abk(kurz, lang, fach, meaning) VALUES (?,?,?,?)";
	$stmt = $conn->prepare($sql);
	//print $sql."\n";
	// if ($conn->query($sql) === TRUE) {
	// 	array_push( $log,$i.' - '." New record created successfully");
	// } else {
	// 	$err ="Error: " . $sql . "<br>" . $conn->error;
	// 	array_push( $log,$i.' - '.$err) ;
	// }

	// $i++;
	 //! bind parameters for markers 
	 $stmt->bind_param("ssss", $T0,$T1,$T2,$T3);

	 //!execute query
	 if($stmt->execute()){
	 
  // it worked
  $tmpLog=[$i.' - '.$t0.' - '.$t1.' - '.$t2.' - '.$t3    ." New record created successfully"];
  array_push( $log,$tmpLog);
} else {
	// it didn't
	$err = ["Error: ".$i."-> " . $sql . "<br>" . $conn->error];
	 array_push( $log,$err) ;
 }
	 $i++;
	}


	// print_r($log) ;
	


	
		
		
		function checkLaenge($val,$name,$laenge){
		
			global $errors;
		
		// if(strlen($val) > $laenge){
		if(strlen($val) >  $laenge){
		  array_push( $errors, $val.' '.$name.' is: '.strlen($val). ' Should be: '.$laenge .'! ');
		}
		
		}
		
		
		
		

// First, import the needed library and load the Reader of XLSX.


 

require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

 //Read the excel file using the load() function. Here test.xlsx is the file name.



 $spreadsheet = $reader->load($location);


// Get the first sheet in the Excel file and convert it to an array using the toArray() function. And Get the Number of rows in the sheet using the count() function.


 $d=$spreadsheet->getSheet(0)->toArray();
//  echo nl2br (count($d)."\n\n\n");


// If you want to iterate all the rows in the excel file, then first convert it to an array and iterate using for or foreach.


 $sheetData = $spreadsheet->getActiveSheet()->toArray();


// Remove titles from array.;

 unset($sheetData[0]);


 $i=1;
 foreach ($sheetData as $t) {
	 
 // process element here;
 // access column by index
 	// echo $i."---".$t[0].",".$t[1].",".$t[2].",".$t[3]." <br>";
 	// $i++;
	 uploadMe($t[0],$t[1],$t[2],$t[3],$conn,$i);
	 $i++;
	 
 }


 $conn->close();
 echo json_encode($log);
// echo '$location: ' .$location;

 ?>