<?= view('head'); ?>

<?= view('nav'); ?>

<head>
    <title>New Student</title>
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
                            <h4>New Student Form</h4>

                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="<?= base_url('/students/actinput') ?>" method="POST">

                                    <div class="form-group">
                                        <label>Name</label>
                                        <input required type="text" id="name" value="" name="name" class="form-control" placeholder="Name">
                                    </div>

                                    <div class="form-group">
                                        <label>NISN</label>
                                        <input required type="text" id="nisn" value="" name="nisn" class="form-control" placeholder="NISN">
                                    </div>

                                    <div class="form-group">
                                        <label>Username</label>
                                        <input required type="text" id="username" value="" name="username" class="form-control" placeholder="Username">
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input required type="password" id="password" value="" name="password" class="form-control" placeholder="Password">
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input required type="email" id="email" value="" name="email" class="form-control" placeholder="Email">
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