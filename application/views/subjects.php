<h1>Manage Subjects</h1>


<button class="btn btn-succes btn-outline-success btn-sm" id="createBtn"><i class="fas fa-plus"></i></button>
<br>&nbsp;
<div class="table table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Subject name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 0 ?>
            <?php foreach ($subjectTable->result() as $row) { ?>
                <?php $counter++; ?>
                <tr>
                    <td><?= $counter ?></td>
                    <td><?= $this->Subject_model->maskSubject($row->id) ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm edit" value="<?= $row->id ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm delete" value="<?= $row->id ?>"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<!-- Create modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Create Subject</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <form action="" id="createForm">
                    <div class="form-group">
                        <label for="">Subject name</label>
                        <input type="text" name="" placeholder="Enter Subject name" id="subjectName" class="form-control">
                    </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-default" type="submit">SUBMIT</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Create modal -->

<!-- Update modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Update Subject</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <form action="" id="updateForm">
                    <div class="form-group">
                        <label for="">Subject name</label>
                        <input type="text" name="" placeholder="Enter Subject name" id="subjectNameUpdate" class="form-control">
                    </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-default" type="submit" id="updateBtn">UPDATE</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Update modal -->

<?php $createSubject = base_url() . "Subjects/createSubject" ?>
<?php $refreshTable = base_url() . "Subjects/refreshTable" ?>
<?php $deleteSubject = base_url() . "Subjects/deleteSubject" ?>
<?php $getSubjectInfo = base_url() . "Subjects/getSubjectInfo" ?>
<?php $updateSubject = base_url() . "Subjects/updateSubject" ?>

<script>
    $(document).ready(function() {
        // refresh table
        function refreshTable() {
            $('tbody').load("<?= $refreshTable ?>");
        }

        // update form was submitted by the user
        $('#updateForm').submit(function(e) {
            e.preventDefault();

            var subjectId = $('#updateBtn').val();
            var subjectName = $('#subjectNameUpdate').val();

            // send post request to the server
            $.post("<?= $updateSubject ?>", {
                subject_id: subjectId,
                subject_name: subjectName
            }, function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Subject updated successfully',
                    showConfirmButton: false,
                    timer: 1500
                });

                //refresh the table
                refreshTable();

                // close the modal
                $('#updateModal').modal('toggle');
            });
        });

        // update button press
        $(document).on('click', '.edit', function() {

            // get the subject id using the value of the button
            var subjectId = $(this).val();

            // get the info about the subject
            $.post("<?= $getSubjectInfo ?>", {
                subject_id: subjectId
            }, function(data) {

                //change the value of the input field
                $('#subjectNameUpdate').val(data);
            });

            // change the value of the button by subject id
            $('#updateBtn').val(subjectId);

            // show the modal
            $('#updateModal').modal('toggle');
        });

        // delete button 
        $(document).on('click', '.delete', function() {
            var subjectId = $(this).val();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    // send post request that will delete that row in the db. 
                    $.post("<?= $deleteSubject ?>", {
                        subject_id: subjectId
                    }, function() {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );

                        //refresh the table
                        refreshTable();
                    });
                }
            })
        });

        // create button pressed launch modal 
        $('#createBtn').click(function() {
            $('#createModal').modal('toggle');
        });

        // create subject
        $('#createForm').submit(function(e) {
            e.preventDefault();

            //get the value of the input field 
            var subjectName = $('#subjectName').val();

            // create a post request
            $.post("<?= $createSubject ?>", {
                subject_name: subjectName
            }, function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Subject created successfully',
                    showConfirmButton: false,
                    timer: 1500
                });

                // refresh the table
                refreshTable();

                // reset the values of the input fields
                $('#subjectName').val('');

                // close the modal 
                $('#createModal').modal('toggle');

            });
        });
    });
</script>