<?php
include 'connect.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = $_POST['student_name'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $alternate_number = $_POST['alternate_number'];
    $address = $_POST['address'];
    $college_name = $_POST['college_name'];
    $education = $_POST['education'];
    $other_education = $_POST['other_education'];
    $current_status = $_POST['current_status'];
    $company_name = $_POST['company_name'];
    $reference = $_POST['reference'];
    $friend_name = $_POST['friend_name'];
    $dob = $_POST['dob'];
    $enquiry_date = $_POST['enquiry_date'];
    $courses = isset($_POST['courses']) ? implode(',', $_POST['courses']) : '';
    $last_remark = $_POST['last_remark'];

    $stmt = $conn->prepare("UPDATE student_enquiries SET student_name=?, email=?, contact_number=?, alternate_number=?, address=?, college_name=?, education=?, other_education=?, current_status=?, company_name=?, reference=?, friend_name=?, dob=?, enquiry_date=?, courses=?, last_remark=? WHERE id=?");
    $stmt->bind_param("ssssssssssssssssi", $student_name, $email, $contact_number, $alternate_number, $address, $college_name, $education, $other_education, $current_status, $company_name, $reference, $friend_name, $dob, $enquiry_date, $courses, $last_remark, $id);
    $stmt->execute();

    echo "<p>Data updated successfully!</p>";
    // echo "<a href='a_view_enquiries.php'>Back to List</a>";
    header("Location: a_view_enquiries.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM student_enquiries WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$courses_array = explode(',', $row['courses']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- jQuery (must come first) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

 
   
    <title>Student Management System</title>
    <link rel="stylesheet" href="style.css" />
      <link rel="stylesheet" href="form.css" />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
  </head>
  <body>
   
      <!-- Sidebar -->
      <aside class="sidebar">
        <div class="logo">
          <img src="cadd_centre_logo.svg" alt="CADD Centre" />
        </div>
       <nav class="nav-links">
         <a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
          <a href="a_view_enquiries.php"><i class="fas fa-users"></i>View Enquiry</a>
           <a href="payments.php"><i class="fas fa-user-plus"></i> Payments</a>
          <a href="a_view_registrations.php"><i class="fas fa-chart-bar"></i>View Registration</a>
          <a href="index.php"><i class="fas fa-cog"></i> Sign Out</a>
        </nav>
      </aside>

      <!-- Main Content -->
      <main class="content">

<h1>Edit Student Enquiry</h1>
<form method="post">
       <div class="form-row">
       <div class="form-group">
    <label>Student Name:
        <input type="text" name="student_name" value="<?= htmlspecialchars($row['student_name']) ?>" required>
    </label> </div> 
    <div class="form-group">

    <label>Email ID:
        <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>
    </label> </div></div>
      <div class="form-row"> <div class="form-group">

    <label>Contact Number:
        <input type="text" name="contact_number" pattern="\d{10}" maxlength="10" value="<?= htmlspecialchars($row['contact_number']) ?>" required>
    </label></div> 
    <div class="form-group">

    <label>Alternate Number:
        <input type="text" name="alternate_number" pattern="\d{10}" maxlength="10" value="<?= htmlspecialchars($row['alternate_number']) ?>">
    </label></div> </div> 

     <div class="form-row">
       <div class="form-group">
    <label>Address:
        <textarea name="address" required><?= htmlspecialchars($row['address']) ?></textarea>
    </label>
</div>
       <div class="form-group">
    <label>College Name:
        <input type="text" name="college_name" value="<?= htmlspecialchars($row['college_name']) ?>" required>
    </label>
    </div> </div> 

     <div class="form-row">
    <div class="form-group">

    <label>Education:
        <select id="education" name="education" onchange="toggleOtherEducation()" required>
            <option value="">Select</option>
            <option value="Mechanical"  <?= ($row['education'] === 'Mechanical') ? 'selected' : '' ?>>Mechanical</option>
            <option value="Civil" <?= ($row['education'] === 'Civil') ? 'selected' : '' ?>>Civil</option>
            <option value="Electrical"  <?= ($row['education'] === 'Electrical') ? 'selected' : '' ?>>Electrical</option>
            <option value="Management"  <?= ($row['education'] === 'Management') ? 'selected' : '' ?>>Management</option>
            <option value="Other" <?= ($row['education'] === 'Other') ? 'selected' : '' ?>>Other</option>
        </select>
    </label></div>
       <div class="form-group">

    <div id="otherEducationDiv" style="<?= ($row['education'] === 'Other') ? 'display:block;' : 'display:none;' ?>">
        <label>Other Education:
            <input type="text" name="other_education" value="<?= htmlspecialchars($row['other_education']) ?>">
        </label></div>
</div>
    </div>
   <div class="form-row">
    <div class="form-group">
    <label>Current Status:
        <select id="current_status" name="current_status" onchange="toggleCompanyName()" required>
            <option value="">Select</option>
            <option value="Student" <?= ($row['current_status'] === 'Student') ? 'selected' : '' ?>>Student</option>
            <option value="Working" <?= ($row['current_status'] === 'Working') ? 'selected' : '' ?>>Working</option>
        </select>
    </label></div>
       <div class="form-group">

    <div id="companyNameDiv" style="<?= ($row['current_status'] === 'Working') ? 'display:block;' : 'display:none;' ?>">
        <label>Company Name:
            <input type="text" name="company_name" value="<?= htmlspecialchars($row['company_name']) ?>">
        </label></div>
    </div>
    </div>
<div class="form-row">
    <div class="form-group">
    <label>Reference:
        <select id="reference" name="reference" onchange="toggleFriendName()" required>
            <option value="">Select</option>
            <option value="Online" <?= ($row['reference'] === 'Online') ? 'selected' : '' ?>>Online</option>
            <option value="Walking" <?= ($row['reference'] === 'Walking') ? 'selected' : '' ?>>Walking</option>
            <option value="Friend" <?= ($row['reference'] === 'Friend') ? 'selected' : '' ?>>Friend</option>
        </select>
    </label>
   </div>

    <div class="form-group">
    <div id="friendNameDiv" style="<?= ($row['reference'] === 'Friend') ? 'display:block;' : 'display:none;' ?>">
        <label>Friend Name:
            <input type="text" name="friend_name" value="<?= htmlspecialchars($row['friend_name']) ?>">
        </label> </div> </div>
    </div>
<div class="form-row">
    <div class="form-group">
    <label>Date of Birth:
        <input type="date" name="dob" value="<?= htmlspecialchars($row['dob']) ?>" required>
    </label> </div> <div class="form-group">

    <label>Date of Enquiry:
        <input type="date" name="enquiry_date" value="<?= htmlspecialchars($row['enquiry_date']) ?>" required>
    </label> </div> </div>
<div class="form-row">
    <div class="form-group">
 <label>Course Apply For:</label>
 <select name="courses[]" multiple id="courses">
        
<option value="AutoCad" <?= in_array('AutoCad', $courses_array) ? 'selected' : '' ?>>AutoCad</option>
<option value="AutoCad Electrical" <?= in_array('AutoCad Electrical', $courses_array) ? 'selected' : '' ?>>AutoCad Electrical</option>
<option value="AutoCAD Civil 3D" <?= in_array('AutoCAD Civil 3D', $courses_array) ? 'selected' : '' ?>>AutoCAD Civil 3D</option>
<option value="Catia" <?= in_array('Catia', $courses_array) ? 'selected' : '' ?>>Catia</option>
<option value="CREO" <?= in_array('CREO', $courses_array) ? 'selected' : '' ?>>CREO</option>
<option value="Solidworks" <?= in_array('Solidworks', $courses_array) ? 'selected' : '' ?>>Solidworks</option>
<option value="Inventor" <?= in_array('Inventor', $courses_array) ? 'selected' : '' ?>>Inventor</option>
<option value="NX-Cad" <?= in_array('NX-Cad', $courses_array) ? 'selected' : '' ?>>NX-Cad</option>
<option value="Catia Kinematicks" <?= in_array('Catia Kinematicks', $courses_array) ? 'selected' : '' ?>>Catia Kinematicks</option>
<option value="Solidworks Motion" <?= in_array('Solidworks Motion', $courses_array) ? 'selected' : '' ?>>Solidworks Motion</option>
<option value="Hypermesh" <?= in_array('Hypermesh', $courses_array) ? 'selected' : '' ?>>Hypermesh</option>
<option value="Ansys (W.B)" <?= in_array('Ansys (W.B)', $courses_array) ? 'selected' : '' ?>>Ansys (W.B)</option>
<option value="Ansys Fluent" <?= in_array('Ansys Fluent', $courses_array) ? 'selected' : '' ?>>Ansys Fluent</option>
<option value="ALIAS" <?= in_array('ALIAS', $courses_array) ? 'selected' : '' ?>>ALIAS</option>
<option value="Clay Modeling" <?= in_array('Clay Modeling', $courses_array) ? 'selected' : '' ?>>Clay Modeling</option>
<option value="Product Sketching" <?= in_array('Product Sketching', $courses_array) ? 'selected' : '' ?>>Product Sketching</option>
<option value="Body In White (BIW)" <?= in_array('Body In White (BIW)', $courses_array) ? 'selected' : '' ?>>Body In White (BIW)</option>
<option value="Wire Harness" <?= in_array('Wire Harness', $courses_array) ? 'selected' : '' ?>>Wire Harness</option>
<option value="Reverse Engineering" <?= in_array('Reverse Engineering', $courses_array) ? 'selected' : '' ?>>Reverse Engineering</option>
<option value="Fusion 360" <?= in_array('Fusion 360', $courses_array) ? 'selected' : '' ?>>Fusion 360</option>
<option value="ARC GIS" <?= in_array('ARC GIS', $courses_array) ? 'selected' : '' ?>>ARC GIS</option>
<option value="Revit Architecture" <?= in_array('Revit Architecture', $courses_array) ? 'selected' : '' ?>>Revit Architecture</option>
<option value="Revit MEP" <?= in_array('Revit MEP', $courses_array) ? 'selected' : '' ?>>Revit MEP</option>
<option value="Revit Structure" <?= in_array('Revit Structure', $courses_array) ? 'selected' : '' ?>>Revit Structure</option>
<option value="Staad Pro" <?= in_array('Staad Pro', $courses_array) ? 'selected' : '' ?>>Staad Pro</option>
<option value="E-Tabs" <?= in_array('E-Tabs', $courses_array) ? 'selected' : '' ?>>E-Tabs</option>
<option value="Safe Foundation" <?= in_array('Safe Foundation', $courses_array) ? 'selected' : '' ?>>Safe Foundation</option>
<option value="Tekla" <?= in_array('Tekla', $courses_array) ? 'selected' : '' ?>>Tekla</option>
<option value="Navisworks" <?= in_array('Navisworks', $courses_array) ? 'selected' : '' ?>>Navisworks</option>
<option value="MS Project" <?= in_array('MS Project', $courses_array) ? 'selected' : '' ?>>MS Project</option>
<option value="Primavera" <?= in_array('Primavera', $courses_array) ? 'selected' : '' ?>>Primavera</option>
<option value="RCC Design using RCDC" <?= in_array('RCC Design using RCDC', $courses_array) ? 'selected' : '' ?>>RCC Design using RCDC</option>
<option value="3DsMax" <?= in_array('3DsMax', $courses_array) ? 'selected' : '' ?>>3DsMax</option>
<option value="Google Sketchup" <?= in_array('Google Sketchup', $courses_array) ? 'selected' : '' ?>>Google Sketchup</option>
<option value="Vray" <?= in_array('Vray', $courses_array) ? 'selected' : '' ?>>Vray</option>
<option value="Lumion" <?= in_array('Lumion', $courses_array) ? 'selected' : '' ?>>Lumion</option>
<option value="Matlab" <?= in_array('Matlab', $courses_array) ? 'selected' : '' ?>>Matlab</option>
<option value="Power Bi" <?= in_array('Power Bi', $courses_array) ? 'selected' : '' ?>>Power Bi</option>
<option value="Tableau" <?= in_array('Tableau', $courses_array) ? 'selected' : '' ?>>Tableau</option>
<option value="C" <?= in_array('C', $courses_array) ? 'selected' : '' ?>>C</option>
<option value="C++" <?= in_array('C++', $courses_array) ? 'selected' : '' ?>>C++</option>
<option value="Core Java" <?= in_array('Core Java', $courses_array) ? 'selected' : '' ?>>Core Java</option>
<option value="Advance Java" <?= in_array('Advance Java', $courses_array) ? 'selected' : '' ?>>Advance Java</option>
<option value="Python" <?= in_array('Python', $courses_array) ? 'selected' : '' ?>>Python</option>
<option value="MERN" <?= in_array('MERN', $courses_array) ? 'selected' : '' ?>>MERN</option>

    </select>
     <script>
    $(document).ready(function() {
        $('#courses').select2({
            placeholder: "Select courses",
            allowClear: true,
            width: '300px'
        });
    });
    </script>
</div>
    <div class="form-group">
 

    <label>Last Remark:
        <textarea name="last_remark"><?= htmlspecialchars($row['last_remark']) ?></textarea>
    </label></div></div>

    <button type="submit">Update</button>
</form>

<script>
function toggleOtherEducation() {
    const education = document.getElementById('education').value;
    document.getElementById('otherEducationDiv').style.display = education === 'Other' ? 'block' : 'none';
}

function toggleCompanyName() {
    const status = document.getElementById('current_status').value;
    document.getElementById('companyNameDiv').style.display = status === 'Working' ? 'block' : 'none';
}

function toggleFriendName() {
    const ref = document.getElementById('reference').value;
    document.getElementById('friendNameDiv').style.display = ref === 'Friend' ? 'block' : 'none';
}

$(document).ready(function() {
    $('#courses').select2({
        placeholder: "Select courses",
        allowClear: true,
        width: '100%'
    });
});
</script> 

</body>
</html>
