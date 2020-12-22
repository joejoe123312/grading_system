<h1>Manage Classes</h1>

<button class="btn btn-succes btn-outline-success btn-sm" id="createBtn"><i class="fas fa-plus"></i></button>
<br>&nbsp;
<div class="table table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Subject</th>
                <th>Teacher</th>
                <th>Year Level</th>
                <th>Sections</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 0 ?>
            <?php foreach ($classTable->result() as $row) { ?>
                <?php $counter++; ?>
                <tr>
                    <td><?= $counter ?></td>
                    <td><?= $this->Subject_model->maskSubject($row->subject_id) ?></td>
                    <td><?= $this->Main_model->getFullName('teachers', 'id', $row->teacher_id) ?></td>
                    <td><?= $this->YearLevelModel->maskYearLevel($row->year_level_id) ?></td>
                    <td><?= $this->Section_model->maskSection($row->section_id) ?></td>
                    <td style="display:flex">
                        <button class="btn btn-primary btn-sm edit" value="<?= $row->id ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm delete" value="<?= $row->id ?>"><i class="fas fa-trash"></i></button>
                        <button class="btn btn-dark btn-sm viewStudents" value="<?= $row->id ?>"><i class="fas fa-user"></i></button>
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
                <h4 class="modal-title w-100 font-weight-bold">Create Class</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <form action="" id="createForm">
                    <div class="form-group">
                        <label for="">Subject</label>
                        <select name="" id="subject" class="form-control">
                            <option value="">Select Subject</option>
                            <?php foreach ($subjectTable->result() as $row) { ?>
                                <option value="<?= $row->id ?>"><?= $row->subject_name ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Teacher</label>
                        <select name="" id="teacher" class="form-control">
                            <option value="">Select Teacher</option>
                            <?php foreach ($teacherTable->result() as $row) { ?>
                                <option value="<?= $row->id ?>"><?= $this->Main_model->getFullName('teachers', 'id', $row->id) ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Year level</label>
                        <select name="" id="yearLevel" class="form-control">
                            <option value="">Select Year Level</option>
                            <?php foreach ($yearLevelTable->result() as $row) { ?>
                                <option value="<?= $row->id ?>"><?= $row->year_level_name ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Section</label>
                        <select name="" id="section" class="form-control">
                            <option value="">Select Section</option>
                            <?php foreach ($sectionTable->result() as $row) { ?>
                                <option value="<?= $row->id ?>"><?= $row->section_name ?></option>
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

<!-- Update modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Update Class</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <form action="" id="updateForm">
                    <div class="form-group">
                        <label for="">Subject</label>
                        <select name="" id="subjectUpdate" class="form-control">
                            <option value="">Select Subject</option>
                            <!-- <option value="" id="chosenSubject"></option> -->
                            <?php foreach ($subjectTable->result() as $row) { ?>
                                <option value="<?= $row->id ?>"><?= $row->subject_name ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Teacher</label>
                        <select name="" id="teacherUpdate" class="form-control">
                            <option value="">Select Teacher</option>
                            <!-- <option value="" id="chosenTeacher"></option> -->
                            <?php foreach ($teacherTable->result() as $row) { ?>
                                <option value="<?= $row->id ?>"><?= $this->Main_model->getFullName('teachers', 'id', $row->id) ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Year level</label>
                        <select name="" id="yearLevelUpdate" class="form-control">
                            <option value="">Select Year Level</option>
                            <!-- <option value="" id="chosenYearLevel"></option> -->
                            <?php foreach ($yearLevelTable->result() as $row) { ?>
                                <option value="<?= $row->id ?>"><?= $row->year_level_name ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Section</label>
                        <select name="" id="sectionUpdate" class="form-control">
                            <option value="">Select Section</option>
                            <?php foreach ($sectionTable->result() as $row) { ?>
                                <option value="<?= $row->id ?>"><?= $row->section_name ?></option>
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
<!-- Update modal -->


<!-- View students modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Class Students</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">


                <!--Make sure the form has the autocomplete function switched off:-->
                <div id="autocompleteStudents" align="center">
                    <form autocomplete="off" id="addStudentsForm">
                        <div class="autocomplete col-md-8">
                            <input id="myInput" type="text" name="myCountry" placeholder="Search to add students">
                        </div>
                        <button type="submit" class="btn btn-outline-success" id="addStudentsBtn"><i class="fas fa-plus"></i></button>
                    </form>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-hoevered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Section</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="classStudents">
                            <!-- Filled by ajax -->
                        </tbody>
                    </table>
                </div>

            </div>

            </form>
        </div>
    </div>
</div>
<!-- View students modal -->





<?php $createClass = base_url() . "Classes/createClass" ?>
<?php $refreshTable = base_url() . "Classes/refreshTable" ?>
<?php $deleteClass = base_url() . "Classes/deleteClass" ?>
<?php $getInfo = base_url() . "Classes/getInfo" ?>
<?php $update = base_url() . "Classes/update" ?>

<?php $maskSubjectId = base_url() . "Classes/maskSubjectId" ?>
<?php $maskYearLevel = base_url() . "Classes/maskYearLevel" ?>
<?php $maskTeacher = base_url() . "Classes/maskTeacher" ?>
<?php $getAllStudents = base_url() . "Classes/getAllStudents" ?>

<?php $insertIntoClass = base_url() . "Classes/insertIntoClass" ?>
<?php $refreshStudentTable = base_url() . "Classes/refreshStudentTable" ?>
<?php $deleteClassStudent = base_url() . "Classes/deleteClassStudent" ?>


<!-- Autocomplete script -->
<script src="<?= base_url() . "assets/js/autocompleteStudents.js" ?>"></script>
<script>
    function refreshStudentTable(classId) {
        $.post("<?= $refreshStudentTable ?>", {
            class_id: classId
        }, function(data) {
            $('#classStudents').html(data);
        });
    }

    $(document).ready(function() {


        $(document).on('click', '.deleteStudent', function() {
            var classGroupId = $(this).val();

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

                    // submit delete request to the server 
                    $.post("<?= $deleteClassStudent ?>", {
                        class_group_id: classGroupId
                    }, function(classId) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                        console.log(classId);
                        refreshStudentTable(classId);
                    });
                }
            });


        });

        // get all of the students
        $.post("<?= $getAllStudents ?>", {
            student: 1
        }, function(data) {
            var studentName = JSON.parse(data);

            autocomplete(document.getElementById("myInput"), studentName);
        });

        $('#addStudentsForm').submit(function(e) {
            e.preventDefault();

            var fullName = $('#myInput').val();
            var classId = $('#addStudentsBtn').val();

            // submit post request to the server
            $.post("<?= $insertIntoClass ?>", {
                fullname: fullName,
                class_id: classId
            }, function() {

                // empty out the student autocomplete 
                $('#myInput').val('');

                // refresh the table 
                refreshStudentTable(classId);
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        function refreshTable() {
            $('tbody').load("<?= $refreshTable ?>");
        }



        $(document).on("click", '.viewStudents', function() {

            $('#viewModal').modal('toggle');

            // get the class id
            var classId = $(this).val();

            // store the class id into the myInputButton
            $('#addStudentsBtn').attr('value', classId);

            // update the td of the table 
            refreshStudentTable(classId);


        });

        $('#updateForm').submit(function(e) {
            e.preventDefault();

            // get class id
            var classId = $('#updateBtn').val();

            //get the input forms values 
            var subjectId = $("#subjectUpdate").val();
            var teacherId = $("#teacherUpdate").val();
            var yearLevelId = $("#yearLevelUpdate").val();
            var sectionId = $("#sectionUpdate").val();

            //submit post request to update the value
            $.post("<?= $update ?>", {
                class_id: classId,
                subject_id: subjectId,
                teacher_id: teacherId,
                year_level_id: yearLevelId,
                section_id: sectionId
            }, function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Class updated successfully',
                    showConfirmButton: false,
                    timer: 1500
                });

                refreshTable();

                //close the modal 
                $('#updateModal').modal('toggle');
            });
        });

        // edit button 
        $(document).on('click', '.edit', function() {
            var classId = $(this).val();

            // obtain info about the class
            $.post("<?= $getInfo ?>", {
                class_id: classId
            }, function(data) {
                var classInfo = JSON.parse(data);

                // mask subject name
                var subjectId = classInfo[0].subject_id;
                $.post("<?= $maskSubjectId ?>", {
                    subject_id: subjectId
                }, function(data) {
                    var subjectName = data;

                    //change the values of the drop down menu
                    $('#subjectUpdate').val(subjectId);

                    // //change the text inside the option 
                    // $('#chosenSubject').text(subjectName);
                });

                // mask and change the values 
                // mask year level
                var yearLevelId = classInfo[0].year_level_id;
                $.post("<?= $maskYearLevel ?>", {
                    year_level_id: yearLevelId
                }, function(data) {
                    var yearLevelName = data;

                    //change the values of the drop down menu
                    $('#yearLevelUpdate').val(yearLevelId);

                    //change the text inside the option 
                    // $('#chosenYearLevel').text(yearLevelName);
                });

                // mask year level
                var teacherId = classInfo[0].teacher_id;
                $.post("<?= $maskTeacher ?>", {
                    teacher_id: teacherId
                }, function(data) {
                    var teacherName = data;

                    //change the values of the drop down menu
                    $('#teacherUpdate').val(teacherId);

                    //change the text inside the option 
                    // $('#chosenTeacher').text(teacherName);
                });

                // change the value of the section drop down menu
                var sectionId = classInfo[0].section_id;
                $("#sectionUpdate").val(sectionId);

                //change the value of the btn 
                $('#updateBtn').attr('value', classId);

                // open update modal
                $('#updateModal').modal('toggle');
            });
        });

        // delete button 
        $(document).on('click', '.delete', function() {
            //get the class id
            var classId = $(this).val();

            // fire confirmation message
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

                    // perform request to the server
                    $.post("<?= $deleteClass ?>", {
                        class_id: classId
                    }, function() {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );

                        // refresh the table
                        refreshTable();
                    });
                }
            })


        });

        // create class
        $('#createForm').submit(function(e) {
            e.preventDefault();

            // get the values of the inputs
            var subjectId = $('#subject').val();
            var teacherId = $('#teacher').val();
            var yearLevelId = $('#yearLevel').val();
            var sectionId = $("#section").val();

            // create post request to the server 
            $.post("<?= $createClass ?>", {
                subject_id: subjectId,
                teacher_id: teacherId,
                year_level_id: yearLevelId,
                section_id: sectionId
            }, function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Class created successfully',
                    showConfirmButton: false,
                    timer: 1500
                });

                // close the modal
                $('#createModal').modal('toggle');
            });

            refreshTable();
        });

        // create button pressed launch modal 
        $('#createBtn').click(function() {
            $('#createModal').modal('toggle');
        });
    });
</script>