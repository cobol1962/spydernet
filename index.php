<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="/assets/css/sweetalert2.css">
</head>
<body>

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-md-12">
          <header>Spyder Net</header>
      </div>
    </div>
    <div class="row" style="margin-top: 30px;">
      <div class="col-xs-12 col-md-12">
        <form id="link">
          <div class="form-group">
            <label for="url">Enter url for article</label>
            <input class="form-control" type="text" id="url" />
          </div>
          <div class="form-group">
            <label for="tags">Enter tags for this article (enter term, press enter no limit in mumber of tags)</label>
            <select multiple data-role="tagsinput"  id="tags">

            </select>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
 <script type="text/javascript" src="/assets/js/bootstrap-tagsinput.js"></script>
 <script type="text/javascript" src="/assets/js/jquery.validate.js"></script>
 <script type="text/javascript" src="/assets/js/mainScript.js"></script>
 <script type="text/javascript" src="/assets/js/sweetalert2.js"></script>
</html>
