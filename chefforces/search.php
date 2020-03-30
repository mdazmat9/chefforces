<!-- This is for auto fillup for contest  -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "codechef";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
} 
$id = $_GET['q']; 
$sql = "select name from contest where name like '%".$id."%'  limit 10";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
 while($row = $result->fetch_assoc()) {
    echo $row["name"]. "\n";
}
} 
$conn->close();
?>
