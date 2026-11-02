
<!DOCTYPE html>
<html>
<head>
    <title>Week 9 Assignment</title>
</head>
<body>

<h1>Week 9 Assignment</h1>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "sql1.njit.edu";
$username = "na772";
$password = "YOUR_MYSQL_PASSWORD";
$dbname = "na772";

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create Student table
$sql = "CREATE TABLE IF NOT EXISTS Student (
    Name VARCHAR(100),
    ID INT PRIMARY KEY,
    Major VARCHAR(100)
)";
mysqli_query($con, $sql);

// Create Transcript table
$sql = "CREATE TABLE IF NOT EXISTS Transcript (
    ID INT,
    Course VARCHAR(50),
    Grade VARCHAR(5)
)";
mysqli_query($con, $sql);

// Insert students
$sql = "INSERT INTO Student VALUES
('Nia', 1001, 'Information Technology'),
('Ashley', 1002, 'Biology'),
('Michael', 1003, 'Computer Science'),
('Jessica', 1004, 'Business')
ON DUPLICATE KEY UPDATE
Name=VALUES(Name), Major=VALUES(Major)";
mysqli_query($con, $sql);

// Remove old transcript entries for these students
mysqli_query($con, "DELETE FROM Transcript
WHERE ID IN (1001, 1002, 1003, 1004)");

// Insert transcript data
$sql = "INSERT INTO Transcript VALUES
(1001, 'IT202', 'A'),
(1001, 'MATH111', 'B+'),
(1002, 'BIOL101', 'A'),
(1002, 'CHEM101', 'B'),
(1003, 'CS100', 'A'),
(1003, 'CS113', 'B+'),
(1004, 'MGMT101', 'A'),
(1004, 'ECON201', 'A-')";
mysqli_query($con, $sql);

// Display Student table
echo "<h2>Student Table</h2>";
$result = mysqli_query($con, "SELECT * FROM Student");

echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Name</th><th>ID</th><th>Major</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>".$row['Name']."</td>";
    echo "<td>".$row['ID']."</td>";
    echo "<td>".$row['Major']."</td>";
    echo "</tr>";
}
echo "</table>";

// Display Transcript table
echo "<h2>Transcript Table</h2>";
$result = mysqli_query($con, "SELECT * FROM Transcript");

echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Course</th><th>Grade</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>".$row['ID']."</td>";
    echo "<td>".$row['Course']."</td>";
    echo "<td>".$row['Grade']."</td>";
    echo "</tr>";
}
echo "</table>";

// Join both tables
echo "<h2>Joined Table</h2>";

$sql = "SELECT Student.Name, Student.ID,
Student.Major, Transcript.Course, Transcript.Grade
FROM Student
INNER JOIN Transcript
ON Student.ID = Transcript.ID";

$result = mysqli_query($con, $sql);

echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Name</th><th>ID</th><th>Major</th><th>Course</th><th>Grade</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>".$row['Name']."</td>";
    echo "<td>".$row['ID']."</td>";
    echo "<td>".$row['Major']."</td>";
    echo "<td>".$row['Course']."</td>";
    echo "<td>".$row['Grade']."</td>";
    echo "</tr>";
}
echo "</table>";

mysqli_close($con);
?>

</body>
</html>
