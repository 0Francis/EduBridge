<?php
require_once '../Database/database.php';

$db = new Database();


$youth = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM youthprofiles WHERE youthid = ?";
    $stmt = $db->conn->prepare($sql);
    $stmt->execute([$id]);
    $youth = $stmt->fetch(PDO::FETCH_ASSOC);
}


if ($_POST) {
    $id = $_POST['youthid'];
    $fullname = $_POST['fullname'];
    $dateofbirth = $_POST['dateofbirth'];
    $educationlevel = $_POST['educationlevel'];
    $interests = $_POST['interests'];
    $availability = $_POST['availability'];
    $bio = $_POST['bio'];

    try {
        $sql = "UPDATE youthprofiles 
                SET fullname = ?, dateofbirth = ?, educationlevel = ?, 
                    interests = ?, availability = ?, bio = ?
                WHERE youthid = ?";
        
        $stmt = $db->conn->prepare($sql);
        $stmt->execute([$fullname, $dateofbirth, $educationlevel, $interests, $availability, $bio, $id]);
        
        echo "Youth profile updated successfully!";
        
        // Refresh youth data
        $stmt = $db->conn->prepare("SELECT * FROM youthprofiles WHERE youthid = ?");
        $stmt->execute([$id]);
        $youth = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php if ($youth): ?>
<form method="POST" action="">
    <input type="hidden" name="youthid" value="<?php echo $youth['youthid']; ?>">
    
    <h2>Update Youth Profile</h2>
    
    <label>Full Name:</label>
    <input type="text" name="fullname" value="<?php echo htmlspecialchars($youth['fullname']); ?>" required>
    
    <label>Date of Birth:</label>
    <input type="date" name="dateofbirth" value="<?php echo $youth['dateofbirth']; ?>" required>
    
    <label>Education Level:</label>
    <select name="educationlevel" required>
        <option value="Primary" <?php echo $youth['educationlevel'] == 'Primary' ? 'selected' : ''; ?>>Primary</option>
        <option value="Secondary" <?php echo $youth['educationlevel'] == 'Secondary' ? 'selected' : ''; ?>>Secondary</option>
        <option value="University" <?php echo $youth['educationlevel'] == 'University' ? 'selected' : ''; ?>>University</option>
        <option value="Vocational" <?php echo $youth['educationlevel'] == 'Vocational' ? 'selected' : ''; ?>>Vocational</option>
    </select>
    
    <label>Interests:</label>
    <textarea name="interests"><?php echo htmlspecialchars($youth['interests']); ?></textarea>
    
    <label>Availability:</label>
    <input type="text" name="availability" value="<?php echo htmlspecialchars($youth['availability']); ?>">
    
    <label>Bio:</label>
    <textarea name="bio"><?php echo htmlspecialchars($youth['bio']); ?></textarea>
    
    <button type="submit">Update Profile</button>
</form>
<?php else: ?>
    <p>Youth profile not found!</p>
<?php endif; ?>