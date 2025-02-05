folder_parentpath<?php 
include 'db_connect.php';
$folder_parent = isset($_GET['fid'])? $_GET['fid'] : 0;
$folders = $conn->query("SELECT * FROM folders where parent_id = $folder_parent and user_id = '".$_SESSION['login_id']."'  order by name asc");


$files = $conn->query("SELECT * FROM files where folder_id = $folder_parent and user_id = '".$_SESSION['login_id']."'  order by name asc");

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



</style>
<div class="container-fluid"><br><br>
	<div class="col-lg-12">
		<div class="row">
			<div class="card col-lg-12">
				<div class="card-body" id="paths">
				<!-- <a href="index.php?page=files" class="">..</a>/ -->
				<?php 
				$id=$folder_parent;
				while($id > 0){

					$path = $conn->query("SELECT * FROM folders where id = $id  order by name asc")->fetch_array();
					echo '<script>
						$("#paths").prepend("<a href=\"index.php?page=files&fid='.$path['id'].'\">'.$path['name'].'</a>/")
					</script>';
					$id = $path['parent_id'];

				}
				echo '<script>
						$("#paths").prepend("<a href=\"index.php?page=files\">..</a>/")
					</script>';
				?>
					
				</div>
			</div>
			
		</div>
		<br>
		<div class="row">
			<button class="btn btn-primary btn-sm" id="new_folder"><i class="fa fa-plus"></i> New Folder</button>
			<button class="btn btn-primary btn-sm ml-4" id="new_file"><i class="fa fa-upload"></i> Upload File</button>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-12">
			<div class="col-md-4 col-10 offset-md-4 offset-1 input-group">
			<input type="text" class="form-control" id="search" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
			<div class="input-group-append">
				<span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
			</div>
			</div>

			</div>
		</div>
		<div class="row">
			<div class="col-md-12"><h4><b>Folders</b></h4></div>
		</div>
		<hr>
		<div class="row">
			<?php 
			while($row=$folders->fetch_assoc()):
			?>
				<div class="card col-md-3 mt-2 ml-2 mr-2 mb-2 folder-item" data-id="<?php echo $row['id'] ?>">
					<div class="card-body">
							<large><span><i class="fa fa-folder"></i></span><b class="to_folder"> <?php echo $row['name'] ?></b></large>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
		<hr>
		<div class="row">
			<div class="card col-md-12">
				<div class="card-body">
					<!-- Scrollable container -->
					<div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
						<table width="100%" class="table-responsive">
							<tr>
								<th width="40%" class="">Filename</th>
								<th width="20%" class="">Date</th>
								<th width="20%" class="">Description</th>
								<th width="20%" class="">Action</th>
							</tr>
							<?php 
							while($row=$files->fetch_assoc()):
								$name = explode(' ||',$row['name']);
								$name = isset($name[1]) ? $name[0] ." (".$name[1].").".$row['file_type'] : $name[0] .".".$row['file_type'];
								$img_arr = array('png','jpg','jpeg','gif','psd','tif');
								$doc_arr =array('doc','docx');
								$pdf_arr =array('pdf','ps','eps','prn');
								$icon ='fa-file';
								if(in_array(strtolower($row['file_type']),$img_arr))
									$icon ='fa-image';
								if(in_array(strtolower($row['file_type']),$doc_arr))
									$icon ='fa-file-word';
								if(in_array(strtolower($row['file_type']),$pdf_arr))
									$icon ='fa-file-pdf';
								if(in_array(strtolower($row['file_type']),['xlsx','xls','xlsm','xlsb','xltm','xlt','xla','xlr']))
									$icon ='fa-file-excel';
								if(in_array(strtolower($row['file_type']),['zip','rar','tar']))
									$icon ='fa-file-archive';
							?>
							<tr class='file-item' data-id="<?php echo $row['id'] ?>" data-name="<?php echo $name ?>" data-path="<?php echo $row['file_path'] ?>">
								
								<td><large><span><i class="fa <?php echo $icon ?>"></i></span><b class="to_file"> <?php echo $name ?></b></large>
								<input type="text" class="rename_file" value="<?php echo $row['name'] ?>" data-id="<?php echo $row['id'] ?>" data-type="<?php echo $row['file_type'] ?>" data-path="<?php echo $row['file_path'] ?>" style="display: none">
								</td>
								<td><i class="to_file"><?php echo date('Y/m/d h:i A',strtotime($row['date_updated'])) ?></i></td>
								<td><i class="to_file"><?php echo $row['description'] ?></i></td>
								<td>
									<!-- Meatball menu (three vertical dots) -->
									<button class="meatball-menu-btn" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $name ?>" data-path="<?php echo $row['file_path'] ?>"><i class="fa fa-ellipsis-h"></i></button>
								</td>
							</tr>
							<?php endwhile; ?>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<!-- <div id="menu-folder-clone" style="display: none;">
	<a href="javascript:void(0)" class="custom-menu-list file-option edit">Rename</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option delete">Delete</a>
</div>
<div id="menu-file-clone" style="display: none;">
	<a href="javascript:void(0)" class="custom-menu-list file-option edit"><span><i class="fa fa-edit"></i> </span>Rename</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option download"><span><i class="fa fa-download"></i> </span>Download</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option delete"><span><i class="fa fa-trash"></i> </span>Delete</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option preview"><span><i class="fa fa-eye"></i> </span>Preview</a>
</div> -->
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
	
	$('#new_folder').click(function(){
		uni_modal('','manage_folder.php?fid=<?php echo $folder_parent ?>')
	})
	$('#new_file').click(function(){
		uni_modal('','manage_files.php?fid=<?php echo $folder_parent ?>')
	})
	$('.folder-item').click(function(){
		location.href = 'index.php?page=files&fid='+$(this).attr('data-id')
	})
	
	$('.folder-item').bind("contextmenu", function(event) { 
		event.preventDefault();
		$("div.custom-menu").hide();
		var custom = $("<div class='custom-menu'></div>");
		custom.append($('#menu-folder-clone').html());
		custom.find('.edit').attr('data-id',$(this).attr('data-id'));
		custom.find('.delete').attr('data-id',$(this).attr('data-id'));
		
		// Check login type and disable delete if not admin (login_type != 1)
		if (loginType != 1) {
			custom.find('.delete').hide();  // Hide delete button for non-admin users
		}

		custom.appendTo("body");
		custom.css({top: event.pageY + "px", left: event.pageX + "px"});

		$("div.custom-menu .edit").click(function(e){
			e.preventDefault();
			uni_modal('Rename Folder','manage_folder.php?fid=<?php echo $folder_parent ?>&id='+$(this).attr('data-id') );
		});

		$("div.custom-menu .delete").click(function(e){
			e.preventDefault();
			_conf("Are you sure to delete this Folder?", 'delete_folder', [$(this).attr('data-id')]);
		});
	});

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
	$(document).ready(function(){
		$('#search').keyup(function(){
			var _f = $(this).val().toLowerCase()
			$('.to_folder').each(function(){
				var val  = $(this).text().toLowerCase()
				if(val.includes(_f))
					$(this).closest('.card').toggle(true);
					else
					$(this).closest('.card').toggle(false);

				
			})
			$('.to_file').each(function(){
				var val  = $(this).text().toLowerCase()
				if(val.includes(_f))
					$(this).closest('tr').toggle(true);
					else
					$(this).closest('tr').toggle(false);

				
			})
		})
	})
	function delete_folder($id){
		start_load();
		$.ajax({
			url:'ajax.php?action=delete_folder',
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