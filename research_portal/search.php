<?php
require_once("includes/db.php");

$q = "";

function highlight($text, $search){

    if(empty($search)){
        return htmlspecialchars($text);
    }

    return preg_replace(
        "/(" . preg_quote($search, "/") . ")/i",
        "<mark>$1</mark>",
        htmlspecialchars($text)
    );
}

$students = [];
$professors = [];
$publications = [];
$studentCount = 0;
$professorCount = 0;
$publicationCount = 0;

if(isset($_GET['q'])){

    $q = trim($_GET['q']);

    if($q != ""){

        $search = "%".$q."%";

        // Students
     $stmt = $conn->prepare("
SELECT id,full_name,major,status
FROM students
WHERE full_name LIKE ?
OR major LIKE ?
OR email LIKE ?
OR thesis_title LIKE ?
OR research_interests LIKE ?
");

$stmt->bind_param(
"sssss",
$search,
$search,
$search,
$search,
$search
);
        $stmt->execute();
        $students = $stmt->get_result();
        $studentCount = $students->num_rows;


        // Professors
      $stmt = $conn->prepare("
SELECT id,name,field
FROM professor
WHERE name LIKE ?
OR field LIKE ?
OR email LIKE ?
OR position LIKE ?
");

$stmt->bind_param(
"ssss",
$search,
$search,
$search,
$search
);
        $stmt->execute();
        $professors = $stmt->get_result();
        $professorCount = $professors->num_rows;


        // Publications
       $stmt = $conn->prepare("
SELECT id,title,authors,journal,year
FROM publications
WHERE title LIKE ?
OR authors LIKE ?
OR journal LIKE ?
OR doi LIKE ?
");

$stmt->bind_param(
"ssss",
$search,
$search,
$search,
$search
);
        $stmt->execute();
        $publications = $stmt->get_result();
        $publicationCount = $publications->num_rows;

    }

}
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Search</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>

body{
margin:0;
background:#f1f5f9;
font-family:'Inter',sans-serif;
}

.container{
max-width:1100px;
margin:40px auto;
}

.card{
background:white;
padding:25px;
margin-bottom:25px;
border-radius:15px;
box-shadow:0 5px 20px rgba(0,0,0,.05);
}

h1{
color:#1e3a8a;
}

h2{
color:#2563eb;
margin-top:0;
}

.item{
padding:12px 0;
border-bottom:1px solid #eee;
}

.item:last-child{
border:none;
}

a{
color:#1e3a8a;
text-decoration:none;
font-weight:600;
}

a:hover{
text-decoration:underline;
}

.back{
display:inline-block;
margin-bottom:25px;
}

mark{
background:#fff176;
padding:2px 4px;
border-radius:4px;
font-weight:bold;
}

.search-form{
display:flex;
margin:20px 0;
}

.search-form input{
flex:1;
padding:12px;
border:1px solid #ccc;
border-radius:8px 0 0 8px;
font-size:15px;
outline:none;
}

.search-form button{
padding:12px 18px;
border:none;
background:#2563eb;
color:white;
cursor:pointer;
border-radius:0 8px 8px 0;
}

.search-form button:hover{
background:#1d4ed8;
}

</style>

</head>

<body>

<div class="container">

<a class="back" href="public_page.php">← Back to Home</a>

<h1>Search Results</h1>

<form action="search.php" method="GET" class="search-form">

<input
type="text"
name="q"
placeholder="Search..."
value="<?= htmlspecialchars($q) ?>"
required>

<button type="submit">🔍</button>

</form>

<br>

<p>
Searching for:
<strong><?= htmlspecialchars($q) ?></strong>
</p>

<?php
if(
    $studentCount==0 &&
    $professorCount==0 &&
    $publicationCount==0
):
?>

<div class="card">

<h2>No Results Found</h2>

<p>

No results found for
<strong><?= htmlspecialchars($q) ?></strong>

</p>

</div>

<?php endif; ?>

<?php if($studentCount>0): ?>

<div class="card">

<h2>🎓 Students (<?= $studentCount ?>)</h2>

<?php


if($students && $students->num_rows){

while($row=$students->fetch_assoc()){

echo "<div class='item'>";

echo "<a href='student_details.php?id=".$row['id']."'>".highlight($row['full_name'],$q)."</a>";
echo "<br>";

echo highlight($row['major'],$q)." | ".$row['status'];
echo "</div>";

}

}else{

echo "No students found.";

}

?>

</div>
<?php endif; ?>
<?php if($professorCount>0): ?>

<div class="card">

<h2>👨‍🏫 Professors (<?= $professorCount ?>)</h2>

<?php

if($professors && $professors->num_rows){

while($row=$professors->fetch_assoc()){

echo "<div class='item'>";

echo "<a href='professor_details.php?id=".$row['id']."'>".highlight($row['name'],$q)."</a>";

echo "<br>";

echo highlight($row['field'],$q);

echo "</div>";

}

}else{

echo "No professors found.";

}

?>

</div>
<?php endif; ?>
<?php if($publicationCount>0): ?>
<div class="card">

<h2>📄 Publications (<?= $publicationCount ?>)</h2>

<?php

if($publications && $publications->num_rows){

    while($row = $publications->fetch_assoc()){

        echo "<div class='item'>";

        echo "<strong>".highlight($row['title'],$q)."</strong>";

        echo "<br>";

        echo highlight($row['authors'],$q);

        if(!empty($row['journal'])){
            echo "<br><small><b>Journal:</b> ".highlight($row['journal'],$q)."</small>";
        }

        echo "<br>";
        echo "(".$row['year'].")";

        echo "</div>";

    } // پایان while

}else{

    echo "No publications found.";

}

?>

</div>

<?php endif; ?>