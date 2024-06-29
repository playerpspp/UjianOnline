<?= view('head'); ?>

<?= view('nav'); ?>

<head>
    <title>Edit Student <?= $student->student_name  ?> </title>
</head>

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <a onclick="history.back()"><button class="btn btn-primary">
                        Back
                    </button></a>
                    <div class="card">
                        <div class="card-title">
                            <h4>Edit Student Form</h4>

                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="<?= base_url('/students/actedit') ?>" method="POST">
                                    <div class="form-group">
                                        <input required type="hidden" name="id" value="<?= $student->user_id ?>">
                                        <label>Name</label>
                                        <input required type="text" id="name" name="name" class="form-control" placeholder="Name" value="<?= $student->student_name ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>NISN </label>
                                        <input required type="text" id="nisn" name="nisn" class="form-control" placeholder="NISN" value="<?= $student->NISN ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?= $student->username ?>">
                                    </div>


                                    <div class="form-group">
                                        <label>Email</label>
                                        <input required type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?= $student->email ?>" readonly>
                                    </div>

                                    <button type="submit" class="btn btn-default">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= view('footer'); ?>