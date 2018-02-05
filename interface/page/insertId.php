<center>
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
            <label for='email'>Your sample ID :</label>
          </div>
        </div>

        <div class='row'>
          <div class='input-field col s12'>
            <input class='validate' type='password' name='password' id='password' />
            <label for='password'>Today Date :</label>
          </div>
        </div>

        <br />
        <center>
          <div class='row'>
            <button onclick="login()" type='submit' name='btn_login' class='col s12 btn btn-large waves-effect teal'>Next</button>
          </div>
        </center>
      </form>
    </div>
  </div>
</center>
