<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM registrations WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

 // Fetch associated payments
$stmt_payments = $conn->prepare("SELECT * FROM payments WHERE registration_id=?");
$stmt_payments->bind_param("i", $id);
$stmt_payments->execute();
$payments_result = $stmt_payments->get_result();
$payments = [];
while ($payment = $payments_result->fetch_assoc()) {
    $payments[] = $payment;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
          <a href="add_student.php"><i class="fas fa-user-plus"></i> Add Student</a>
          <a href="view_enquiries.php"><i class="fas fa-users"></i>View Enquiry</a>
          <a href="view_registrations.php"><i class="fas fa-chart-bar"></i>View Registration</a>
           <a href="index.php"><i class="fas fa-cog"></i> Sign Out</a>
        </nav>
      </aside>

      <!-- Main Content -->
      <main class="content">
<h1>Edit Registration </h1>
<form action="edit_registration.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
   <div class="form-row">
  <div class="form-group">
 <!-- Class Type -->
    <label for="class_type">Class Type:</label>
    <select name="class_type" id="class_type" >
        <option value="">-- Select Class Type --</option>
        <option value="Online" <?php if ($row['class_type'] == 'Online') echo 'selected'; ?>>Online</option>
        <option value="Hybrid" <?php if ($row['class_type'] == 'Hybrid') echo 'selected'; ?>>Hybrid</option>
    </select>
  
</div><div class="form-group">
    <!-- Branch -->
    <label for="branch">Branch:</label>
    <select name="branch" id="branch" >
        <option value="">-- Select Branch --</option>
        <option value="Kothrud" <?php if ($row['branch'] == 'Kothrud') echo 'selected'; ?>>Kothrud</option>
        <option value="Bundgarden" <?php if ($row['branch'] == 'Bundgarden') echo 'selected'; ?>>Bundgarden</option>
    </select>
   </div><div class="form-group">

    <!-- Class Time -->
    <label for="class_time">Class Time:</label>
    <input type="time" name="class_time" id="class_time" value="<?php echo $row['class_time']; ?>" >
   </div></div>

    <!-- Course -->
         <div class="form-row">
    <?php 
    $softwareOptions = [
        "Select", "AutoCad", "AutoCad Electrical", "AutoCAD Civil 3D", "Catia", "CREO", "Solidworks", "Inventor",
        "NX-Cad", "Catia Kinematicks", "Solidworks Motion", "Hypermesh", "Ansys (W.B)", "Ansys Fluent", "ALIAS",
        "Clay Modeling", "Product Sketching", "Body In White (BIW)", "Wire Harness", "Reverse Engineering", "Fusion 360",
        "ARC GIS", "Revit Architecture", "Revit MEP", "Revit Structure", "Staad Pro", "E-Tabs", "Safe Foundation", "Tekla",
        "Navisworks", "MS Project", "Primavera", "RCC Design using RCDC", "3DsMax", "Google Sketchup", "Vray", "Lumion",
        "Matlab", "Power Bi", "Tableau", "C", "C++", "Core Java", "Advance Java", "Python"
    ];

    for ($i = 1; $i <= 8; $i++): 
    ?>
         <div class="form-row">
 
            <label for="software<?= $i ?>">Software<?= $i ?></label>
            <select id="software<?= $i ?>" name="software<?= $i ?>" class="form-control">
                <?php foreach ($softwareOptions as $option): ?>
                    <option value="<?= htmlspecialchars($option) ?>" 
                        <?= $row["software$i"] == $option ? 'selected' : '' ?>>
                        <?= htmlspecialchars($option) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endfor; ?>
</div>

              

    <!-- Payment Information -->
  
    <h3>Payment Information</h3>
        <div class="form-row">
  <div class="form-group">
    <label for="total_payment">Total Payment:</label>
    <input type="number" name="total_payment" id="total_payment" value="<?php echo $row['total_payment']; ?>" readonly>
                </div>
 <div class="form-group">
      <div>
    <div class="form-row">
  <div class="col-md-1">
    <label>I</label>
  </div>
   <div class="form-group">
    <input type="text" name="amount1" class="form-control" placeholder="Enter Amount" value="<?php echo $row['amount1'] ?>">
  </div>
   <div class="form-group">
    <input type="date" name="duedate1" class="form-control" value="<?php echo $row['duedate1'] ?>">
  </div>
</div>

 <div class="form-row">
  <div class="col-md-1">
    <label>II</label>
  </div>
   <div class="form-group">
    <input type="text" name="amount2" class="form-control" placeholder="Enter Amount" value="<?php echo $row['amount2']?>">
  </div>
   <div class="form-group">
    <input type="date" name="duedate2" class="form-control" value="<?php echo $row['duedate2'] ?>">
  </div>
</div>

 <div class="form-row">
  <div class="col-md-1">
    <label>III</label>
  </div>
   <div class="form-group">
    <input type="text" name="amount3" class="form-control" placeholder="Enter Amount" value="<?php echo $row['amount3'] ?>">
  </div>
   <div class="form-group">
    <input type="date" name="duedate3" class="form-control" value="<?php echo $row['duedate3'] ?>">
  </div>
</div>

 <div class="form-row">
  <div class="col-md-1">
    <label>IV</label>
  </div>
   <div class="form-group">
    <input type="text" name="amount4" class="form-control" placeholder="Enter Amount" value="<?php echo $row['amount4'] ?>">
  </div>
   <div class="form-group">
    <input type="date" name="duedate4" class="form-control" value="<?php echo $row['duedate4'] ?>">
  </div>
</div>

 <div class="form-row">
  <div class="col-md-1">
    <label>V</label>
  </div>
   <div class="form-group">
    <input type="text" name="amount5" class="form-control" placeholder="Enter Amount" value="<?php echo $row['amount5'] ?>">
  </div>
   <div class="form-group">
    <input type="date" name="duedate5" class="form-control" value="<?php echo $row['duedate5'] ?>">
  </div>
  
  </div>
</div>
      </div>
    <!-- <div class="form-group">
   
   
      </div>-->
    </div> 



  

    <!-- Payments -->
    <div id="payments">
        <?php
        if (count($payments) > 0) {
            foreach ($payments as $payment) {
                ?>
                <div class="payment-row">
                   <div class="form-row">
  <div class="form-group">
                    <label>Paid Amount:</label>
                    <input type="number" name="paid_amount[]" class="paid-amount" value="<?php echo $payment['paid_amount']; ?>">
                   </div>  <div class="form-group"> <label>Date of Payment:</label>
                    <input type="date" name="payment_date[]" value="<?php echo $payment['payment_date']; ?>" >
                    </div> <div class="form-group"> <label>Mode of Payment:</label>
                    <select name="payment_mode[]" >
                        <option value="">-- Select Mode --</option>
                        <option value="Cash" <?php if ($payment['payment_mode'] == 'Cash') echo 'selected'; ?>>Cash</option>
                        <option value="UPI" <?php if ($payment['payment_mode'] == 'UPI') echo 'selected'; ?>>UPI</option>
                    </select>
                   </div></div>
                </div>
            <?php
            }
        } else {
            // At least one empty row
            ?>
            <div class="payment-row">
               <div class="form-row">
  <div class="form-group">
                <label>Paid Amount:</label>
                <input type="number" name="paid_amount[]" class="paid-amount" value="0" >
                </div> <div class="form-group"> <label>Date of Payment:</label>
                <input type="date" name="payment_date[]" >
                 </div> <div class="form-group"><label>Mode of Payment:</label>
                <select name="payment_mode[]" >
                    <option value="">-- Select Mode --</option>
                    <option value="Cash">Cash</option>
                    <option value="UPI">UPI</option>
                </select>
               </div></div>
            </div>
            <?php
        }
        ?>
    </div>
   

    <button type="button" onclick="addPayment()">Add Another Payment</button>
   <div class="form-row">
  <div class="form-group">
    <label for="total_paid_payment">Total Paid Payment:</label>
    <input type="number" name="total_paid_payment" id="total_paid_payment" value="<?php echo $row['total_paid_payment']; ?>" readonly>
    </div> <div class="form-group">

    <label for="total_pending_payment">Total Pending Payment:</label>
    <input type="number" name="total_pending_payment" id="total_pending_payment" value="<?php echo $row['total_pending_payment']; ?>" readonly>
   </div></div>
 <label>Remark:
  <textarea name="remark"><?php echo htmlspecialchars($row['remark']); ?></textarea>
</label><br/>
    <button type="submit">Update Registration</button>

</form>

<script>
function addPayment() {
    const paymentsDiv = document.getElementById('payments');
    const newPayment = document.createElement('div');
    newPayment.classList.add('payment-row');
    newPayment.innerHTML = `
        <div class="form-row">
  <div class="form-group">
        <label>Paid Amount:</label>
        <input type="number" name="paid_amount[]" class="paid-amount" value="0" >
       </div> <div class="form-group"> <label>Date of Payment:</label>
        <input type="date" name="payment_date[]" >
        </div> <div class="form-group"><label>Mode of Payment:</label>
        <select name="payment_mode[]" >
            <option value="">-- Select Mode --</option>
            <option value="Cash">Cash</option>
            <option value="UPI">UPI</option>
        </select>
       </div></div>
    `;
    paymentsDiv.appendChild(newPayment);
    attachAmountListeners();
}

function attachAmountListeners() {
    const paidInputs = document.querySelectorAll('.paid-amount');
    paidInputs.forEach(input => {
        input.removeEventListener('input', updateTotals);
        input.addEventListener('input', updateTotals);
    });
}

function updateTotals() {
    const totalPayment = parseFloat(document.getElementById('total_payment').value) || 0;
    const paidInputs = document.querySelectorAll('.paid-amount');
    let totalPaid = 0;
    paidInputs.forEach(input => {
        totalPaid += parseFloat(input.value) || 0;
    });
    document.getElementById('total_paid_payment').value = totalPaid;
    document.getElementById('total_pending_payment').value = totalPayment - totalPaid;
}

attachAmountListeners();
document.getElementById('total_payment').addEventListener('input', updateTotals);
</script>

<?php
} else {
    // Handle form submission
    $id = $_POST['id'];
    $class_type = $_POST['class_type'];
    $branch = $_POST['branch'];
    $class_time = $_POST['class_time'];
    $software1 = $_POST['software1'];
    $software2 = $_POST['software2'];
    $software3 = $_POST['software3'];
    $software4 = $_POST['software4'];
    $software5 = $_POST['software5'];
    $software6 = $_POST['software6'];
    $software7 = $_POST['software7'];
    $software8 = $_POST['software8'];
    $total_payment = $_POST['total_payment'];
    $total_paid_payment = $_POST['total_paid_payment'];
    $total_pending_payment = $_POST['total_pending_payment'];
$remark = $_POST['remark'];
$amount1 = $_POST['amount1'];$amount2 = $_POST['amount2'];
$amount3 = $_POST['amount3'];$amount4 = $_POST['amount4'];
$amount5 = $_POST['amount5']; $duedate1 = $_POST['duedate1'];
$duedate2 = $_POST['duedate2']; $duedate3 = $_POST['duedate3'];
$duedate4 = $_POST['duedate4']; $duedate5 = $_POST['duedate5'];
    // Update registration table
    $stmt = $conn->prepare("UPDATE registrations SET class_type=?, branch=?, class_time=?,software1=?, software2=?, software3=?, software4=?, software5=?, software6=?, software7=?, software8=?,  total_payment=?, total_paid_payment=?, total_pending_payment=?,amount1=?,amount2=?,amount3=?,amount4=?,amount5=?,duedate1=?,duedate2=?,duedate3=?,duedate4=?,duedate5=?,remark=? WHERE id=?");
$stmt->bind_param("sssssssssssddddddddssssssi", 
    $class_type, $branch, $class_time,
    $software1, $software2, $software3, $software4, $software5, $software6, $software7, $software8,
    $total_payment, $total_paid_payment, $total_pending_payment,
    $amount1, $amount2, $amount3, $amount4, $amount5,
    $duedate1, $duedate2, $duedate3, $duedate4, $duedate5,
    $remark, $id
);

    $stmt->execute();

    // Delete old payments (or alternatively update them)
    $stmt_delete = $conn->prepare("DELETE FROM payments WHERE registration_id=?");
    $stmt_delete->bind_param("i", $id);
    $stmt_delete->execute();

    // Insert updated payments
    if (!empty($_POST['paid_amount'])) {
        foreach ($_POST['paid_amount'] as $index => $paid_amount) {
            $date = $_POST['payment_date'][$index];
            $mode = $_POST['payment_mode'][$index];
            $stmt_payment = $conn->prepare("INSERT INTO payments (registration_id, paid_amount, payment_date, payment_mode) VALUES (?, ?, ?, ?)");
            $stmt_payment->bind_param("idss", $id, $paid_amount, $date, $mode);
            $stmt_payment->execute();
        }
    }

    header("Location: view_registrations.php");
    exit();
}
?>
  </main>  </body>
</html>
