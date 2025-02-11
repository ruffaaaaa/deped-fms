<?php 
include 'db_connect.php';
$folder_parent = isset($_GET['fid'])? $_GET['fid'] : 0;
$folders = $conn->query("SELECT * FROM folders where parent_id = $folder_parent and user_id = '".$_SESSION['login_id']."'  order by name asc");


$files = $conn->query("SELECT * FROM files where is_public = '1'  order by name asc");

?>
<style>
	.folder-item{
		cursor: pointer;
	}
	.folder-item:hover{
		background: #eaeaea;
	    color: black;
	    box-shadow: 3px 3px #0000000f;
	}
	.custom-menu {
        z-index: 1000;
	    position: absolute;
	    background-color: #ffffff;
	    border: 1px solid #0000001c;
	    border-radius: 5px;
	    padding: 8px;
	    min-width: 13vw;
}
a.custom-menu-list {
    width: 100%;
    display: flex;
    color: #4c4b4b;
    font-weight: 600;
    font-size: 1em;
    padding: 1px 11px;
}
.file-item{
	cursor: pointer;
}
a.custom-menu-list:hover,.file-item:hover,.file-item.active {
    background: #80808024;
}
table th,td{
	/*border-left:1px solid gray;*/
}
a.custom-menu-list span.icon{
		width:1em;
		margin-right: 5px
}

/* Ensure the modal dialog itself is wide enough to support the PDF iframe */
#image-preview-modal .modal-dialog {
    max-width: 90%; /* Or any larger value you prefer */
    width: 90%; /* Set the width of the modal dialog */
}

/* Modal body should be scrollable and allow for resizing */
#image-preview-modal .modal-body {
    max-height: 70vh; /* Set a maximum height to allow scrolling */
    overflow-y: auto; /* Enable vertical scrolling */
    display: flex; /* Allow the contents to resize properly */
    justify-content: center; /* Center the content horizontally */
}

/* Set width and height for the image and iframe to adjust accordingly */
#preview-image {
    width: 100%;  /* Take the full width of the modal body */
    height: auto;  /* Maintain the aspect ratio */
    object-fit: contain; /* Ensure the image fits inside the modal without stretching */
    max-height: 80vh; /* Prevent the image from becoming too tall */
}

/* Specific styling for the PDF preview iframe */
#preview-pdf {
    width: 100%; /* Ensure the iframe takes the full width */
    height: 80vh;  /* Adjust height for PDF preview to make it taller */
}

.form-control {
	border-radius: 25px;
}

.filter {
	border-top-right-radius: 25px; /* Round top-right corner */
    border-bottom-right-radius: 25px; /* Round bottom-right corner */
}

.shared-container {
     margin: 10px !important;

}

.card-files {
	background-color: #ffffff;
	border-radius: 10px;

}

