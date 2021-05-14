<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Upload Wallpaper</title>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="card mt-5 col-sm-10 col-md-6 col-lg-4">
            <div class="card-header">Upload Wallpaper Details</div>
            <div class="card-body">
                <form class="row g-3" action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text">Title</span>
                            <input name="title" type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text">Access Key</span>
                            <input name="key" type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-file">
                            <input name="thumbnail" type="file" class="form-file-input" required>
                            <label class="form-file-label">
                                <span class="form-file-text">Choose thumbnail...</span>
                                <span class="form-file-button">Browse</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-file">
                            <input name="image" type="file" class="form-file-input" required>
                            <label class="form-file-label">
                                <span class="form-file-text">Choose image...</span>
                                <span class="form-file-button">Browse</span>
                            </label>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-success" value="Submit" name="submit">
                </form>
                <br>
                <?php require "postHandler.php"; ?>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>