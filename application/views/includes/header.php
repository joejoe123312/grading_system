<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grading system</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

    <!-- Adjustments -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/adjustments.css">


    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Autocomplete students -->
    <?php $autocompleteStudents = base_url() . "assets/css/" ?>
    <link rel="stylesheet" href="<?= $autocompleteStudents ?>studentsAutocomplete.css">
</head>

<body>

    <div class="container">
        <div style="margin-bottom:20px"></div>
        <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark ">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarLeftAlignExample" aria-controls="navbarLeftAlignExample" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarLeftAlignExample">
                    <!-- Left links -->
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <?php $dashboard = base_url() . "Dashboard" ?>
                            <a class="nav-link active" aria-current="page" href="<?= $dashboard ?>">Home</a>
                        </li>

                        <?php
                        // $this->load->model('Credentials_model');

                        $userType = $this->Credentials_model->getUserType();
                        ?>

                        <?php if ($userType == 3) { ?>


                            <li class="nav-item">
                                <?php $Teachers = base_url() . "Teachers" ?>
                                <a class="nav-link" href="<?= $Teachers ?>">Teachers</a>
                            </li>
                            <li class="nav-item">
                                <?php $students = base_url() . "Students" ?>
                                <a class="nav-link" href="<?= $students ?>">Students</a>
                            </li>
                            <li class="nav-item">
                                <?php $yearLevel = base_url() . "YearLevel" ?>
                                <a class="nav-link" href="<?= $yearLevel ?>">Year Level</a>
                            </li>
                            <li class="nav-item">
                                <?php $Subjects = base_url() . "Subjects" ?>
                                <a class="nav-link" href="<?= $Subjects ?>">Subjects</a>
                            </li>
                            <li class="nav-item">
                                <?php $Sections = base_url() . "Section" ?>
                                <a class="nav-link" href="<?= $Sections ?>">Sections</a>
                            </li>
                            <li class="nav-item">
                                <?php $Classes = base_url() . "Classes" ?>
                                <a class="nav-link" href="<?= $Classes ?>">Classes</a>
                            </li>
                        <?php } ?>
                    </ul>
                    <!-- Left links -->

                    <!-- Side content -->
                    <?php $logout = base_url() . "Login/logout" ?>
                    <a href="<?= $logout ?>"><button class="btn btn-outline-success btn-sm my-2 my-sm-0" type="submit"><i class="fas fa-power-off"></i></button></a>
                    <!-- Side content -->
                </div>
                <!-- Collapsible wrapper -->
            </div>
            <!-- Container wrapper -->



        </nav>



        <div style="margin-bottom:20px"></div>