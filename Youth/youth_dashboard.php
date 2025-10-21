<?php
require_once '../Database/database.php';

class YouthCRUD {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all youths
    public function getAllYouths() {
        $sql = "SELECT * FROM youthprofiles ORDER BY fullname";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get single youth by ID
    public function getYouthById($id) {
        $sql = "SELECT * FROM youthprofiles WHERE youthid = ?";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Create new youth
    public function createYouth($data) {
        try {
            // First create user
            $username = strtolower(str_replace(' ', '.', $data['fullname'])) . rand(100, 999);
            $tempPassword = password_hash('password', PASSWORD_DEFAULT);
            
            $userSql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'Youth')";
            $userStmt = $this->db->conn->prepare($userSql);
            $userStmt->execute([$username, $tempPassword]);
            $userid = $this->db->conn->lastInsertId();

            // Then create youth profile
            $sql = "INSERT INTO youthprofiles (youthid, fullname, dateofbirth, educationlevel, interests, availability, bio) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->conn->prepare($sql);
            return $stmt->execute([
                $userid,
                $data['fullname'],
                $data['dateofbirth'],
                $data['educationlevel'],
                $data['interests'],
                $data['availability'],
                $data['bio']
            ]);
        } catch(PDOException $e) {
            throw new Exception("Error creating youth: " . $e->getMessage());
        }
    }
    
    // Update youth
    public function updateYouth($id, $data) {
        $sql = "UPDATE youthprofiles 
                SET fullname = ?, dateofbirth = ?, educationlevel = ?, 
                    interests = ?, availability = ?, bio = ?
                WHERE youthid = ?";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute([
            $data['fullname'],
            $data['dateofbirth'],
            $data['educationlevel'],
            $data['interests'],
            $data['availability'],
            $data['bio'],
            $id
        ]);
    }
    
    // Delete youth
    public function deleteYouth($id) {
        try {
            // Delete youth profile first
            $sql = "DELETE FROM youthprofiles WHERE youthid = ?";
            $stmt = $this->db->conn->prepare($sql);
            $stmt->execute([$id]);
            
            // Then delete user
            $user_sql = "DELETE FROM users WHERE userid = ?";
            $user_stmt = $this->db->conn->prepare($user_sql);
            return $user_stmt->execute([$id]);
        } catch(PDOException $e) {
            throw new Exception("Error deleting youth: " . $e->getMessage());
        }
    }
}

// Handle form actions
$youthCRUD = new YouthCRUD();
$message = "";

// Create or Update
if ($_POST && isset($_POST['submit'])) {
    $data = [
        'fullname' => $_POST['fullname'],
        'dateofbirth' => $_POST['dateofbirth'],
        'educationlevel' => $_POST['educationlevel'],
        'interests' => $_POST['interests'] ?? '',
        'availability' => $_POST['availability'] ?? '',
        'bio' => $_POST['bio'] ?? ''
    ];
    
    try {
        if (isset($_POST['youthid']) && !empty($_POST['youthid'])) {
            // Update existing youth
            if ($youthCRUD->updateYouth($_POST['youthid'], $data)) {
                $message = '<div class="alert alert-success">Youth profile updated successfully!</div>';
            } else {
                $message = '<div class="alert alert-danger">Error updating youth profile!</div>';
            }
        } else {
            // Create new youth
            if ($youthCRUD->createYouth($data)) {
                $message = '<div class="alert alert-success">Youth profile created successfully!</div>';
            } else {
                $message = '<div class="alert alert-danger">Error creating youth profile!</div>';
            }
        }
    } catch(Exception $e) {
        $message = '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
    }
}

// Delete youth
if (isset($_GET['delete_id'])) {
    try {
        if ($youthCRUD->deleteYouth($_GET['delete_id'])) {
            $message = '<div class="alert alert-success">Youth profile deleted successfully!</div>';
        } else {
            $message = '<div class="alert alert-danger">Error deleting youth profile!</div>';
        }
    } catch(Exception $e) {
        $message = '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
    }
}

// Get youth for editing
$editYouth = null;
if (isset($_GET['edit_id'])) {
    $editYouth = $youthCRUD->getYouthById($_GET['edit_id']);
}

