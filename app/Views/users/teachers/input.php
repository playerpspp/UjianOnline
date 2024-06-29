<?= view('head'); ?>

<?= view('nav'); ?>

<head>
    <title>New Teacher</title>
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
                            <h4>New Teacher Form</h4>

                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="<?= base_url('/teachers/actinput') ?>" method="POST">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input required type="text" id="name" name="name"  class="form-control" placeholder="Name">
                                    </div>

                                    <div class="form-group">
                                        <label>Username</label>
                                        <input required type="text" id="username"  name="username" class="form-control" placeholder="Username">
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input required type="password" id="password"  name="password" class="form-control" placeholder="Password">
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input required type="email" id="email"name="email" class="form-control" placeholder="Email">
                                    </div>

                                    <div class="form-group">
                                        <label>Role</label>
                                        <select required id="role" name="role" class="form-control">
                                            <option>-</option>
                                            <option value="admin">Admin</option>
                                            <option value="teacher">Teacher</option>
                                        </select>
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
    <?= view('footer'); 