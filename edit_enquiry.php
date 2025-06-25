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
    echo "<a href='view_enquiries.php'>Back to List</a>";
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

    </head>
<body>

<h2>Edit Student Enquiry</h2>
<form method="post">
    <label>Student Name:
        <input type="text" name="student_name" value="<?= htmlspecialchars($row['student_name']) ?>" required>
    </label><br/>

    <label>Email ID:
        <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>
    </label><br/>

    <label>Contact Number:
        <input type="text" name="contact_number" pattern="\d{10}" maxlength="10" value="<?= htmlspecialchars($row['contact_number']) ?>" required>
    </label><br/>

    <label>Alternate Number:
        <input type="text" name="alternate_number" pattern="\d{10}" maxlength="10" value="<?= htmlspecialchars($row['alternate_number']) ?>">
    </label><br/>

    <label>Address:
        <textarea name="address" required><?= htmlspecialchars($row['address']) ?></textarea>
    </label><br/>

    <label>College Name:
        <input type="text" name="college_name" value="<?= htmlspecialchars($row['college_name']) ?>" required>
    </label><br/>

    <label>Education:
        <select id="education" name="education" onchange="toggleOtherEducation()" required>
            <option value="">Select</option>
            <option value="Civil" <?= ($row['education'] === 'Civil') ? 'selected' : '' ?>>Civil</option>
            <option value="Other" <?= ($row['education'] === 'Other') ? 'selected' : '' ?>>Other</option>
        </select>
    </label><br/>

    <div id="otherEducationDiv" style="<?= ($row['education'] === 'Other') ? 'display:block;' : 'display:none;' ?>">
        <label>Other Education:
            <input type="text" name="other_education" value="<?= htmlspecialchars($row['other_education']) ?>">
        </label><br/>
    </div>

    <label>Current Status:
        <select id="current_status" name="current_status" onchange="toggleCompanyName()" required>
            <option value="">Select</option>
            <option value="Student" <?= ($row['current_status'] === 'Student') ? 'selected' : '' ?>>Student</option>
            <option value="Working" <?= ($row['current_status'] === 'Working') ? 'selected' : '' ?>>Working</option>
        </select>
    </label><br/>

    <div id="companyNameDiv" style="<?= ($row['current_status'] === 'Working') ? 'display:block;' : 'display:none;' ?>">
        <label>Company Name:
            <input type="text" name="company_name" value="<?= htmlspecialchars($row['company_name']) ?>">
        </label><br/>
    </div>

    <label>Reference:
        <select id="reference" name="reference" onchange="toggleFriendName()" required>
            <option value="">Select</option>
            <option value="Online" <?= ($row['reference'] === 'Online') ? 'selected' : '' ?>>Online</option>
            <option value="Walking" <?= ($row['reference'] === 'Walking') ? 'selected' : '' ?>>Walking</option>
            <option value="Friend" <?= ($row['reference'] === 'Friend') ? 'selected' : '' ?>>Friend</option>
        </select>
    </label>
    <br/>

    <div id="friendNameDiv" style="<?= ($row['reference'] === 'Friend') ? 'display:block;' : 'display:none;' ?>">
        <label>Friend Name:
            <input type="text" name="friend_name" value="<?= htmlspecialchars($row['friend_name']) ?>">
        </label><br/>
    </div>

    <label>Date of Birth:
        <input type="date" name="dob" value="<?= htmlspecialchars($row['dob']) ?>" required>
    </label><br/>

    <label>Date of Enquiry:
        <input type="date" name="enquiry_date" value="<?= htmlspecialchars($row['enquiry_date']) ?>" required>
    </label><br/>

 <label>Course Apply For:</label>
 <select name="courses[]" multiple id="courses">
        <option value="Course A" <?= in_array('Course A', $courses_array) ? 'selected' : '' ?>>Course A</option>
        <option value="Course B" <?= in_array('Course B', $courses_array) ? 'selected' : '' ?>>Course B</option>
        <option value="Course 50" <?= in_array('Course 50', $courses_array) ? 'selected' : '' ?>>Course 50</option>
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
 <br/>
 

    <label>Last Remark:
        <textarea name="last_remark"><?= htmlspecialchars($row['last_remark']) ?></textarea>
    </label><br/>

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
        width: '300px'
    });
});
</script> 

</body>
</html>
