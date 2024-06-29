
<head>
    <title>Login </title>
</head>

<div class="unix-login">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="login-content">
                    <div class="login-logo">
                        <a ><span>Focus</span></a>
                    </div>
                    <div class="login-form">
                        <h4>Login</h4>
                        <!-- @if($errors->any())
                        {!! implode('', $errors->all('<div style="color: red;">:message</div>')) !!}
                        @endif -->
                        <form action="<?= base_url('/home/actLogin') ?>" method="POST">
                            <div class="form-group">
                                <label>Username </label>
                                <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            <!-- <div class="checkbox">
                                <label>
                                  <input type="checkbox"> Remember Me
                              </label>
                              <label class="pull-right">
                                  <a href="#">Forgotten Password?</a>
                              </label>

                          </div> -->
                          <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Log In</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

