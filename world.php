<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$results = [];
if (isset($_GET['country'])) {
  $country = $_GET['country'];
  $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

header('Content-Type: text/html; charset=utf-8');
if (empty($results)) {
  echo "<p>No countries found.</p>";
  exit;
}

echo "<table border='1' style='border-collapse:collapse; width:100%;'>";
echo "<thead><tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr></thead>";
echo "<tbody>";
foreach ($results as $row) {
  $name = $row['name'];
  $continent = $row['continent'];
  $indep = $row['independence_year'];
  $head = $row['head_of_state'];



  echo "<tr>";
  echo "<td>{$name}</td>";
  echo "<td>{$continent}</td>";
  echo "<td>{$indep}</td>";
  echo "<td>{$head}</td>";
  echo "</tr>";
}
echo "</tbody></table>";

