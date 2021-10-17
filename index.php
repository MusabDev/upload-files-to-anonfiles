<?php

$msg = "";
if (isset($_POST["submit"])) {
  $filename = $_FILES["file"]["name"];
  $filetemp = $_FILES["file"]["tmp_name"];
  $upload = move_uploaded_file($filetemp, "uploads/" . $filename);
  if ($upload) {
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => "https://api.anonfiles.com/upload",
      CURLOPT_POST => 1,
      CURLOPT_POSTFIELDS => array(
        "file" => new CURLFile("uploads/" . $filename)
      )
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    unlink("uploads/" . $filename);
  } else {
    $msg = "File not uploaded.";
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <title>Upload files to Anonfiles</title>
</head>

<body class="bg-light">
  <div class="container py-5">
    <div class="row">
      <div class="col-md-5 mx-auto">
        <div class="p-4 bg-white rounded border shadow-sm">
          <h3 class="title mb-3 fw-bold">Upload files to AnonFiles</h3>
          <?php echo $msg; ?>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="file" class="form-label">File</label>
              <input class="form-control" type="file" name="file" id="file" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Upload to cloud</button>
          </form>
        </div>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>