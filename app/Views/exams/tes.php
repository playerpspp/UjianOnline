<?= view('head'); ?>

<?= view('nav'); ?>
<style type="text/css">
    .delete {
        margin-top: 10px;
    }
    .space {
        margin: 5px 0 5px 0;
    }
    .tf {
        margin: 5px 0 5px 5px;
    }
</style>

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
                                <form action="<?= base_url('/exams/acttest') ?>" method="POST">



                                    <div class="form-group">
                                        <label for="tes">Description</label>
                                        <textarea class="form-control" id="tes" value="" name="tes" rows="3"></textarea>
                                    </div>


                                    <button type="submit" class="btn btn-default">Submit</button>
                                </form>
                                <!-- <div id="questions-count">There are <span id="count"></span> questions</div> -->
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.tiny.cloud/1/fhqo4q1x8uzqz1m9ujzb4tspbyxvuf1cu3zgbovl29xfhpww/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
                <script>
                    tinymce.init({
                      selector: 'textarea',
                      height: 200,
                      plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount'
                        ],
                      toolbar: 'undo redo | formatselect | ' +
                      'bold italic backcolor | alignleft aligncenter ' +
                      'alignright alignjustify | bullist numlist outdent indent | ' +
                      'removeformat | image | help',
                      content_css: '//www.tiny.cloud/css/codepen.min.css',
                    // enable image uploading
                      // images_upload_url: '/your/upload/image/endpoint',
                      images_upload_handler: function (blobInfo, success, failure) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            success('data:image/png;base64,' + btoa(e.target.result));
                        };
                        reader.onerror = function () {
                            failure('Image upload failed');
                        };
                        reader.readAsBinaryString(blobInfo.blob());
                    }
                });

            </script>
            <?= view('footer'); ?>