<?= view('head'); ?>

<?= view('nav'); ?>

<head>
    <title>New Class</title>
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
                            <h4>New Class Form</h4>

                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="<?= base_url('/classes/actinput') ?>" method="POST">

                                    <div class="form-group">
                                        <label>Name:</label>
                                        <input type="text" id="name" value="" name="name" class="form-control" placeholder="Name">
                                    </div>

                                    <div class="form-group">
                                        <label>teacher</label>
                                        <select required id="teacher" name="teacher" class="form-control">
                                            <option value="" disabled selected >-</option>
                                            <?php foreach($teachers as $teacher) { ?>
                                                <option value="<?= $teacher->teacher_id ?>"><?= $teacher->teacher_name ?></option>
                                            <?php } ?>
                                        </select>

                                    <div class="form-group">
                                        <label>student class:</label>
                                        <input type="text" id="student" value="" name="student" class="form-control" placeholder="Example: RPL X A">
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