<?php
session_start();
require_once("../includes/db.php");

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $full_name = trim($_POST['full_name']);
    $major = trim($_POST['major']);
    $status = $_POST['status'];
    $graduated = intval($_POST['graduated']);
    $email = trim($_POST['email']);
    $thesis_title = $_POST['thesis_title'];
    $research_interests = $_POST['research_interests'];
    $scholar_link = $_POST['scholar_link'];
    $professor_id = isset($_POST['professor_id']) ? intval($_POST['professor_id']) : null;

    $image_name = null;

    // آپلود عکس
    if(!empty($_FILES['image']['name'])){
        $allowed = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if(in_array($ext,$allowed)){
            if(!is_dir("../uploads")){
                mkdir("../uploads",0777,true);
            }

            $image_name = time()."_".rand(1000,9999).".".$ext;

            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                "../uploads/".$image_name
            );
        }
        else{
            $message = "Invalid image format.";
        }
    }

    // ذخیره در دیتابیس
    if(empty($message)){
$stmt = $conn->prepare("
INSERT INTO students
(full_name,email,major,status,graduated,thesis_title,research_interests,contact,scholar_link,photo,professor_id)
VALUES (?,?,?,?,?,?,?,?,?,?,?)
");

$stmt->bind_param(
    "ssssisssssi",
    $full_name,
    $email,
    $major,
    $status,
    $graduated,
    $thesis_title,
    $research_interests,
    $email,
    $scholar_link,
    $image_name,
    $professor_id
);
        if($stmt->execute()){
            $message = "Student added successfully!";
        }
        else{
            $message = "Database error: ".$stmt->error;
        }

        $stmt->close();
    }
}

$professors = $conn->query("SELECT * FROM professor ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Add Student</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<style>

body{
margin:0;
font-family:'Inter',sans-serif;
background:#f1f5f9;
}

.container{
max-width:800px;
margin:40px auto;
background:white;
padding:40px;
border-radius:15px;
box-shadow:0 8px 25px rgba(0,0,0,0.05);
}

h2{
margin-top:0;
color:#1e3a8a;
border-bottom:2px solid #f1f5f9;
padding-bottom:10px;
margin-bottom:25px;
}

label{
display:block;
margin-bottom:8px;
font-weight:600;
color:#475569;
}

input,select,textarea{
width:100%;
padding:12px;
margin-bottom:18px;
border:1px solid #e2e8f0;
border-radius:8px;
font-size:14px;
box-sizing:border-box;
}

button{
background:#1e3a8a;
color:white;
border:none;
padding:15px;
border-radius:8px;
cursor:pointer;
width:100%;
font-size:16px;
font-weight:600;
}

button:hover{
background:#1e40af;
}

.success{
color:#155724;
background:#d4edda;
padding:15px;
border-radius:8px;
margin-bottom:20px;
border:1px solid #c3e6cb;
}

.error{
color:#721c24;
background:#f8d7da;
padding:15px;
border-radius:8px;
margin-bottom:20px;
border:1px solid #f5c6cb;
}

</style>
</head>

<body>

<div class="container">

<h2>Add New Student</h2>

<?php if($message): ?>
<div class="<?= strpos($message,'successfully') !== false ? 'success':'error' ?>">
<?= htmlspecialchars($message) ?>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<label>Full Name</label>
<input type="text" name="full_name" required>

<label>Major</label>
<input type="text" name="major" required>

<label>Status</label>
<select name="status" required>
    <option value="">Select Status</option>
    <option value="MSc Student">MSc Student</option>
    <option value="PhD Student">PhD Student</option>
</select>

<label>Student Type</label>
<select name="graduated" required>
    <option value="0">Current Student</option>
    <option value="1">Graduated Student</option>
</select>
<label>Email</label>
<input type="email" name="email" required>

<label>Thesis Title</label>
<textarea name="thesis_title"></textarea>

<label>Research Interests</label>
<textarea name="research_interests"></textarea>

<label>Google Scholar</label>
<input type="url" name="scholar_link">

<label>Profile Image</label>
<input type="file" name="image">

<label>Supervisor</label>
<select name="professor_id" required>
<option value="">Select Professor</option>

<?php while($row = $professors->fetch_assoc()): ?>

<option value="<?= $row['id'] ?>">
<?= htmlspecialchars($row['name']) ?>
</option>

<?php endwhile; ?>

</select>

<button type="submit">Save Student</button>

</form>

</div>

</body>
</html>
