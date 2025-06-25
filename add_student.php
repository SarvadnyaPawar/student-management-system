<?php
// connect.php - your DB connection (create this file and include DB credentials)
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = $_POST['student_name'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $alternate_number = $_POST['alternate_number'];
    $address = $_POST['address'];
    $college_name = $_POST['college_name'];
    $education = $_POST['education'];
    $other_education = $_POST['other_education'] ?? NULL;
    $current_status = $_POST['current_status'];
    $company_name = $_POST['company_name'] ?? NULL;
    $reference = $_POST['reference'];
    $friend_name = $_POST['friend_name'] ?? NULL;
    $dob = $_POST['dob'];
    $enquiry_date = $_POST['enquiry_date'];
    $courses_array = isset($_POST['courses']) ? $_POST['courses'] : [];

    // Convert array to comma-separated string
    $courses_string = implode(', ', $courses_array);    $last_remark = $_POST['last_remark'];

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO student_enquiries (student_name, email, contact_number, alternate_number, address, college_name, education, other_education, current_status, company_name, reference, friend_name, dob, enquiry_date, courses, last_remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssss", $student_name, $email, $contact_number, $alternate_number, $address, $college_name, $education, $other_education, $current_status, $company_name, $reference, $friend_name, $dob, $enquiry_date, $courses_string, $last_remark);
    $stmt->execute();

    // echo "<p>Data saved successfully!</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Student Enquiry Form</title>
 <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="form.css" />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
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



window.onload = () => {
    toggleOtherEducation();
    toggleCompanyName();
    toggleFriendName();
    updateCoursesInput();
}
</script>
<!-- jQuery (must come first) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body>
        <div class="container">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div class="logo">
          <img src="cadd_centre_logo.svg" alt="CADD Centre" />
        </div>
        <nav class="nav-links">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
          <a href="add_student.php"><i class="fas fa-user-plus"></i> Add Student</a>
          <a href="view_enquiries.php"><i class="fas fa-users"></i>View Enquiry</a>
          <a href="view_registrations.php"><i class="fas fa-chart-bar"></i>View Registration</a>
           <a href="index.php"><i class="fas fa-cog"></i> Sign Out</a>
        </nav>
      </aside>

      <!-- Main Content -->
      <main class="content">
<h1>Student Enquiry Form</h1>
<br>
<form method="post" action="">
      <div class="form-row">
       <div class="form-group">
        <label>Student Name: <input type="text" name="student_name" required /></label></div>
         <div class="form-group">
    <label>Email ID: <input type="email" name="email" required /></label></div></div>
  
   <div class="form-row">
    <div class="form-group">
          <label>Contact Number: 
  <input type="text" name="contact_number" pattern="\d{10}" maxlength="10" required 
         title="Please enter exactly 10 digits" />
</label>
</div>
    <div class="form-group">
<label>Alternate Number: 
  <input type="text" name="alternate_number" pattern="\d{10}" maxlength="10" 
         title="Please enter exactly 10 digits" />
</label>
</div></div>
  <div class="form-row">
    <div class="form-group">
    <label>Address: <textarea name="address" required></textarea></label>
</div>
    <div class="form-group">
    <label>College Name: <input type="text" name="college_name" required /></label></div></div>
<div class="form-row">
    <div class="form-group">
    <label>Education:
        <select id="education" name="education" onchange="toggleOtherEducation()" required>
            <option value="">Select</option>
           <option value="Mechanical">Mechanical</option>
              <option value="Civil">Civil</option>
              <option value="Electrical">Electrical</option>
              <option value="Management">Management</option>
              <option value="Other">Other</option>
        </select>
    </label></div>

    <div class="form-group">
    <div id="otherEducationDiv" style="display:none;">
        <label>Other Education: <input type="text" name="other_education" /></label><br/>
    </div>
</div>
    <div class="form-group">
    <label>Current Status:
        <select id="current_status" name="current_status" onchange="toggleCompanyName()" required>
            <option value="">Select</option>
            <option value="Student">Student</option>
            <option value="Working">Working</option>
        </select>
    </label><br/>
</div><div class="form-group">
    <div id="companyNameDiv" style="display:none;">
        <label>Company Name: <input type="text" name="company_name" /></label>
    </div>
</div></div>
<div class="form-row">
    <div class="form-group">
    <label>Reference:
        <select id="reference" name="reference" onchange="toggleFriendName()" required>
            <option value="">Select</option>
            <option value="Online">Online</option>
            <option value="Walking">Walking</option>
            <option value="Friend">Friend</option>
        </select>
    </label> </div>
<div class="form-group">
    <div id="friendNameDiv" style="display:none;">
        <label>Friend Name: <input type="text" name="friend_name" /></label>
    </div> </div>
<div class="form-group">
    <label>Date of Birth: <input type="date" name="dob" required /></label> </div>
  <div class="form-group">  <label>Date of Enquiry: <input type="date" name="enquiry_date" required /></label> </div> </div>
<div class="form-row">
    <div class="form-group">
  <label>Course Apply For:</label>
  <select id="courses" name="courses[]" multiple="multiple" required >
     <option value="">-- Select Course --</option>
    <option value="AutoCad">AutoCad</option>
    <option value="AutoCad Electrical">AutoCad Electrical</option>
    <option value="AutoCAD Civil 3D">AutoCAD Civil 3D</option>
    <option value="Catia">Catia</option>
    <option value="CREO">CREO</option>
    <option value="Solidworks">Solidworks</option>
    <option value="Inventor">Inventor</option>
    <option value="NX-Cad">NX-Cad</option>
    <option value="Catia Kinematicks">Catia Kinematicks</option>
    <option value="Solidworks Motion">Solidworks Motion</option>
    <option value="Hypermesh">Hypermesh</option>
    <option value="Ansys (W.B)">Ansys (W.B)</option>
    <option value="Ansys Fluent">Ansys Fluent</option>
    <option value="ALIAS">ALIAS</option>
    <option value="Clay Modeling">Clay Modeling</option>
    <option value="Product Sketching">Product Sketching</option>
    <option value="Body In White (BIW)">Body In White (BIW)</option>
    <option value="Wire Harness">Wire Harness</option>
    <option value="Reverse Engineering">Reverse Engineering</option>
    <option value="Fusion 360">Fusion 360</option>
    <option value="ARC GIS">ARC GIS</option>
    <option value="Revit Architecture">Revit Architecture</option>
    <option value="Revit MEP">Revit MEP</option>
    <option value="Revit Structure">Revit Structure</option>
    <option value="Staad Pro">Staad Pro</option>
    <option value="E-Tabs">E-Tabs</option>
    <option value="Safe Foundation">Safe Foundation</option>
    <option value="Tekla">Tekla</option>
    <option value="Navisworks">Navisworks</option>
    <option value="MS Project">MS Project</option>
    <option value="Primavera">Primavera</option>
    <option value="RCC Design using RCDC">RCC Design using RCDC</option>
    <option value="3DsMax">3DsMax</option>
    <option value="Google Sketchup">Google Sketchup</option>
    <option value="Vray">Vray</option>
    <option value="Lumion">Lumion</option>
    <option value="Matlab">Matlab</option>
    <option value="Power Bi">Power Bi</option>
    <option value="Tableau">Tableau</option>
    <option value="C">C</option>
    <option value="C++">C++</option>
    <option value="Core Java">Core Java</option>
    <option value="Advance Java">Advance Java</option>
    <option value="Python">Python</option>
    <option value="MERN">MERN</option>
  </select>
 <script>
    $(document).ready(function() {
        $('#courses').select2({
            placeholder: "Select courses",
            allowClear: true,
            width: '100%'
        });
    });
    </script>

</div>
    <div class="form-group">

    <label>Remark: <input type="text" name="last_remark"></label></div></div>

    <button type="submit">Submit</button>

   
</form>

 </main>
    </div>
</body>
</html>



