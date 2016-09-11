<?

//INPUT

// define variables and set to empty values
$plate "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $plate = test_input($_POST["plate"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// PROCESSING

$servername = "localhost:3306";
$username = "plates";
$password = "password";

try {
    $conn = new PDO("mysql:host=$servername;dbname=plates", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$stmt = $conn->prepare("SELECT plate FROM plate WHERE plate LIKE '%" . $plate . "%'");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	$i = 0;
	$array = array();
    foreach($stmt->fetchAll() as $k=>$v) {
		$array[$i] = $v;
		$i++;
    }
	
	
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
	



// OUTPUT

header('Content-Type: application/json');


// now we convert the above array to json string using json_encode()
$json = json_encode($array);

echo $json;
?>
