<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <title>Notification</title>
    <link rel="icon" href="dist/img/logo.png">
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="icon/css/all.min.css">
</head>
<style>
body { margin-top:30px; }
hr.message-inner-separator
{
    clear: both;
    margin-top: 20px;
    margin-bottom: 20px;
    border: 0;
    height: 1px;
    background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
}
.container{
    position: absolute;
    left: 30%;
}
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <div class="alert alert-success">
                    <button type="button" name="btnclose" class="close" data-dismiss="alert" aria-hidden="true" onclick="myFunction()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                <span class="glyphicon glyphicon-ok"></span> <strong>Success Message</strong>
                    <hr class="message-inner-separator">
                    <p>
                        Email send out !  Kindly check your email inbox.  
                        <i class="fas fa-envelope" style="color: black;"></i>
                    </p>
                </div>
                
            </div>
        </div>
</body>
</html>

<script>
    function myFunction() {
        location.replace("index.php");
    }
</script>