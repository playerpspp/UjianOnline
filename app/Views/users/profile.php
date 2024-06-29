<?= view('head'); ?>

<?= view('nav'); ?>

<head>
    <title>Profile</title>
</head>

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-title">
                            <h4>Ubah Profile</h4>

                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="<?= base_url('/profile/actprofile') ?>" method="POST">

                                    <div class="form-group">
                                        <label>Username: </label>
                                        <input type="text" id="username" value="<?= $user->username ?>" name="username" class="form-control" placeholder="Username">
                                    </div>

                                    <div class="form-group">
                                        <label>Email: </label>
                                        <input type="email" id="email" value="<?= $user->email ?>" name="email" class="form-control" placeholder="Email">
                                    </div>

                                  <!--   <div class="form-group">
                                        <label>Name: </label>
                                        
                                        <?php if (session()->get('role') == 'student') { ?>
                                            <input disabled type="text" id="name" value="<?= $user->student_name?>" name="name" class="form-control" placeholder="Name">

                                        <?php }elseif (session()->get('role') != 'student') { ?>
                                            <input disabled type="text" id="name" value="<?= $user->teacher_name?>" name="name" class="form-control" placeholder="Name">
                                        <?php } ?>
                                        
                                    </div>
 -->
                                    <button type="submit" class="btn btn-default">Submit</button>
                                </form><br>
                                <h5><a href="/profile/password">Mau ganti password?</a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= view('footer'); ?>