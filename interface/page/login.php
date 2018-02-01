<center>
  <h5 class="teal-text">Please, login into your account</h5>
  <div class="section"></div>

  <div class="container">
    <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

      <form id="loginForm" class="col s12" method="post" onsubmit="return false;">
        <div class='row'>
          <div class='col s12'>
          </div>
        </div>

        <div class='row'>
          <div class='input-field col s12'>
            <input class='validate' type='email' name='email' id='email' />
            <label for='email'>Enter your email</label>
          </div>
        </div>

        <div class='row'>
          <div class='input-field col s12'>
            <input class='validate' type='password' name='password' id='password' />
            <label for='password'>Enter your password</label>
          </div>
          <label style='float: right;'>
						<a class='orange-text' href='#!'><b>Forgot Password?</b></a>
					</label>
        </div>

        <br />
        <center>
          <div class='row'>
            <button onclick="login()" type='submit' name='btn_login' class='col s12 btn btn-large waves-effect teal'>Login</button>
          </div>
        </center>
      </form>
    </div>
  </div>
  <a>Create account</a>
</center>

<script type="text/javascript">
  function login() {
    var formData = $("#loginForm").serialize();
    $.ajax({
      type: "POST",
      url: "index.php",
      async: true,
      data: "action=auth.login&" + formData,
      dataType: "json",
      error: function(data) {
        alert("An error occured.");
      },
      success: function(data) {
      	if(data == 'success') window.location.replace("index.php?page='sample'");
        if(data == 'error') Materialize.toast('Identifiants incorrects', 4000);
      }
    });
  }
</script>
