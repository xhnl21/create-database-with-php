<?php
class DataBase{
	public function show_bd($s,$cnx,$dataType){
		$host = $cnx["host"];
		$user = $cnx["user"];
		$pass = $cnx["pass"];
		if($s == true){
			$sql="SHOW DATABASES";
			$link = mysqli_connect($host, $user, $pass);
			if($link == true){
				$result = mysqli_query($link,$sql);
				if($result == false){	
					printf("Error: %s\n", mysqli_error($link));
				}else{
					#return data view
					if($dataType == true){
						$select = "";
						$select .= "<br>DATA BASE EXITS <br>";
						$select .= "<select>";
						while($row = mysqli_fetch_row($result)){
							if (($row[0]!="information_schema") && ($row[0]!="mysql")) {
								$select .= "<option>".$row[0]."</option>";
							}
						}
						$select .= "</select>";
						$select .= "<br>";
					}else{
						$list_tables = array();
						while($row = mysqli_fetch_row($result)){
							if (($row[0]!="information_schema") && ($row[0]!="mysql")) {
								$list_tables[] = current($row);
								$select = $list_tables;
							}
						}					
					}
				}	
			}else{
				die ('<br>Error connecting to mysql: ' . mysqli_error($link).'<br>');
			}
		}else{
			$select = "<br>Error Parameter<br>";
		}
		return $select;
	}	

	public function rename_bd($r,$cnx,$nameBDN,$nameBDO,$data){
		$host = $cnx["host"];
		$user = $cnx["user"];
		$pass = $cnx["pass"];		
		$res = "";
		if($r == true){
			#se crea la base de datos nueva
			self::create_bd($r,$host,$user,$pass,$nameBDN);			
			
			$link = mysqli_connect($host, $user, $pass);
			#Leemos todas las tablas de $nameBDO
			$sql = "SHOW TABLES FROM $nameBDO";
			$show = mysqli_query($link,$sql);		
			#Migramos las estructuras de las tablas
			foreach ($show as $tbname){
				foreach ($tbname as $tbnames){
					$sql = "CREATE TABLE IF NOT EXISTS $nameBDN.$tbnames LIKE $nameBDO.$tbnames";
					$result = mysqli_query($link,$sql);
					if($result == true){
						$res .= "<br>Migrada la estructura de la tabla $nameBDO.$tbnames a $nameBDN.$tbnames <br>";
					}else{
						$res .= "<br>Error al migrar tabla<br>";
					}				
				}	
			}		
			#Si data es true pasamos los datos de cada tabla vieja a la nueva
			if($data == true){
				foreach ($show as $tbname){
					foreach ($tbname as $tbnames){
						$sql = "INSERT INTO $nameBDN.$tbnames SELECT * FROM $nameBDO.$tbnames";
						$result = mysqli_query($link,$sql);
						if($result == true){
							$res .= "<br>Migrados los datos de la tabla $nameBDO.$tbnames a $nameBDN.$tbnames <br>";
						}else{
							$res .= "<br>Los datos fueron migrados<br>";
						}				
					}
				}
			}
			#se elimina la base de datos vieja
			self::delete_bd($r,$host,$user,$pass,$nameBDO);	
		}else{
			$res .= "<br>Error Parameter rename_bd<br>";		
		}
		return $res;
	}
	
	public function delete_bd($d,$cnx,$nameBD){
		$host = $cnx["host"];
		$user = $cnx["user"];
		$pass = $cnx["pass"];	
		if($d == true){
			#Eliminar la base de datos con la clase mysqli
			$link = mysqli_connect($host,$user,$pass);
			$sql = "DROP DATABASE ".$nameBD;
			$resultado = mysqli_query($link,$sql);
			if ($resultado){
				$res = "<br>La base de datos ha sido eliminada correctamente<br>";
			}else{
				$res = "<br>".mysqli_error($link)."<br>";
			}
		}else{
			$res = "<br>Error Parameter delete_bd<br>";		
		}
		return $res;
	}
	
	public function create_bd($c,$cnx,$nameBD){
		$host = $cnx["host"];
		$user = $cnx["user"];
		$pass = $cnx["pass"];	
		if($c == true){
			// Create database
			$sql = "CREATE DATABASE ".$nameBD;
			$link = mysqli_connect($host, $user, $pass);
			if (mysqli_query($link, $sql)) {
				$res = "<br>Base de datos creada correctamente<br>";
			} else {
				$res = "<br>Error creando la base de datos: " . mysqli_error($link)."<br>";
			}
		}else{
			$res = "<br>Error Parameter create_bd<br>";		
		}
		return $res;
	}
	
	public function import_bd($i,$cnx,$nameBD){
		$host = $cnx["host"];
		$user = $cnx["user"];
		$pass = $cnx["pass"];		
		if($i == true){
			$link = mysqli_connect($host, $user, $pass, $nameBD);
			if($link == false){
				self::create_bd($i,$cnx,$nameBD);
				self::show_bd($i,$cnx,$dataType = true);
				header('Location: index.php');
			}else{
				$query = '';
				$sqlScript = 'furion.sql';
				if(file_exists($sqlScript)){
					#ingresa al documento
					$sqlScripts = file($sqlScript);
					foreach($sqlScripts as $line){
						#elimina caracteres especiales
						$startWith = substr(trim($line), 0 ,2);
						$endWith = substr(trim($line), -1 ,1);
						
						if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
								continue;
						}
								
						$query = $query . $line;
						if ($endWith == ';') {
								mysqli_query($link,$query) or die('<br>Problem in executing the SQL query <b>' . $query. '</b><br>');
								$query= '';             
						}
					}
					$res = '<br>SQL file imported successfully<br>';
				}else{
					$res = '<br>BD no encontrada<br>';
				}
			}
		}else{
			$res = "<br>Error Parameter import_bd<br>";		
		}
		return $res;
	}
}

$new = new DataBase(); 
$cnx = array(
	"host" => "localhost",
	"user" => "root",
	"pass" => ""
);

$i = false;
$nameBD = "furion";
$import_bd = $new->import_bd($i,$cnx,$nameBD);
echo $import_bd;

$s = true;
$dataType = true;
$show_bd = $new->show_bd($s,$cnx,$dataType);
echo $show_bd;

$c = false;
$nameBD = "furion";
$rc = $new->create_bd($c,$cnx,$nameBD);
echo $rc;

$d = false;
$nameBD = "furion";
$rd = $new->delete_bd($d,$cnx,$nameBD);
echo $rd;

$r = false;
$data = true;
$nameBDN = "furion";
$nameBDO = "furionxx";
$rr = $new->rename_bd($r,$cnx,$nameBDN,$nameBDO,$data);
echo $rr;
?>