// Get all youths for display
$youths = $youthCRUD->getAllYouths();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youth Management - EduBridge</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .card { box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .table-actions { white-space: nowrap; }
        .hero-section { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 0; margin-bottom: 2rem; border-radius: 0 0 20px 20px; }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold">
                        <i class="fas fa-users me-3"></i>Youth Management
                    </h1>
                    <p class="lead">EduBridge Youth Profile CRUD System</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="bg-white rounded-pill px-4 py-2 d-inline-block">
                        <i class="fas fa-database text-primary me-2"></i>
                        <span class="text-dark fw-bold"><?php echo count($youths); ?> Youth Profiles</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Message Display -->
        <?php echo $message; ?>

        <div class="row">
            <!-- Form Section -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas <?php echo $editYouth ? 'fa-edit' : 'fa-user-plus'; ?> me-2"></i>
                            <?php echo $editYouth ? 'Edit Youth Profile' : 'Add New Youth'; ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <?php if ($editYouth): ?>
                                <input type="hidden" name="youthid" value="<?php echo $editYouth['youthid']; ?>">
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" 
                                       value="<?php echo $editYouth ? htmlspecialchars($editYouth['fullname']) : ''; ?>" 
                                       required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="dateofbirth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="dateofbirth" name="dateofbirth" 
                                       value="<?php echo $editYouth ? $editYouth['dateofbirth'] : ''; ?>" 
                                       required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="educationlevel" class="form-label">Education Level</label>
                                <select class="form-select" id="educationlevel" name="educationlevel" required>
                                    <option value="">Select Education Level</option>
                                    <option value="Primary" <?php echo ($editYouth && $editYouth['educationlevel'] == 'Primary') ? 'selected' : ''; ?>>Primary</option>
                                    <option value="Secondary" <?php echo ($editYouth && $editYouth['educationlevel'] == 'Secondary') ? 'selected' : ''; ?>>Secondary</option>
                                    <option value="University" <?php echo ($editYouth && $editYouth['educationlevel'] == 'University') ? 'selected' : ''; ?>>University</option>
                                    <option value="Vocational" <?php echo ($editYouth && $editYouth['educationlevel'] == 'Vocational') ? 'selected' : ''; ?>>Vocational</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="interests" class="form-label">Interests</label>
                                <textarea class="form-control" id="interests" name="interests" rows="2"><?php echo $editYouth ? htmlspecialchars($editYouth['interests']) : ''; ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="availability" class="form-label">Availability</label>
                                <input type="text" class="form-control" id="availability" name="availability" 
                                       value="<?php echo $editYouth ? htmlspecialchars($editYouth['availability']) : ''; ?>" 
                                       placeholder="e.g., Full-time, Part-time">
                            </div>
                            
                            <div class="mb-3">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea class="form-control" id="bio" name="bio" rows="3"><?php echo $editYouth ? htmlspecialchars($editYouth['bio']) : ''; ?></textarea>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fas <?php echo $editYouth ? 'fa-save' : 'fa-plus'; ?> me-2"></i>
                                    <?php echo $editYouth ? 'Update Profile' : 'Create Profile'; ?>
                                </button>
                                
                                <?php if ($editYouth): ?>
                                    <a href="youth_dashboard.php" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel Edit
                                    </a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- List Section -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>Youth Profiles List
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($youths)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5>No Youth Profiles Found</h5>
                                <p class="text-muted">Start by adding your first youth profile using the form on the left.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Date of Birth</th>
                                            <th>Education</th>
                                            <th>Interests</th>
                                            <th>Availability</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($youths as $youth): ?>
                                            <tr>
                                                <td><strong>#<?php echo $youth['youthid']; ?></strong></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-circle bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            <?php echo strtoupper(substr($youth['fullname'], 0, 1)); ?>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold"><?php echo htmlspecialchars($youth['fullname']); ?></div>
                                                            <small class="text-muted"><?php echo strlen($youth['bio']) > 50 ? substr($youth['bio'], 0, 50) . '...' : $youth['bio']; ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo $youth['dateofbirth']; ?></td>
                                                <td>
                                                    <span class="badge bg-info"><?php echo $youth['educationlevel']; ?></span>
                                                </td>
                                                <td>
                                                    <small><?php echo strlen($youth['interests']) > 30 ? substr($youth['interests'], 0, 30) . '...' : $youth['interests']; ?></small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary"><?php echo $youth['availability']; ?></span>
                                                </td>
                                                <td class="table-actions">
                                                    <a href="youth_dashboard.php?edit_id=<?php echo $youth['youthid']; ?>" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="youth_dashboard.php?delete_id=<?php echo $youth['youthid']; ?>" 
                                                       class="btn btn-sm btn-danger" 
                                                       onclick="return confirm('Are you sure you want to delete <?php echo htmlspecialchars($youth['fullname']); ?>?')"
                                                       title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Summary Cards -->
                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white text-center">
                                        <div class="card-body">
                                            <h4><i class="fas fa-users"></i></h4>
                                            <h5><?php echo count($youths); ?></h5>
                                            <small>Total Youth</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white text-center">
                                        <div class="card-body">
                                            <h4><i class="fas fa-graduation-cap"></i></h4>
                                            <h5><?php echo count(array_filter($youths, fn($y) => $y['educationlevel'] === 'University')); ?></h5>
                                            <small>University</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white text-center">
                                        <div class="card-body">
                                            <h4><i class="fas fa-school"></i></h4>
                                            <h5><?php echo count(array_filter($youths, fn($y) => $y['educationlevel'] === 'Secondary')); ?></h5>
                                            <small>Secondary</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white text-center">
                                        <div class="card-body">
                                            <h4><i class="fas fa-tools"></i></h4>
                                            <h5><?php echo count(array_filter($youths, fn($y) => $y['educationlevel'] === 'Vocational')); ?></h5>
                                            <small>Vocational</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">
                <i class="fas fa-bridge me-2"></i>EduBridge Youth CRUD System &copy; 2024
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>