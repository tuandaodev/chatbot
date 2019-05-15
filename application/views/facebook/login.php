<html>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="../assets/facebook/css/login.css" rel="stylesheet" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>
    <div class="container">
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->
                <!-- Icon -->
                <div class="fadeIn first">
                    <img src="../assets/facebook/images/facebook.jpg" id="icon" alt="User Icon" />
                </div>
                <div>
                    <span class="error"><?php if(isset($fb_message)){echo $fb_message ;} ?></span>
                </div>
                <!-- Login Form -->
                <form action="<?php echo base_url()."facebook/doLogin" ?> " method="post">
                    <input type="text" id="username" class="form-control fadeIn second" name="username" placeholder="facebook account">
                    <span class="error"><?php echo form_error('username'); ?></span>

                    <input type="password" id="password" class=" form-control fadeIn third" name="password" placeholder="password">
                    <span class="error"><?php echo form_error('password'); ?></span>
                    <input type="submit" class="fadeIn fourth" value="Log In">
                </form>
            </div>
        </div>
    </div>
</body>

</html>