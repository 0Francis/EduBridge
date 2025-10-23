<?php
require_once 'youth_controller.php';

$controller = new YouthController();
$message = '';
$success = false;

// Get youth data
$youth = null;
if (isset($_GET['id'])) {
    $youth = $controller->getYouth($_GET['id']);
}

if (!$youth) {
    die("Youth profile not found!");
}

// Handle form submission
if ($_POST) {
    $data = [
        'name' => $_POST['name'],
        'dob' => $_POST['dob'],
        'gender' => $_POST['gender'],
        'phone_no' => $_POST['phone_no'],
        'education_level' => $_POST['education_level'],
        'email' => $_POST['email'],
        'skills' => $_POST['skills'],
        'bio' => $_POST['bio']
    ];
    
    try {
        $success = $controller->updateYouth($youth['youth_id'], $data);
        if ($success) {
            $message = "Youth profile updated successfully!";
            // Refresh youth data
            $youth = $controller->getYouth($youth['youth_id']);
        }
    } catch(PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Youth Profile - EduBridge</title>
    <style>
        .container { max-width: 600px; margin: 20px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; }
        .message { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .nav-links { margin-bottom: 20px; }
        .nav-links a { margin-right: 15px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-links">
            <a href="youth_list.php">← Back to Youth List</a>
        </div>
        
        <h2>Update Youth Profile</h2>
        
        <?php if ($message): ?>
            <div class="message <?php echo $success ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <input type="hidden" name="youth_id" value="<?php echo $youth['youth_id']; ?>">
            
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($youth['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Date of Birth:</label>
                <input type="date" name="dob" value="<?php echo $youth['dob']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Gender:</label>
                <select name="gender" required>
                    <option value="Male" <?php echo $youth['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo $youth['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo $youth['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Phone Number:</label>
                <input type="text" name="phone_no" value="<?php echo htmlspecialchars($youth['phone_no']); ?>">
            </div>
            
            <div class="form-group">
                <label>Education Level:</label>
                <select name="education_level" required>
                    <option value="Primary" <?php echo $youth['education_level'] == 'Primary' ? 'selected' : ''; ?>>Primary</option>
                    <option value="Secondary" <?php echo $youth['education_level'] == 'Secondary' ? 'selected' : ''; ?>>Secondary</option>
                    <option value="University" <?php echo $youth['education_level'] == 'University' ? 'selected' : ''; ?>>University</option>
                    <option value="Vocational" <?php echo $youth['education_level'] == 'Vocational' ? 'selected' : ''; ?>>Vocational</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($youth['email']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Skills:</label>
                <textarea name="skills"><?php echo htmlspecialchars($youth['skills']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Bio:</label>
                <textarea name="bio"><?php echo htmlspecialchars($youth['bio']); ?></textarea>
            </div>
            
            <button type="submit">Update Profile</button>
            <a href="youth_list.php">Cancel</a>
        </form>
    </div>
</body>
</html>