<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Meta Section -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <!-- Stylesheet Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CDN Link -->
    <title>Login LIS</title>
</head>
<body>
  <section class="user">
    <div class="user_options-container">
      <div class="user_options-text">
        <div class="user_options-unregistered">
          <h2 class="user_unregistered-title" style="line-height: 45px;">Laboratory Information System Management</h2>
          <p class="user_unregistered-text">Selamat datang pada Laboratory Information System management silahkan login jika sudah memiliki akun</p>
          <button class="user_unregistered-signup" id="signup-button">Forget Password</button>
        </div>

        <div class="user_options-registered">
          <h2 class="user_registered-title">Forget Password</h2>
          <p class="user_registered-text">Lupa Password hanya digunakan email yang sudah didaftarkan oleh sistem admin, login jika memiliki akun</p>
          <button class="user_registered-login" id="login-button">Login</button>
        </div>
      </div>

      <div class="user_options-forms" id="user_options-forms">
        <div class="user_forms-login">
          <h2 class="forms_title">Login</h2>
          <form class="forms_form" action="{{ route('login.proses') }}" method="POST">
            @csrf
            <fieldset class="forms_fieldset">
              <div class="forms_field">
                <input type="text" placeholder="Username" name="username" class="forms_field-input" required autofocus />
              </div>
              <div class="forms_field">
                <input type="password" placeholder="Password" name="password" class="forms_field-input" required />
              </div>
            </fieldset>
            @error('error')
                <small style="color: red">{{ $message }}</small>
            @enderror
            <div class="forms_buttons">
              <!-- <button type="button" class="forms_buttons-forgot">Forgot password?</button> -->
              <input type="submit" value="Log In" class="forms_buttons-action">
            </div>
          </form>
        </div>
        <div class="user_forms-signup">
          <h2 class="forms_title">Forget Password</h2>
          <form class="forms_form">
            <fieldset class="forms_fieldset">
              <div class="forms_field">
                <input type="email" placeholder="Email" class="forms_field-input" required />
              </div>
            </fieldset>
            <div class="forms_buttons">
              <input type="submit" value="Forget Password" class="forms_buttons-action">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
