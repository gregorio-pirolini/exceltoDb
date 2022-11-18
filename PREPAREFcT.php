<?php
require_once ("db.php");
$ergebnis = "";
// 1. prüfen ob auf den Sendebutton geklickt wurde

	// Aufbereitung für prepared statements:
	// Maskierende Slashes aus POST Array entfernen wenn
	// get_magic_quotes nicht eingestellt ist
	/*
    if (get_magic_quotes_gpc()) { 
		$_POST = array_map( 'stripslashes', $_POST ); 
	}
	*/
	
	$nname = trim($_POST['nname']);
	$vname = trim($_POST['vname']);
	$strasse = trim($_POST['strasse']);
	$plz = trim($_POST['plz']);
	$ort = trim($_POST['ort']);
	// 2. prüfen ob Pflichtfelder ausgefüllt wurden 
	/*
			}else{
						//ist eingegebener Username nicht in DB wird DS eingefügt
			$sql = "Insert into login (user,passwd,salt,level) Values (?,?,?,?)";
			//SQL-Anfrage wird an die DB geschickt
			if($result = $dbp->prepare($sql)){
			//Datentypen der Parameter: sssi steht für  3 x string und i x integer (d = double)
			$result->bind_param( 'sssi', $user, $pass, $salt, $level );
			$result->execute();
			$ergebnis = "Eintrag erfolgreich!";
			$result->close();
			$dbp->close();
			}else{
				echo $result->error;
				$ergebnis = "Fehler beim Eintrag!";
			}
		}
		*/
	
		// 3. SQL-Befehl formulieren
		$sql = "INSERT INTO kunden(name, vorname, strasse, plz, ort) VALUES (?,?,?,?,?)";
		        if($insert = $dbp->prepare($sql)){
		// 4. Query an die DB schicken
		$i = 1;
		$sql_bind = "";
			foreach ($_POST as $key => $value){
				if($i < count($_POST)-1){
					$$key = $value;
					
					$sql_bind .= "\$$key" . ",";
					
				}else{
					$sql_bind .= "\$$key";
					break;
				}
				$i++;
		
			}
			printf($sql_bind);	

			//Platzhalter sssss steht für 5 x string (i = integer, d = double
			//werden an Werte gebunden
			
				

				$insert->bind_param('sssss', printf($sql_bind));
			
			//$insert->bind_param( 'sssss', $nname, $vname, $strasse, $plz, $ort );
			//ausführen
			$insert->execute();
		} else {
			//Fehler abfangen
			$insert->error;
		}
		//gibt die Anzahl der veränderten / hinzugefügten DS zurück
		if($dbp->affected_rows){
			$ergebnis = "Eintrag erfolgreich.";
		}
		
	

$dbp->close();

?>
