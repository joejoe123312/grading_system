<h1>Manage Teacher Accounts</h1>

<br>
<button type="button" class="btn btn-outline-success btn-rounded btn-sm" id="registerBtn">
    <i class="fas fa-plus"></i>
</button>


<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Register Teacher</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="registerForm">
                <div class="modal-body mx-3">
                    <div class="form-group">
                        <label for="">First Name</label>
                        <input type="text" id="firstnameReg" placeholder="First Name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Middle Name</label>
                        <input type="text" id="middlenameReg" placeholder="Middle Name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Last Name</label>
                        <input type="text" id="lastnameReg" placeholder="Last Name" class="form-control">
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-deep-orange" type="submit">REGISTER</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Update Teacher data -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Update Teacher's Info</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="updateForm">
                <div class="modal-body mx-3">

                    <div class="form-group">
                        <label for="">First Name</label>
                        <input type="text" id="firstnameUpdate" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Middle Name</label>
                        <input type="text" id="middlenameUpdate" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Last Name</label>
                        <input type="text" id="lastnameUpdate" class="form-control">
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-deep-orange" type="submit" id="updateBtn">UPDATE</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Update teacher data -->

<div style="margin-bottom:20px"></div>
<div class="table table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 0 ?>
            <?php foreach ($teacherTable->result() as $row) { ?>
                <?php $counter++; ?>
                <tr>
                    <td><?= $counter ?></td>
                    <td><?= ucfirst($row->firstname) ?></td>
                    <td><?= ucfirst($row->middlename) ?></td>
                    <td><?= ucfirst($row->lastname) ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm edit" value="<?= $row->id ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm delete" value="<?= $row->id ?>"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php $registerTeacher = base_url() . "Teachers/registerTeacher" ?>
<?php $refreshTeacherTable = base_url() . "Teachers/refreshTeacherTable" ?>
<?php $deleteTeacher = base_url() . "Teachers/deleteTeacher" ?>
<?php $getTeacherData = base_url() . "Teachers/getTeacherData" ?>
<?php $updateTeacherInfo = base_url() . "Teachers/updateTeacherInfo" ?>

<script>
    $(document).ready(function() {

        //refresh table
        function refreshTeacherTable() {
            $('tbody').load("<?= $refreshTeacherTable ?>");
        }

        // update form 
        $('#updateForm').submit(function() {
            //get the values of the form fields
            var firstname = $('#firstnameUpdate').val();
            var middlename = $('#middlenameUpdate').val();
            var lastname = $('#lastnameUpdate').val();
            var teacherId = $('#updateBtn').val();

            //send post request to the server updating the attributes of the db
            $.post("<?= $updateTeacherInfo ?>", {
                teacher_id: teacherId,
                first_name: firstname,
                middle_name: middlename,
                last_name: lastname
            }, function(data) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: data + ' Has been updated',
                    showConfirmButton: false,
                    timer: 1500
                });

                // cloase the modal
                $('#updateModal').modal('toggle');

                refreshTeacherTable();

            });
        });

        //update the table
        $(document).on('click', '.edit', function() {
            // get the teacher if by value of the button
            var teacherId = $(this).val();

            // get the info of the teacher using post 
            $.post("<?= $getTeacherData ?>", {
                teacher_id: teacherId
            }, function(data) {

                // parse the json data
                var teacherInfo = JSON.parse(data);

                // disect the data and store it in variables
                var firstname = teacherInfo[0].firstname;
                var middlename = teacherInfo[0].middlename;
                var lastname = teacherInfo[0].lastname;

                //change the value of the inputs
                $('#firstnameUpdate').val(firstname);
                $('#middlenameUpdate').val(middlename);
                $('#lastnameUpdate').val(lastname);

                // add attr to button updateBtn value
                $('#updateBtn').attr('value', teacherId);

                //toggle the modal
                $('#updateModal').modal('toggle');


            });


        });

        //delete a row in the table
        $(document).on('click', '.delete', function() {
            //get the value of the pressed button 
            var teacherId = $(this).val();

            //send post request to delete the selected teacher but notify the user

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
                    //send post data to delete the row in the db.table
                    $.post("<?= $deleteTeacher ?>", {
                        teacher_id: teacherId
                    }, function() {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );

                        //refresh the table
                        refreshTeacherTable();
                    });
                }
            })
        });

        $('#registerBtn').click(function() {
            $('#registerModal').modal('toggle');
        });

        //register teacher's account
        $('#registerForm').submit(function(e) {
            e.preventDefault();

            //get the inputs
            var firstname = $('#firstnameReg').val();
            var middlename = $('#middlenameReg').val();
            var lastname = $('#lastnameReg').val();

            //send post request to the server
            $.post("<?= $registerTeacher ?>", {
                first_name: firstname,
                middle_name: middlename,
                last_name: lastname
            }, function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Teacher successfully registered',
                    showConfirmButton: false,
                    timer: 1500
                });

                //refresh the table
                refreshTeacherTable();

                //reset the values of the input field
                $('#firstnameReg').val("");
                $('#middlenameReg').val("");
                $('#lastnameReg').val("");

                //toggle back the modal
                $('#registerModal').modal("toggle");
            });
        });

    });
</script>