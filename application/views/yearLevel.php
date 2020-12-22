<h1>Manage year level</h1>

<button class="btn btn-succes btn-outline-success btn-sm" id="createBtn"><i class="fas fa-plus"></i></button>
<br>&nbsp;
<div class="table table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Year Level Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 0 ?>
            <?php foreach ($yearLevelTable->result() as $row) { ?>
                <?php $counter++; ?>
                <tr>
                    <td><?= $counter ?></td>
                    <td><?= $row->year_level_name ?></td>
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
                <h4 class="modal-title w-100 font-weight-bold">Register Year Level</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <form action="" id="createForm">
                    <div class="md-form mb-4">
                        <i class="fas fa-level-up-alt prefix grey-text"></i>
                        <input type="text" id="yearLevel" autocomplete="off" autocapitalize="on" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="defaultForm-pass">Year Level Name</label>
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
                <h4 class="modal-title w-100 font-weight-bold">Register Year Level</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <form action="" id="updateForm">
                    <div class="form-group">
                        <label for="">Year Level Name</label>
                        <input type="text" id="yearLevelUpdate" class="form-control" placeholder="Enter Year level name">
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

<?php $createYearLevel = base_url() . "YearLevel/createYearLevel" ?>
<?php $refreshTable = base_url() . "YearLevel/refreshTable" ?>
<?php $deleteYearLevel = base_url() . "YearLevel/deleteYearLevel" ?>
<?php $getYearLevelInfo = base_url() . "YearLevel/getYearLevelInfo" ?>
<?php $updateYearLevel = base_url() . "YearLevel/updateYearLevel" ?>
<script>
    $(document).ready(function() {
        // refresh the table
        function refreshTable() {
            $('tbody').load("<?= $refreshTable ?>");
        }

        // submit update form was submitted
        $('#updateForm').submit(function(e) {
            e.preventDefault();

            // get the year level id
            var yearLevelId = $('#updateBtn').val();
            var yearLevelName = $('#yearLevelUpdate').val();

            // send post request to update the year level
            $.post("<?= $updateYearLevel ?>", {
                year_level_id: yearLevelId,
                year_level_name: yearLevelName
            }, function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Year level updated successfully',
                    showConfirmButton: false,
                    timer: 1500
                });

                // empty out the value of the input
                $('#yearLevelUpdate').val('');

                //close the modal
                $('#updateModal').modal('toggle');

                // refresh the table
                refreshTable();
            });
        });

        // update button was pressed 
        $(document).on('click', '.edit', function() {
            // get the year level id 
            var yearLevelId = $(this).val();

            //get the year level info using ajax
            $.post("<?= $getYearLevelInfo ?>", {
                year_level_id: yearLevelId
            }, function(data) {
                var yearLevelInfoJson = JSON.parse(data);

                var yearLevelName = yearLevelInfoJson[0].year_level_name;


                //change the value of the input field
                $('#yearLevelUpdate').val(yearLevelName);
            });

            //open the modal
            $('#updateModal').modal('toggle');

            // add a value to the updateBtn 
            $('#updateBtn').attr('value', yearLevelId);
        });

        // delete button is pressed
        $(document).on('click', '.delete', function() {
            // get the id the year level
            var yearLevelId = $(this).val();

            // add user notifications
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
                    $.post("<?= $deleteYearLevel ?>", {
                        year_level_id: yearLevelId
                    });

                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }

                // refresh the table
                refreshTable();
            })
        });

        $('#createBtn').click(function() {
            $('#createModal').modal('toggle');
        });

        //submit form was pressed
        $('#createForm').submit(function(e) {
            e.preventDefault();

            //get the input fields
            var yearLevel = $('#yearLevel').val();

            //make post request to the server creating the record
            $.post("<?= $createYearLevel ?>", {
                year_level: yearLevel
            }, function() {

                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                })

                //hide the modal
                $('#createModal').modal('toggle');

                //empty out the values of the input
                $('#yearLevel').val('');

                refreshTable();
            });
        });
    });
</script>