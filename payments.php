<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your password
$dbname = "project"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch filter values
$month = isset($_GET['month']) ? $_GET['month'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : '';
$payment_mode = isset($_GET['payment_mode']) ? $_GET['payment_mode'] : '';

// Build SQL query
$sql = "SELECT p.*, r.total_payment, s.student_name 
        FROM payments p
        LEFT JOIN registrations r ON p.registration_id = r.id
        LEFT JOIN student_enquiries s ON r.student_id = s.id";


$conditions = [];
if (!empty($month) && !empty($year)) {
    $conditions[] = "MONTH(p.payment_date) = '$month' AND YEAR(p.payment_date) = '$year'";
}
if (!empty($payment_mode)) {
    $conditions[] = "p.payment_mode = '$payment_mode'";
}
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY p.id DESC";

$result = $conn->query($sql);

// Calculate totals
$total_paid = 0;
$total_payment = 0;
$total_pending = 0;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
       <link rel="stylesheet" href="table.css"/> 
          <link rel="stylesheet" href="form.css"/>
    <link rel="stylesheet" href="style.css" />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
 

    <title>Payments Table</title>
    <style>
        /* table {
            border-collapse: collapse;
             width: 90%;
            margin: 20px auto; 
        } */
     td {
            border: 1px solid #000;
            /* padding: 8px;
            text-align: center; */
        }
       
        /* h2 {
            text-align: center;
        }*/
        /* form {
            text-align: center;
            margin: 20px;
        }  */
    </style>

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
<h1>Payments Table</h1>
<br>
<form method="get" action="">
    <div class="form-row">
       <div class="form-group">
    <label for="month">Month:</label>
    <select name="month" id="month">
        <option value="">--Select Month--</option>
        <?php for ($m = 1; $m <= 12; $m++): ?>
            <option value="<?= sprintf('%02d', $m) ?>" <?= ($month == sprintf('%02d', $m)) ? 'selected' : '' ?>>
                <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
            </option>
        <?php endfor; ?>
    </select></div>
 <div class="form-group">
    <label for="year">Year:</label>
    <select name="year" id="year">
        <option value="">--Select Year--</option>
        <?php for ($y = 2020; $y <= date('Y'); $y++): ?>
            <option value="<?= $y ?>" <?= ($year == $y) ? 'selected' : '' ?>><?= $y ?></option>
        <?php endfor; ?>
    </select></div>
 <div class="form-group">
    <label for="payment_mode">Payment Mode:</label>
    <select name="payment_mode" id="payment_mode">
        <option value="">All</option>
        
        <option value="Cash" <?= ($payment_mode == 'Cash') ? 'selected' : '' ?>>Cash</option>
        <option value="UPI" <?= ($payment_mode == 'UPI') ? 'selected' : '' ?>>UPI</option>
    </select></div>
 <div class="form-group">
    <input type="submit" value="Filter">
        </div></div>
</form>

<table>
    <thead>
    <tr>
        <!-- <th>ID</th> -->
        <th>Registration ID</th>
        <th>Student Name</th>
        <th>Paid Amount</th>
        <th>Payment Date</th>
        <th>Payment Mode</th>
        <th>Total Payment (Expected)</th>
        <th>Pending Amount</th>
    </tr>  </thead>
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pending = $row["total_payment"] - $row["paid_amount"];
            $total_paid += $row["paid_amount"];
            $total_payment += $row["total_payment"];
            $total_pending += $pending;
           echo " <tbody>";
            echo "<tr>";
            // echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["registration_id"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["student_name"]) . "</td>";
            echo "<td>" . htmlspecialchars(number_format($row["paid_amount"], 2)) . "</td>";
            echo "<td>" . htmlspecialchars($row["payment_date"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["payment_mode"]) . "</td>";
            echo "<td>" . htmlspecialchars(number_format($row["total_payment"], 2)) . "</td>";
            echo "<td>" . htmlspecialchars(number_format($pending, 2)) . "</td>";
            echo "</tr>";
            echo " </tbody>";
        }

        // Display totals row
         echo " <tbody>";
        echo "<tr style='font-weight:bold; background-color:#f2f2f2;'>";
        echo "<td colspan='2'>TOTAL</td>";
        echo "<td>" . number_format($total_paid, 2) . "</td>";
        echo "<td colspan='2'></td>";
        echo "<td>" . number_format($total_payment, 2) . "</td>";
        echo "<td>" . number_format($total_pending, 2) . "</td>";
        echo "</tr>";
    } else {
        echo "<tr><td colspan='7'>No payments found.</td></tr>";
        echo "</tbody>";
    }
    ?>
</table>
   </main>  </body>
</html>


<?php
$conn->close();
?>
