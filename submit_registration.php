<?php
include 'connect.php';

$student_id = $_POST['student_id'];
$class_type = $_POST['class_type'];
$branch = $_POST['branch'];
$class_time = $_POST['class_time'];
  $software_names = [];
    for ($i = 1; $i <= 8; $i++) {
        $key = 'software_name' . $i;
        $software_names[] = $_POST[$key] ?? '';
    }
$total_payment = $_POST['total_payment'];
$total_paid_payment = $_POST['total_paid_payment'];
$total_pending_payment = $_POST['total_pending_payment'];
$remark = $_POST['remark'];
$amount1 = $_POST['amount1'];$amount2 = $_POST['amount2'];
$amount3 = $_POST['amount3'];$amount4 = $_POST['amount4'];
$amount5 = $_POST['amount5']; $duedate1 = $_POST['duedate1'];
$duedate2 = $_POST['duedate2']; $duedate3 = $_POST['duedate3'];
$duedate4 = $_POST['duedate4']; $duedate5 = $_POST['duedate5'];
// Insert registration data
$stmt = $conn->prepare("INSERT INTO registrations (student_id, class_type, branch, class_time, software1, software2, software3, software4, software5, software6, software7, software8, total_payment, total_paid_payment, total_pending_payment,amount1,amount2,amount3,amount4,amount5,duedate1,duedate2,duedate3,duedate4,duedate5,remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("isssssssssssdddsssssssssss", $student_id, $class_type, $branch, $class_time,  $software_names[0], $software_names[1], $software_names[2], $software_names[3],
        $software_names[4], $software_names[5], $software_names[6], $software_names[7],$total_payment, $total_paid_payment, $total_pending_payment,$amount1,$amount2,$amount3,$amount4,$amount5,$duedate1,$duedate2,$duedate3,$duedate4,$duedate5,$remark);
$stmt->execute();
$registration_id = $stmt->insert_id;

// Insert payments
$paid_amounts = $_POST['paid_amount'];
$payment_dates = $_POST['payment_date'];
$payment_modes = $_POST['payment_mode'];

for ($i = 0; $i < count($paid_amounts); $i++) {
    $stmt2 = $conn->prepare("INSERT INTO payments (registration_id, paid_amount, payment_date, payment_mode) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("idss", $registration_id, $paid_amounts[$i], $payment_dates[$i], $payment_modes[$i]);
    $stmt2->execute();
}

header("Location: view_registrations.php");
exit();
?>
