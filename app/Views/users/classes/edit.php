<?= view('head'); ?>

<?= view('nav'); ?>

<head>
    <title>Edit Class <?= $class->class_name  ?> </title>
</head>

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-title">
                            <h4>Edit Class Form</h4>

                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="<?= base_url('/classes/actedit') ?>" method="POST">
                              
                                    <div class="form-group">

                                        <input type="hidden" name="id" value="<?= $class->class_id ?>">

                                        <label>Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Name" value="<?= $class->class_name ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Add student:</label>
                                        <input type="text" id="student" value="" name="student" class="form-control" placeholder="Full Student Name">
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