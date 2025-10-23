<?php
require_once 'youth_controller.php';

$controller = new YouthController();
$youths = $controller->getAllYouths();

$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Youth Management - EduBridge</title>
    <style>
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; position: sticky; top: 0; }
        .action-links a { margin-right: 10px; text-decoration: none; color: #007bff; }
        .action-links a:hover { text-decoration: underline; }
        .nav-links { margin-bottom: 20px; }
        .nav-links a { margin-right: 15px; text-decoration: none; color: #007bff; }
        .message { padding: 10px; margin: 10px 0; background: #d4edda; color: #155724; border-radius: 4px; }
        .btn { display: inline-block; padding: 10px 15px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; }
        .btn:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Youth Management System</h1>
        
        <div class="nav-links">
            <a href="create_youth.php" class="btn">Add New Youth</a>
            <a href="youth_list.php">Refresh List</a>
        </div>
        
        <?php if ($message): ?>
            <div class="message">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <h2>All Youth Profiles</h2>
        
        <?php if (empty($youths)): ?>
            <p>No youth profiles found. <a href="create_youth.php">Create the first profile</a>.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Education Level</th>
                        <th>Email</th>
                        <th>Skills</th>
                        <th>Date Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($youths as $youth): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($youth['youth_id']); ?></td>
                        <td><?php echo htmlspecialchars($youth['name']); ?></td>
                        <td><?php echo htmlspecialchars($youth['dob']); ?></td>
                        <td><?php echo htmlspecialchars($youth['gender']); ?></td>
                        <td><?php echo htmlspecialchars($youth['phone_no']); ?></td>
                        <td><?php echo htmlspecialchars($youth['education_level']); ?></td>
                        <td><?php echo htmlspecialchars($youth['email']); ?></td>
                        <td><?php echo htmlspecialchars($youth['skills']); ?></td>
                        <td><?php echo htmlspecialchars($youth['date_joined']); ?></td>
                        <td class="action-links">
                            <a href="update_youth.php?id=<?php echo $youth['youth_id']; ?>">Edit</a>
                            <a href="delete_youth.php?id=<?php echo $youth['youth_id']; ?>" onclick="return confirm('Are you sure you want to delete this profile?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>