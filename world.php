<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$results = [];
header('Content-Type: text/html; charset=utf-8');

if (isset($_GET['country'])) {
  $country = $_GET['country'];
  $lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

  if ($lookup === 'cities') {
    if (empty($country)) {
      echo "<p>Enter a country to see its cities</p>";
      exit;
    }

    $stmt = $conn->prepare("
      SELECT c.name as city_name, c.district, c.population
      FROM cities c
      INNER JOIN countries co ON c.country_code = co.code
      WHERE co.name LIKE :country
      ORDER BY c.name
    ");
    $stmt->execute(['country' => "%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
      echo "<p>No cities found for that country.</p>";
      exit;
    }

    echo "<table border='1' style='border-collapse:collapse; width:100%;'>";
    echo "<thead><tr><th>City Name</th><th>District</th><th>Population</th></tr></thead>";
    echo "<tbody>";
    foreach ($results as $row) {
      $city_name = htmlspecialchars($row['city_name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
      $district = htmlspecialchars($row['district'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
      $population = htmlspecialchars($row['population'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

      echo "<tr>";
      echo "<td>{$city_name}</td>";
      echo "<td>{$district}</td>";
      echo "<td>{$population}</td>";
      echo "</tr>";
    }
    echo "</tbody></table>";
  } else {
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->execute(['country' => "%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
      echo "<p>No countries found.</p>";
      exit;
    }

    echo "<table>";
    echo "<thead><tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr></thead>";
    echo "<tbody>";
    foreach ($results as $row) {
      $name = htmlspecialchars($row['name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
      $continent = htmlspecialchars($row['continent'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
      $indep = htmlspecialchars($row['independence_year'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
      $head = htmlspecialchars($row['head_of_state'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

      echo "<tr>";
      echo "<td>{$name}</td>";
      echo "<td>{$continent}</td>";
      echo "<td>{$indep}</td>";
      echo "<td>{$head}</td>";
      echo "</tr>";
    }
    echo "</tbody></table>";
  }
}



