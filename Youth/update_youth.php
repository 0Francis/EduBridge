<?php
require_once '../database/database.php';

$db = new Database();


$youth = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM youths WHERE id = ?";
    $stmt = $db->conn->prepare($sql);
    $stmt->execute([$id]);
    $youth = $stmt->fetch(PDO::FETCH_ASSOC);
}


if ($_POST) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $phone_number = $_POST['phone_number'];
    $education_level = $_POST['education_level'];
    $email = $_POST['email'];

    try {
        $sql = "UPDATE youths 
                SET name = ?, date_of_birth = ?, gender = ?, phone_number = ?, 
                    education_level = ?, email = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        
        $stmt = $db->conn->prepare($sql);
        $stmt->execute([$name, $date_of_birth, $gender, $phone_number, $education_level, $email, $id]);
        
        echo "Youth profile updated successfully!";
        
        $stmt = $db->conn->prepare("SELECT * FROM youths WHERE id = ?");
        $stmt->execute([$id]);
        $youth = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php if ($youth): ?>
<form method="POST" action="">
    <input type="hidden" name="id" value="<?php echo $youth['id']; ?>">
    
    <h2>Update Youth Profile</h2>
    
    <label>Full Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($youth['name']); ?>" required>
    
    <label>Date of Birth:</label>
    <input type="date" name="date_of_birth" value="<?php echo $youth['date_of_birth']; ?>" required>
    
    <label>Gender:</label>
    <select name="gender" required>
        <option value="Male" <?php echo $youth['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
        <option value="Female" <?php echo $youth['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
        <option value="Other" <?php echo $youth['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
    </select>
    
    <label>Phone Number:</label>
    <input type="tel" name="phone_number" value="<?php echo $youth['phone_number']; ?>" required>
    
    <label>Education Level:</label>
    <select name="education_level" required>
        <option value="Primary" <?php echo $youth['education_level'] == 'Primary' ? 'selected' : ''; ?>>Primary School</option>
        <option value="Secondary" <?php echo $youth['education_level'] == 'Secondary' ? 'selected' : ''; ?>>Secondary School</option>
        <option value="University" <?php echo $youth['education_level'] == 'University' ? 'selected' : ''; ?>>University</option>
        <option value="Vocational" <?php echo $youth['education_level'] == 'Vocational' ? 'selected' : ''; ?>>Vocational Training</option>
    </select>
    
    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $youth['email']; ?>" required>
    
    <button type="submit">Update Profile</button>
</form>
<?php else: ?>
    <p>Youth profile not found!</p>
<?php endif; ?>