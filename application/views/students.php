<h1>Manage Students</h1>

<button class="btn btn-succes btn-outline-success btn-sm" id="createBtn"><i class="fas fa-plus"></i></button>
<br>&nbsp;
<div class="table table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Year Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 0 ?>
            <?php foreach ($studentsTable->result() as $row) { ?>
                <?php $counter++; ?>
                <tr>
                    <td><?= $counter ?></td>
                    <td><?= $row->firstname ?></td>
                    <td><?= $row->middlename ?></td>
                    <td><?= $row->lastname ?></td>
                    <td><?= $this->YearLevelModel->maskYearLevel($row->year_level_id) ?></td>
                    <td style="display:flex">
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
                <h4 class="modal-title w-100 font-weight-bold">Create Student Record</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <form id="createForm">
                    <div class="form-group">
                        <label for="">First name</label>
                        <input type="text" id="firstname" class="form-control" placeholder="Enter First name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Middle name</label>
                        <input type="text" id="middlename" class="form-control" placeholder="Enter Middle name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Last name</label>
                        <input type="text" id="lastname" class="form-control" placeholder="Enter Last name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Year Level</label>
                        <select name="" id="yearLevel" class="form-control">
                            <option value="">Select Year Level</option>
                            <?php foreach ($yearLevelTable->result() as $row) { ?>
                                <option value="<?= $row->id ?>"><?= $row->year_level_name ?></option>
                            <?php } ?>
                        </select>
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

<!-- Create modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Update Student Record</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <form id="updateForm">
                    <div class="form-group">
                        <label for="">First name</label>
                        <input type="text" id="firstnameUpdate" class="form-control" placeholder="Enter First name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Middle name</label>
                        <input type="text" id="middlenameUpdate" class="form-control" placeholder="Enter Middle name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Last name</label>
                        <input type="text" id="lastnameUpdate" class="form-control" placeholder="Enter Last name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Year Level</label>
                        <select name="" id="yearLevelUpdate" class="form-control">
                            <option value="">Select Year Level</option>
                            <?php foreach ($yearLevelTable->result() as $row) { ?>
                                <option value="<?= $row->id ?>"><?= $row->year_level_name ?></option>
                            <?php } ?>
                        </select>
                    </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-default" type="submit" id="updateBtn">UPDATE</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Create modal -->

<?php $refreshTable = base_url() . "Students/refreshTable" ?>
<?php $create = base_url() . "Students/create" ?>
<?php $delete = base_url() . "Students/delete" ?>
<?php $studentInfo = base_url() . "Students/studentInfo" ?>
<?php $update = base_url() . "Students/update" ?>

<script>
    $(document).ready(function() {
        // create button was pressed
        $('#createBtn').click(function() {
            $('#createModal').modal('toggle');
        });

        function refreshTable() {
            $('tbody').load("<?= $refreshTable ?>");
        }

        // update submit button pressed
        $('#updateForm').submit(function(e) {
            e.preventDefault();

            // get the values 
            let studentId = $('#updateBtn').val();
            let firstname = $('#firstnameUpdate').val();
            let middlename = $('#middlenameUpdate').val();
            let lastname = $('#lastnameUpdate').val();
            let yearLevel = $('#yearLevelUpdate').val();


            //send update form to the database
            $.post("<?= $update ?>", {
                student_id: studentId,
                fName: firstname,
                mName: middlename,
                lName: lastname,
                year_level_id: yearLevel,
                full_name: firstname + ' ' + middlename + ' ' + lastname

            }, function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Student updated successfully',
                    showConfirmButton: false,
                    timer: 1500
                });

                //update the table
                refreshTable();

                //close the modal
                $('#updateModal').modal('toggle');
            });
        });

        $(document).on('click', '.edit', function() {
            var studentId = $(this).val();

            // get student info     
            $.post("<?= $studentInfo ?>", {
                student_id: studentId
            }, function(info) {
                var studentInfo = JSON.parse(info);

                var firstname = studentInfo[0].firstname;
                var middlename = studentInfo[0].middlename;
                var lastname = studentInfo[0].lastname;
                var yearLevelId = studentInfo[0].year_level_id;

                // change the values of the update form 
                $('#firstnameUpdate').val(firstname);
                $('#middlenameUpdate').val(middlename);
                $('#lastnameUpdate').val(lastname);
                $('#yearLevelUpdate').val(yearLevelId);

                // change the value of the button 
                $('#updateBtn').attr('value', studentId);

                //launch the modal 
                $('#updateModal').modal('toggle');
            });
        });

        // delete
        $(document).on('click', '.delete', function() {
            var studentId = $(this).val();

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

                    //submit post request
                    $.post("<?= $delete ?>", {
                        student_id: studentId
                    }, function() {
                        Swal.fire(
                            'Deleted!',
                            'Student record deleted',
                            'success'
                        );

                        //refresh the table
                        refreshTable();
                    });
                }
            })
        });

        // create student form submit
        $('#createForm').submit(function(e) {
            e.preventDefault();

            // get all of the values of the input field
            var firstname = $('#firstname').val();
            var middlename = $('#middlename').val();
            var lastname = $('#lastname').val();
            var yearLevelId = $('#yearLevel').val();

            // submit a post request to create record
            $.post("<?= $create ?>", {
                fname: firstname,
                mname: middlename,
                lname: lastname,
                year_level_id: yearLevelId,
                full_name: firstname + ' ' + middlename + ' ' + lastname
            }, function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Student recorded successfully',
                    showConfirmButton: false,
                    timer: 1500
                });

                // reset the value of the create input field
                $('#firstname').val('');
                $('#middlename').val('');
                $('#lastname').val('');

                //refresh table
                refreshTable();

                // close modal
                $('#createModal').modal('toggle');
            });
        });
    });
</script>