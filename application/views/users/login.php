<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css'); ?>" />
        <link rel="stylesheet" href="<?= base_url('assets/css/now-ui-kit.css'); ?>"/>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row"> 
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="panel panel-default">  
                        <div class="panel-heading">
                            <div class="panel-title">Login</div>
                        </div>
                        <div class="panel-body">
                            <form action="<?= base_url('users/login') ?>" method="POST" id="login">
                                <div class="form-group">
                                    <label for="email_address">E-mail Address</label>
                                    <input type="email" class="form-control" id="email_address" name="email_address" required>
                                </div>

                                <div class="form-group">
                                    <label for="user_password">Password</label>
                                    <input type="password" class="form-control" id="user_password" name="user_password" required>
                                </div>
                            </form>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn-default form-control" form="login">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="<?= base_url('assets/js/jquery.js'); ?>"></script>
        <script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
        
    </body>
</html>
