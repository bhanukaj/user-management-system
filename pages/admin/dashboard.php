<?php
session_start();
//return to login if not logged in
if (isset($_SESSION['user']) === false || (trim($_SESSION['user']) === '')){
    header('location:../../index.php');
}
 
include_once('../../entity/User.php');
include_once('../../entity/Province.php');
 
$user = new User();
$province = new Province();

$users = $user->getAllUsers();
$provinces = $province->getAllProvinces();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Users</a>
                    </li>
                    <!-- Add other tabs here as needed -->
                </ul>
            </div>
            <form action="../../action/logout.php" method="POST">
                <button class="btn btn-outline-primary" type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>User Management</h2>
            <!-- Add New User Button -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">Add New User</button>
        </div>

        <!-- User List Table -->
        <div class="card">
            <div class="card-header">
                <h5>User List</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Province</th>
                            <th>District</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['district_id']); ?></td>
                                <td><?php echo htmlspecialchars($user['role']); ?></td>
                                <td>
                                    <!-- Add action buttons or links here if needed -->
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#userModal">Edit</button>
                                    <button class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- User Form Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Add/Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email" required>
                        </div>
                        <div class="mb-3">
                            <label for="province" class="form-label">Province</label>
                            <select class="form-select" id="province" required>
                                <option value="">Select Province</option>
                                <?php foreach ($provinces as $province): ?>
                                    <option value="<?php echo htmlspecialchars($province['id']); ?>"><?php echo htmlspecialchars($province['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="district" class="form-label">District</label>
                            <select class="form-select" id="district" required>
                                <option value="">Select District</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" required disabled>
                                <option value="1">Admin</option>
                                <option value="2" selected>User</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Script -->

    <script>
        $(document).ready(function() {
            // When the province selector changes
            $('#province').on('change', function() {
                var provinceId = $(this).val(); // Get selected province ID

                // Clear existing options in the district dropdown
                $('#district').empty();
                $('#district').append('<option value="">Select District</option>'); // Add a default option

                // If no province is selected, exit
                if (!provinceId) {
                    return;
                }

                // AJAX request to fetch districts
                $.ajax({
                    url: '../../action/district-get-by-province-id.php',
                    type: 'GET',
                    data: { provinceId: provinceId },
                    dataType: 'json',
                    success: function(response) {
                        // Populate the district dropdown with the fetched data
                        $.each(response, function(index, district) {
                            $('#district').append(
                                $('<option></option>').val(district.id).text(district.name)
                            );
                        });
                    },
                    error: function() {
                        alert('An error occurred while fetching districts.');
                    }
                });
            });

            $('#userForm').on('submit', function(event) {
                event.preventDefault(); 

                var formData = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    district: $('#district').val(),
                    role: $('#role').val()
                };

                $.ajax({
                    url: '../../action/create-users.php', 
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert('User added successfully');
                            
                            $('#userModal').modal('hide');
                            $('#userForm')[0].reset();

                            location.reload(); 
                        } else {
                            alert(response.message); 
                        }
                    },
                    error: function() {
                        alert('An error occurred while adding the user.');
                    }
                });
            });
        });
    </script>
    <script>
    


</script>

</body>

</html>
