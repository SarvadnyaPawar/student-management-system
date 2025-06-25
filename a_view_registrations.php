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
<?php
include 'connect.php';

$sql = "SELECT r.*, s.student_name, s.contact_number 
        FROM registrations r
        JOIN student_enquiries s ON r.student_id = s.id";
$result = $conn->query($sql);

echo "<h1>All Registered Students</h1>";
echo "<table border='1' cellpadding='5'>
<thead>
<tr>
    <th>ID</th>
    <th>Student Name</th>
    <th>Contact</th>
    <th>Class Type</th>
    <th>Branch</th>
    <th>Class Time</th>
    <th>Software1</th>
        <th>Software2</th>
        <th>Software3</th>
        <th>Software4</th>
        <th>Software5</th>
        <th>Software6</th>
        <th>Software7</th>
        <th>Software8</th>
    <th>Total Payment</th>
    <th>Paid</th>
    <th>Pending</th>
     <th>Remark</th>
    <th>Actions</th>
</tr>
<thead>";

while ($row = $result->fetch_assoc()) {
     echo " <tbody>";
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['student_name']}</td>
        <td>{$row['contact_number']}</td>
        <td>{$row['class_type']}</td>
        <td>{$row['branch']}</td>
        <td>{$row['class_time']}</td>
        <td>{$row['software1']}</td>
        <td>{$row['software2']}</td>
        <td>{$row['software3']}</td>
        <td>{$row['software4']}</td>
        <td>{$row['software5']}</td>
        <td>{$row['software6']}</td>
        <td>{$row['software7']}</td>
        <td>{$row['software8']}</td>
        <td>{$row['total_payment']}</td>
        <td>{$row['total_paid_payment']}</td>
        <td>{$row['total_pending_payment']}</td>
         <td>{$row['remark']}</td>
        <td>
            <a href='a_edit_registration.php?id={$row['id']}'>Edit</a> | 
            <a href='a_delete_registration.php?id={$row['id']}' onclick=\"return confirm('Are you sure?')\">Delete</a>
        </td>
    </tr>";
     " <tbody>";
}
echo "</table>";
?>
   </main>  </body>
</html>
