<?php
include 'connect.php';
$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM student_enquiries WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

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
        <h1>Registration Form</h1>
        <?php
include 'connect.php';
$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM student_enquiries WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo "<h2>Register Student: {$row['student_name']}</h2>";
echo "<p>Contact: {$row['contact_number']}</p>";
?>

<form action="submit_registration.php" method="POST">
    <!-- Hidden ID -->
    <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($row['id']); ?>">
 <div class="form-row">
       <div class="form-group">
    <!-- Class Type -->
    <label for="class_type">Class Type:</label>
    <select name="class_type" id="class_type" required>
        <option value="">-- Select Class Type --</option>
        <option value="Online">Online</option>
        <option value="Hybrid">Hybrid</option>
    </select>
</div>
       <div class="form-group">
    <!-- Branch -->
    <label for="branch">Branch:</label>
    <select name="branch" id="branch" required>
        <option value="">-- Select Branch --</option>
        <option value="Kothrud">Kothrud</option>
        <option value="Bundgarden">Bundgarden</option>
    </select></div>
  
       <div class="form-group">

    <!-- Class Time -->
    <label for="class_time">Class Time:</label>
    <input type="time" name="class_time" id="class_time" required>
  </div></div>

    <!-- Course -->
   
<div class="form-row">
      

      <?php for ($i = 1; $i <= 8; $i++): ?>

       <div class="form-group">
        <label>Software Name <?= $i ?>:</label>
        <select name="software_name<?= $i ?>" class="form-control">
         
            <option value="Select">Select</option>
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
                <option value="RCC Design using RCDC">
                  RCC Design using RCDC
                </option>
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
      </div>
      <?php endfor; ?>
    </div>

    <br><br>

    <!-- Payment Information -->
    <h3>Payment Information</h3>
    <div class="form-row">
  <div class="form-group">
    <label for="total_payment">Total Payment:</label>
    <input type="number" name="total_payment" id="total_payment" value="0" required>
      </div>
    <div class="form-group">
      <div>
    <div class="form-row">
 <div class="col-md-1">
      <label>I</label>
    </div>
    <div class="form-group">
      <input type="text" name="amount1" class="form-control" placeholder="Enter Amount">
    </div>
    <div class="form-group">
      <input type="date" name="duedate1" class="form-control">
    </div>
     <div class="form-group">
      
    </div>
  </div>

  <div class="form-row">
     <div class="col-md-1">
      <label>II</label>
    </div>
    <div class="form-group">
      <input type="text" name="amount2" class="form-control" placeholder="Enter Amount">
    </div>
    <div class="form-group">
      <input type="date" name="duedate2" class="form-control">
    </div>
     <div class="form-group">
      
    </div>
  </div>

  <div class="form-row">
     <div class="col-md-1">
      <label>III</label>
    </div>
    <div class="form-group">
      <input type="text" name="amount3" class="form-control" placeholder="Enter Amount">
    </div>
    <div class="form-group">
      <input type="date" name="duedate3" class="form-control">
    </div>
     <div class="form-group">
      
    </div>
  </div>

  <div class="form-row">
     <div class="col-md-1">
      <label>IV</label>
    </div>
    <div class="form-group">
      <input type="text" name="amount4" class="form-control" placeholder="Enter Amount">
    </div>
    <div class="form-group">
      <input type="date" name="duedate4" class="form-control">
    </div>
     <div class="form-group">
      
    </div>
  </div>

  <div class="form-row">
    <div class="col-md-1">
      <label>V</label>
    </div>
    <div class="form-group">
      <input type="text" name="amount5" class="form-control" placeholder="Enter Amount">
    </div>
    <div class="form-group">
      <input type="date" name="duedate5" class="form-control">
    </div>
     <div class="form-group">
      
    </div>
  </div>
</div>
      </div>
    <!-- <div class="form-group">
   
   
      </div>-->
    </div> 

 
<br>
<br>

 
    <div id="payments">
        <div class="payment-row">
           <div class="form-row">
  <div class="form-group">
            <label>Paid Amount:</label>
            <input type="number" name="paid_amount[]" class="paid-amount" value="0" required></div>
 <div class="form-group">
            <label>Date of Payment:</label>
            <input type="date" name="payment_date[]" required></div>
 <div class="form-group">
            <label>Mode of Payment:</label>
            <select name="payment_mode[]" required>
                <option value="">-- Select Mode --</option>
                <option value="Cash">Cash</option>
                <option value="UPI">UPI</option>
            </select>
            <br><br>
        </div></div></div>
    </div>
      

    <button type="button" onclick="addPayment()">Add Another Payment</button>
    <div class="form-row">
  <div class="form-group">
    <label for="total_paid_payment">Total Paid Payment:</label>
    <input type="number" name="total_paid_payment" id="total_paid_payment" value="0" readonly> </div>
    <div class="form-group">

    <label for="total_pending_payment">Total Pending Payment:</label>
    <input type="number" name="total_pending_payment" id="total_pending_payment" value="0" readonly>
  </div> </div>
  <label>Remark: <textarea name="remark"></textarea></label><br/>
    <input type="submit" value="Submit Registration">
</form>

<script>
function addPayment() {
    const paymentsDiv = document.getElementById('payments');
    const newPayment = document.createElement('div');
    newPayment.classList.add('payment-row');
    newPayment.innerHTML = ` <div class="form-row">
  <div class="form-group">
        <label>Paid Amount:</label>
        <input type="number" name="paid_amount[]" class="paid-amount" value="0" required>
         </div> <div class="form-group"><label>Date of Payment:</label>
        <input type="date" name="payment_date[]" required>
        </div> <div class="form-group"> <label>Mode of Payment:</label>
        <select name="payment_mode[]" required>
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

// Initialize the first paid input listener
attachAmountListeners();

// Also recalculate on total payment change
document.getElementById('total_payment').addEventListener('input', updateTotals);
</script>
    </main>  </body>
</html>
