<?

//INPUT

// define variables and set to empty values
$user = $plate = $message = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user = test_input($_POST["user"]);
  $plate = test_input($_POST["plate"]);
  $message = test_input($_POST["message"]);
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
	$stmt = $conn->prepare("INSERT INTO message (user_name, plate, message, is_read) VALUES ('" . $user . "','" . $plate . "','" . $message . "',0)");
    $stmt->execute();
	
	
echo "message sent";
	
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
	
	


?>