.scrollable-table {
    max-height: 400px; /* Set a max height to enable scrolling */
    overflow-y: auto; /* Vertical scrolling */
    overflow-x: auto; /* Horizontal scrolling for small screens */
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

@media (max-width: 768px) {
    .search-container {
        width: 100%;
    }
    .search-container .input-group {
        flex-wrap: nowrap;
        width: 100%;
    }
    .search-container input {
        flex-grow: 1; /* Makes input expand fully */
        min-width: 0;
    }
    .search-container .input-group-text {
        flex-shrink: 0; /* Prevents filter button from shrinking too much */
        width: auto; /* Keep natural size */
    }
	.title-shared{
		margin-top: 2rem;
	}
}




</style>
<div class="shared-container">
	<div class=" col-lg-12">
		<div class=" row d-flex align-items-center m">
		<!-- Title (Aligned Left) -->
			<div class="col-auto text-uppercase text-xl">
				<p class="title-shared"><b>Shared Files</b></p>
			</div>

			<!-- Search Bar (Aligned Right) -->
			<div class="col-md-6 col-12 ms-auto search-container">
				<div class="input-group">
					<!-- Search Input -->
					<input type="text" class="form-control rounded-pill pe-5" id="search"
						aria-label="Search" placeholder="Search">

					<!-- Search Icon Inside Input -->
					<span class="position-absolute" style="right: 60px; top: 50%; transform: translateY(-50%); color: gray;">
						<i class="fa fa-search"></i>
					</span>

					<!-- Filter Icon (Remains Next to Search) -->
					<span class="input-group-text bg-white border rounded-pill ms-1" style="cursor: pointer;">
						<i class="fa fa-filter"></i>
					</span>  
				</div>
			</div>
		</div>



		<!-- <div class="row">
			<div class="col-md-12"><h4><b>Shared Files</b></h4></div>
		</div> -->
		<hr>
		<div class="row">
			<div class="col-md-12">
				<div class="card-files rounded-xl">
					<!-- Scrollable table container -->
					<div class="scrollable-table">
						<table class="table table-hover table-striped">
							<thead>
								<tr>
									<th width="40%">Filename</th>
									<th width="20%">Date</th>
									<th width="20%">Description</th>
									<th width="20%">Owner</th>
									<th width="20%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php while ($row = $files->fetch_assoc()): ?>
								<tr class='file-item' data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-path="<?php echo $row['file_path'] ?>">
									<td><large><span><i class="fa fa-file"></i></span><b class="to_file"> <?php echo $row['name'] ?></b></large>
                                    <input type="text" class="rename_file" value="<?php echo $row['name'] ?>" data-id="<?php echo $row['id'] ?>" data-type="<?php echo $row['file_type'] ?>" data-path="<?php echo $row['file_path'] ?>" style="display: none">
                                    </td>
									<td><i class="to_file"><?php echo date('Y/m/d h:i A', strtotime($row['date_updated'])) ?></i></td>
									<td><i class="to_file"><?php echo $row['description'] ?></i></td>
									<td>
										<i class="to_file">
											<?php 
												$query = "SELECT `name` FROM `users` WHERE id = " . $row['user_id'];
												$result = $conn->query($query);
												echo ($result->num_rows > 0) ? $result->fetch_assoc()['name'] : "Unknown";
											?>
										</i>
									</td>
									<td>
										<!-- Meatball menu (three vertical dots) -->
										<button class="meatball-menu-btn" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-path="<?php echo $row['file_path'] ?>">
											<i class="fa fa-ellipsis-h"></i>
										</button>
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
</div>
<div id="menu-folder-clone" style="display: none;">
    <a href="javascript:void(0)" class="custom-menu-list file-option edit">Rename</a>
    <?php if ($_SESSION['login_type'] == '1'): ?>
        <a href="javascript:void(0)" class="custom-menu-list file-option delete">Delete</a>
    <?php endif; ?>
</div>
<div id="menu-file-clone" style="display: none;">
    <a href="javascript:void(0)" class="custom-menu-list file-option edit"><span><i class="fa fa-edit"></i> </span>Rename</a>
    <a href="javascript:void(0)" class="custom-menu-list file-option download"><span><i class="fa fa-download"></i> </span>Download</a>
    <?php if ($_SESSION['login_type'] == '1'): ?>
        <a href="javascript:void(0)" class="custom-menu-list file-option delete"><span><i class="fa fa-trash"></i> </span>Delete</a>
    <?php endif; ?>
    <a href="javascript:void(0)" class="custom-menu-list file-option preview"><span><i class="fa fa-eye"></i> </span>Preview</a>
</div>


<!-- MODAL TO PREVIEW A FILE -->
<div id="image-preview-modal" class="modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="preview-image" src="" alt="File Preview" style="width: 100%; height: auto; display: none;">
                <iframe id="preview-pdf" src="" style="width: 100%; height: 500px; display: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
	
	var loginType = <?php echo $_SESSION['login_type']; ?>;
	

	//FILE
	$('.file-item').bind("contextmenu", function(event) {
    event.preventDefault();

    $('.file-item').removeClass('active');
    $(this).addClass('active');
    $("div.custom-menu").hide();

    // Create the custom menu
    var custom = $("<div class='custom-menu file'></div>");
    custom.append($('#menu-file-clone').html());
    custom.find('.edit').attr('data-id', $(this).attr('data-id'));
    custom.find('.delete').attr('data-id', $(this).attr('data-id'));
    custom.find('.download').attr('data-id', $(this).attr('data-id'));
    custom.find('.preview')
    .attr('data-id', $(this).attr('data-id'))
    .attr('data-path', $(this).attr('data-path'))
    .attr('data-name', $(this).data('name'));
    custom.appendTo("body");
    custom.css({top: event.pageY + "px", left: event.pageX + "px"});

    // Attach click handlers AFTER the custom menu is appended to the DOM
    custom.find('.edit').click(function(e) {
        e.preventDefault();
        $('.rename_file[data-id="' + $(this).attr('data-id') + '"]').siblings('large').hide();
        $('.rename_file[data-id="' + $(this).attr('data-id') + '"]').show();
    });

    custom.find('.delete').click(function(e) {
        e.preventDefault();
        _conf("Are you sure to delete this file?", 'delete_file', [$(this).attr('data-id')]);
    });

    custom.find('.download').click(function(e) {
        e.preventDefault();
        window.open('download.php?id=' + $(this).attr('data-id'));
    });

    // Preview option click handler
	custom.find('.preview').click(function(e) {
    e.preventDefault();
    var fileId = $(this).attr('data-id');
    var fileName = $(this).attr('data-name');
    var filePath = $(this).attr('data-path');

    // Debugging logs
    console.log('Preview clicked');
    console.log('File ID:', fileId);
    console.log('File Name:', fileName);
    console.log('File Path:', filePath);

    if (!filePath) {
        console.error('File path is undefined. Check the .file-item element for a data-path attribute.');
        return; // Stop execution if filePath is undefined
    }

    // Prepend the folder path to the file path
    var fullPath = 'assets/uploads/' + filePath;

    var fileExtension = filePath.split('.').pop().toLowerCase();
    var allowedImageTypes = ['png', 'jpg', 'jpeg', 'gif'];
    var allowedPdfType = 'pdf';

    // Hide both the image and iframe initially
    $('#preview-image').hide();
    $('#preview-pdf').hide();

    if (allowedImageTypes.includes(fileExtension)) {
        // Show image preview
        $('#preview-image').attr('src', fullPath).show();
        $('#image-preview-modal').fadeIn(); // Ensure the modal is shown
    } else if (fileExtension === allowedPdfType) {
        // Show PDF preview
        $('#preview-pdf').attr('src', fullPath).show();
        $('#image-preview-modal').fadeIn(); // Ensure the modal is shown
    } else {
        alert('Preview not available for this file type.');
    }
});

    $('.rename_file').keypress(function(e) {
        var _this = $(this);
        if (e.which == 13) {
            start_load();
            $.ajax({
                url: 'ajax.php?action=file_rename',
                method: 'POST',
                data: {
                    id: $(this).attr('data-id'),
                    name: $(this).val(),
                    type: $(this).attr('data-type'),
                    folder_id: '<?php echo $folder_parent ?>'
                },
                success: function(resp) {
                    if (typeof resp != undefined) {
                        resp = JSON.parse(resp);
                        if (resp.status == 1) {
                            _this.siblings('large').find('b').html(resp.new_name);
                            end_load();
                            _this.hide();
                            _this.siblings('large').show();
                        }
                    }
                }
            });
        }
    });
});

//FILE
	$('.file-item').click(function(){
		if($(this).find('input.rename_file').is(':visible') == true)
    	return false;
		uni_modal($(this).attr('data-name'),'manage_files.php?<?php echo $folder_parent ?>&id='+$(this).attr('data-id'))
	})
	$(document).bind("click", function(event) {
    $("div.custom-menu").hide();
    $('#file-item').removeClass('active')

});
	$(document).keyup(function(e){

    if(e.keyCode === 27){
        $("div.custom-menu").hide();
    $('#file-item').removeClass('active')

    }

});
$(document).ready(function() {
    $('#search').keyup(function() {
        var searchVal = $(this).val().toLowerCase();

        $('tbody tr').each(function() {
            var rowText = $(this).text().toLowerCase(); // Get all text inside the row
            
            if (rowText.includes(searchVal)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});

	function delete_file($id){
		start_load();
		$.ajax({
			url:'ajax.php?action=delete_file',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp == 1){
					alert_toast("Folder successfully deleted.",'success')
						setTimeout(function(){
							location.reload()
						},1500)
				}
			}
		})
	}

	// Trigger the custom menu when the meatball button is clicked
		$('.meatball-menu-btn').click(function(event) {
			event.stopPropagation();  // Prevent event from bubbling up and closing the menu immediately

			// Hide any previously opened custom menus
			$("div.custom-menu").hide();

			// Get the file ID from the clicked button
			var fileId = $(this).attr('data-id');
			var custom = $("<div class='custom-menu file'></div>");  // Create the custom menu

			// Append the menu options and set file ID attributes
			custom.append($('#menu-file-clone').html());
			custom.find('.edit').attr('data-id', fileId);
			custom.find('.delete').attr('data-id', fileId);
			custom.find('.download').attr('data-id', fileId);
			custom.find('.preview')
				.attr('data-id', $(this).attr('data-id'))
				.attr('data-path', $(this).attr('data-path'))
				.attr('data-name', $(this).data('name'));

			// Append the custom menu to the body and position it
			custom.appendTo("body");
			custom.css({ top: event.pageY + "px", left: event.pageX + "px" });

			// Use event delegation to attach the click handlers for dynamically added menu items
			$('body').on('click', 'div.custom-menu .edit', function(e) {
				e.preventDefault();
				$('.rename_file[data-id="'+$(this).attr('data-id')+'"]').siblings('large').hide();
				$('.rename_file[data-id="'+$(this).attr('data-id')+'"]').show();
			});

			$('body').on('click', 'div.custom-menu .delete', function(e) {
				e.preventDefault();
				_conf("Are you sure to delete this file?", 'delete_file', [$(this).attr('data-id')]);
			});

			$('body').on('click', 'div.custom-menu .download', function(e) {
				e.preventDefault();
				window.open('download.php?id=' + $(this).attr('data-id'));
			});

			// Preview option click handler (with event delegation)
			$('body').on('click', 'div.custom-menu .preview', function(e) {
				e.preventDefault();
				var fileId = $(this).attr('data-id');
				var fileName = $(this).attr('data-name');
				var filePath = $(this).attr('data-path');

				// Debugging logs
				console.log('Preview clicked');
				console.log('File ID:', fileId);
				console.log('File Name:', fileName);
				console.log('File Path:', filePath);

				if (!filePath) {
					console.error('File path is undefined. Check the .file-item element for a data-path attribute.');
					return; // Stop execution if filePath is undefined
				}

				// Prepend the folder path to the file path
				var fullPath = 'assets/uploads/' + filePath;

				var fileExtension = filePath.split('.').pop().toLowerCase();
				var allowedImageTypes = ['png', 'jpg', 'jpeg', 'gif'];
				var allowedPdfType = 'pdf';

				// Hide both the image and iframe initially
				$('#preview-image').hide();
				$('#preview-pdf').hide();

				if (allowedImageTypes.includes(fileExtension)) {
					// Show image preview
					$('#preview-image').attr('src', fullPath).show();
					$('#image-preview-modal').fadeIn(); // Ensure the modal is shown
				} else if (fileExtension === allowedPdfType) {
					// Show PDF preview
					$('#preview-pdf').attr('src', fullPath).show();
					$('#image-preview-modal').fadeIn(); // Ensure the modal is shown
				} else {
					alert('Preview not available for this file type.');
				}
			});

			$('.rename_file').keypress(function(e) {
        var _this = $(this);
        if (e.which == 13) {
            start_load();
            $.ajax({
                url: 'ajax.php?action=file_rename',
                method: 'POST',
                data: {
                    id: $(this).attr('data-id'),
                    name: $(this).val(),
                    type: $(this).attr('data-type'),
                    folder_id: '<?php echo $folder_parent ?>'
                },
                success: function(resp) {
                    if (typeof resp != undefined) {
                        resp = JSON.parse(resp);
                        if (resp.status == 1) {
                            _this.siblings('large').find('b').html(resp.new_name);
                            end_load();
                            _this.hide();
                            _this.siblings('large').show();
                        }
                    }
                }
            });
        }
    });
		});

	// Close the menu if the user clicks anywhere outside
	$(document).click(function() {
		$("div.custom-menu").remove();  // Remove the custom menu
	});

	$(document).ready(function() {
    // Close modal when the close button (X) is clicked
    $('#image-preview-modal .close').click(function() {
        $('#image-preview-modal').fadeOut();  // Hide the modal
    });

    // Optionally, you can also close the modal when clicking outside the modal content
    $('#image-preview-modal').click(function(event) {
        if ($(event.target).is('#image-preview-modal')) {
            $(this).fadeOut();  // Hide the modal when clicking outside of it
        }
    });
});


</script>