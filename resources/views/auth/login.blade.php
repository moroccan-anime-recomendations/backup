<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>أنمي لك - تسجيل الدخول</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/loginstyle.css') }}">
</head>
<body>
  <div class="left">
  </div>
  <div class="right">
    <h2>تقديم تجارب شخصية لمحبي الأنمي في جميع أنحاء العالم</h2>
    <p>أهلا بك مجددا! يرجى تسجيل الدخول إلى حسابك.</p>
    
    @if(session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif
    
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <input type="email" name="email" placeholder="البريد الإلكتروني" required>
      <input type="password" name="password" placeholder="كلمة المرور" required>
      <div class="remember">
        <label>
          <input type="checkbox" name="remember">
          تذكرني
        </label>
      </div>
      <div class="buttons">
        <button type="button" class="subscribe">اشتراك</button>
        <button type="submit" class="login">تسجيل الدخول</button>
      </div>
      <a style="color:#ccc; display:block; text-align:center">هل نسيت كلمة السر؟</a>
    </form>
    <div class="social">
      <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
      <a href="#" title="X"><i class="fab fa-twitter"></i></a>
      <a href="#" title="Google"><i class="fab fa-google"></i></a>
    </div>
  </div>
</body>
</html>