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
</head>

<body class="bg-dark">

    <div class="container">
        <div style="margin-bottom:50px"></div>



        <!--Grid row-->
        <div class="row d-flex justify-content-centers">
            <div class="col-md-7 p-4 bg-warning m-1">
                <div align="center">
                    <?php $students = base_url() . "assets/img/students.png" ?>
                    <img src="<?= $students ?>" alt="Png">
                </div>
            </div>
            <!--Grid column-->
            <div class="col-md-4 bg-info p-4 rounded">
                <div style="margin-bottom:30px"></div>
                <form action="" method="post">
                    <h1 style="font-weight: bold; font-family: 'Times New Roman', Times, serif; font-size:xx-large" align="center">GRADING SYSTEM</h1>
                    <?= validation_errors("<p class='alert alert-danger'>") ?>

                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" name="username" placeholder="Enter username" autocomplete="off" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" placeholder="Enter password" autocomplete="off" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-success col-md-12">Login</button>
                </form>
            </div>
            <!--Grid column-->
        </div>
        <!--Grid row-->
    </div>
</body>

<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

</html>