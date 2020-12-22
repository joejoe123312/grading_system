<h1>Manage Sections</h1>

<button class="btn btn-succes btn-outline-success btn-sm" id="createBtn"><i class="fas fa-plus"></i></button>
<br>&nbsp;
<div class="table table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Section Name</th>
                <th>Year Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 0 ?>
            <?php foreach ($sectionTable->result() as $row) { ?>
                <?php $counter++; ?>
                <tr>
                    <td><?= $counter ?></td>
                    <td><?= $row->section_name ?></td>
                    <td><?= $this->YearLevelModel->maskYearLevel($row->year_level_id) ?></td>
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
                <h4 class="modal-title w-100 font-weight-bold">Register Section</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <form action="" id="createForm">
                    <div class="form-group">
                        <label for="">Section Name</label>
                        <input type="text" placeholder="Enter Section name" id="sectionName" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Year Level</label>
                        <select name="" id="yearLevel" class="form-control">
                            <option value="">Select year level</option>
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
                <h4 class="modal-title w-100 font-weight-bold">Update Section</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <form action="" id="updateForm">
                    <div class="form-group">
                        <label for="">Section Name</label>
                        <input type="text" placeholder="Enter Section name" id="sectionNameUpdate" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Year Level</label>
                        <select name="" id="yearLevelUpdate" class="form-control">
                            <option value="" id="yearLevelChoice">Select year level</option>
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

<?php $createSectionName = base_url() . "Section/createSectionName" ?>
<?php $refreshTable = base_url() . "Section/refreshTable" ?>
<?php $deleteSection = base_url() . "Section/deleteSection" ?>
<?php $getSectionIfo = base_url() . "Section/getSectionIfo" ?>
<?php $maskYearLevel = base_url() . "Section/maskYearLevel" ?>
<?php $updateSection = base_url() . "Section/updateSection" ?>

<script>
    $(document).ready(function() {
        //refresh the table
        function refreshTable() {
            $('tbody').load("<?= $refreshTable ?>");
        }

        // update form submit
        $('#updateForm').submit(function(e) {
            e.preventDefault();

            // get the section id using the value of the butotn
            var sectionId = $('#updateBtn').val();

            // get the values of the the input fields
            var sectionName = $('#sectionNameUpdate').val();
            var yearLevelId = $('#yearLevelUpdate').val();

            // perform post request to the sever
            $.post("<?= $updateSection ?>", {
                section_id: sectionId,
                year_level_id: yearLevelId,
                section_name: sectionName
            }, function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                });

                //close the modal 
                $('#updateModal').modal('toggle');

                // reset the values of the input fields
                $('#sectionNameUpdate').val();

                // refresh the table
                refreshTable();
            });
        });

        // edit button was pressed
        $(document).on('click', '.edit', function() {
            // get the section id
            var sectionId = $(this).val();

            // open the modal
            $('#updateModal').modal('toggle');

            // change the value of the input fields
            $.post("<?= $getSectionIfo ?>", {
                section_id: sectionId
            }, function(data) {
                var sectionInfo = JSON.parse(data);

                var sectionName = sectionInfo[0].section_name;
                var yearLevelId = sectionInfo[0].year_level_id;

                $('#sectionNameUpdate').val(sectionName);
                $('#yearLevelChoice').val(yearLevelId);

                // mask the year level id into year level name
                $.post("<?= $maskYearLevel ?>", {
                    year_level_id: yearLevelId
                }, function(yearLevelName) {

                    $('#yearLevelChoice').text(yearLevelName);
                });

                // change the value of the button
                $('#updateBtn').val(sectionId);
            });
        });


        //delete button was pressed
        $(document).on('click', '.delete', function() {
            //get the section id using value of the button
            var sectionId = $(this).val();

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
                    //send post request
                    $.post("<?= $deleteSection ?>", {
                        section_id: sectionId
                    }, function() {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                    });

                    //refresh the table
                    refreshTable();
                }
            });
        });

        //create form was submitted
        $('#createForm').submit(function(e) {
            e.preventDefault();

            //get the value of the input field
            var sectionName = $('#sectionName').val();
            var yearLevelId = $('#yearLevel').val();

            // craete post request to the server 
            $.post("<?= $createSectionName ?>", {
                section_name: sectionName,
                year_level_id: yearLevelId
            }, function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Section created successfully',
                    showConfirmButton: false,
                    timer: 1500
                });

                //close the modal
                $('#createModal').modal('toggle');

                //empty out input fields
                $('#sectionName').val('');

                //refresh the table
                refreshTable();
            });
        });

        $('#createBtn').click(function() {
            $('#createModal').modal('toggle');
        });
    });
</script>