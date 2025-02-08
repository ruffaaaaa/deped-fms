<?php include 'db_connect.php'; ?>

<style>
/* Container styling */
.users-container {
    margin: 20px;
}

/* Card styling */
.card-users {
    background-color: #ffffff;
    border-radius: 10px;

    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}

/* Scrollable table container */
.scrollable-table {
    max-height: 400px; /* Limits height, enables scrolling */
    overflow-y: auto; /* Vertical scrolling */
    overflow-x: auto; /* Horizontal scrolling for responsiveness */
    -webkit-overflow-scrolling: touch; /* Smooth scrolling for mobile */
	border-radius: 10px;

}

/* Fix table header */
.scrollable-table thead th {
    position: sticky;
    top: 0;
    background: white; /* Keeps header visible */
    z-index: 2; /* Ensures header stays above content */
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
}

/* Alternate row colors */
.table tbody tr:nth-child(even) {
    background-color: #f8f9fa; /* Light gray */
}
.table tbody tr:nth-child(odd) {
    background-color: #ffffff; /* White */
}

.new {
	border-radius: 20px;
}
</style>

<div class="users-container">
    <div class="row">
        <div class="col-lg-12">
            <button class="new bg-gray-500 text-sm text-white px-3 py-2  float-right " id="new_user">
                <i class="fa fa-plus"></i> New User
            </button>
			<!-- <button class="new bg-gray-500 text-sm text-white px-3 py-2 rounded-4xl" id="new_file">
                    <i class="fa fa-upload"></i> <span class="button-text">Upload File</span>
                </button> -->
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12">
            <div class="card-users">
                <!-- Scrollable table container -->
                <div class="scrollable-table">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $users = $conn->query("SELECT * FROM users ORDER BY name ASC");
                                $i = 1;
                                while ($row = $users->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td>
									<div class="btn-group">
										<button type="button" class="btn btn-primary btn-sm">Action</button>
										<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
											data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<div class="dropdown-menu">
											<a class="dropdown-item edit_user" href="javascript:void(0)" data-id='<?php echo $row['id']; ?>'>Edit</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item delete_user" href="javascript:void(0)" data-id='<?php echo $row['id']; ?>'>Delete</a>
										</div>
									</div> 
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Open New User Modal
$('#new_user').click(function(){
    uni_modal('New User','manage_user.php');
});

// Open Edit User Modal
$('.edit_user').click(function(){
    uni_modal('Edit User','manage_user.php?id='+$(this).attr('data-id'));
});
</script>
