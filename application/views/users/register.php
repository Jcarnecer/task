<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/task.css'); ?>" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="row"> 
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="panel panel-default">  
                        <div class="panel-heading">
                            <div class="panel-title">Register</div>
                        </div>
                        <div class="panel-body">
                            <form action="<?= base_url('users/register') ?>" method="POST" id="register">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="user_password">Password</label>
                                    <input type="password" class="form-control" id="user_password" name="user_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="email_address">E-mail Address</label>
                                    <input type="email" class="form-control" id="email_address" name="email_address" required>
                                </div>
                                <div class="form-group">
                                    <label for="company">Company</label>
                                </div>
                            </form>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn-default form-control" form="register">Register</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/jquery.js'); ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
    
    </body>
</html>
