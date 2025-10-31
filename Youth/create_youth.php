<?php
require_once 'youth_controller.php';

$message = '';
$success = false;

if ($_POST) {
    $controller = new YouthController();
    
    $data = [
        'name' => $_POST['name'],
        'dob' => $_POST['dob'],
        'gender' => $_POST['gender'],
        'phone_no' => $_POST['phone_no'],
        'education_level' => $_POST['education_level'],
        'email' => $_POST['email'],
        'skills' => $_POST['skills'] ?? '',
        'bio' => $_POST['bio'] ?? ''
    ];
    
    try {
        $success = $controller->createYouth($data);
        if ($success) {
            $message = "Youth profile created successfully!";
            // Clear form or redirect
            header("Location: youth_list.php?message=Profile+created+successfully");
            exit;
        }
    } catch(PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Youth Profile - EduBridge</title>
    <style>
        .container { max-width: 600px; margin: 20px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
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
        
        <h2>Create Youth Profile</h2>
        
        <?php if ($message): ?>
            <div class="message <?php echo $success ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Date of Birth:</label>
                <input type="date" name="dob" value="<?php echo isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Gender:</label>
                <select name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Phone Number:</label>
                <input type="text" name="phone_no" value="<?php echo isset($_POST['phone_no']) ? htmlspecialchars($_POST['phone_no']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Education Level:</label>
                <select name="education_level" required>
                    <option value="">Select Education Level</option>
                    <option value="Primary" <?php echo (isset($_POST['education_level']) && $_POST['education_level'] == 'Primary') ? 'selected' : ''; ?>>Primary</option>
                    <option value="Secondary" <?php echo (isset($_POST['education_level']) && $_POST['education_level'] == 'Secondary') ? 'selected' : ''; ?>>Secondary</option>
                    <option value="University" <?php echo (isset($_POST['education_level']) && $_POST['education_level'] == 'University') ? 'selected' : ''; ?>>University</option>
                    <option value="Vocational" <?php echo (isset($_POST['education_level']) && $_POST['education_level'] == 'Vocational') ? 'selected' : ''; ?>>Vocational</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Skills:</label>
                <textarea name="skills" placeholder="e.g., Programming, Design, Writing"><?php echo isset($_POST['skills']) ? htmlspecialchars($_POST['skills']) : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Bio:</label>
                <textarea name="bio"><?php echo isset($_POST['bio']) ? htmlspecialchars($_POST['bio']) : ''; ?></textarea>
            </div>
            
            <button type="submit">Create Profile</button>
        </form>
    </div>
</body>
</html>