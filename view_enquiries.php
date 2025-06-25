<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Management System</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="table.css"/> 
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
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
         
<?php
include 'connect.php';

$result = $conn->query("SELECT * FROM student_enquiries ORDER BY id DESC");

echo "<h1>Student Enquiries</h1>";
echo "<table border='1' cellpadding='5'>";
echo "<thead>";
echo "<tr>
<th>Sr.No.</th>
<th>Name</th>
<th>Email</th>
<th>Contact</th>
<th>Alt Contact</th>
<th>Address</th>
<th>College Name</th>
<th>Education</th>
<th>Other Education</th>
<th>Current Status</th>
<th>Company Name</th>
<th>Reference</th>
<th>Friend Name</th>
<th>DOB</th>
<th>Enquiry Date</th>
<th>Courses</th>
<th>Actions</th>
</tr>
<thead>";
while ($row = $result->fetch_assoc()) {
    echo " <tbody>";
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['student_name']."</td>";
    echo "<td>".$row['email']."</td>";
    echo "<td>".$row['contact_number']."</td>";
    echo "<td>".$row['alternate_number']."</td>"; // Alt Contact
    echo "<td>".$row['address']."</td>"; // Address
    echo "<td>".$row['college_name']."</td>"; // College Name
    echo "<td>".$row['education']."</td>"; // Education
    echo "<td>".$row['other_education']."</td>"; // Other Education
    echo "<td>".$row['current_status']."</td>"; // Current Status
    echo "<td>".$row['company_name']."</td>"; // Company Name
    echo "<td>".$row['reference']."</td>"; // Reference
    echo "<td>".$row['friend_name']."</td>"; // Friend Name
    echo "<td>".$row['dob']."</td>"; // DOB
    echo "<td>".$row['enquiry_date']."</td>"; // Enquiry Date
    echo "<td>".$row['courses']."</td>";
    echo "<td>
          
            <a href='register_student.php?id=".$row['id']."'>Register</a>
          </td>";
    echo "</tr>";
    echo " <tbody>";
}
echo "</table>";
// echo "<a href='enquiry_form.php'>Add New Enquiry</a>";
?>
 </main>
    </div>
  </body>
</html>
