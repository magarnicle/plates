<?

//INPUT

// define variables and set to empty values
$user;



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user = test_input($_POST["user"]);
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
	
	$stmt = $conn->prepare("SELECT COUNT(message) FROM message m JOIN plate p ON m.plate = p.plate WHERE p.user_name = '" . $user . "' and is_read = 0");
    $stmt->execute();

	//Return the number of messages
    echo $stmt->fetchColumn();
	
	
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
	
?>