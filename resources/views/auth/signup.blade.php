<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
  <meta charset="UTF-8">
  <title>أنمي لك - تسجيل حساب</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/singupstyle.css') }}">
</head>
<body>
  <div class="left"></div>
  <div class="right">
    <h2>تقديم تجارب شخصية لمحبي الأنمي في جميع أنحاء العالم</h2>
    <p>ابدأ الآن</p>

    @if(session('success'))
      <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('signup.submit') }}">
      @csrf
      <input type="text" name="username" placeholder="اسم المستخدم" value="{{ old('username') }}">
      @error('username') <div style="color:red;">{{ $message }}</div> @enderror

      <input type="email" name="email" placeholder="البريد الإلكتروني" value="{{ old('email') }}">
      @error('email') <div style="color:red;">{{ $message }}</div> @enderror

      <input type="password" name="password" placeholder="كلمة المرور">
      @error('password') <div style="color:red;">{{ $message }}</div> @enderror

      <div class="policy">
        <label>
          <input type="checkbox" name="agree" {{ old('agree') ? 'checked' : '' }}> أوافق على الشروط والسياسة
        </label>
        @error('agree') <div style="color:red;">{{ $message }}</div> @enderror
      </div>

      <button type="submit" class="submit-btn">اشتراك</button>

      <p style="text-align:center; margin-top: 10px;">هل لديك حساب؟ 
        <a href="#" style="color: #6fc08f;">تسجيل الدخول</a>
      </p>
    </form>

    <div class="social">
      <a href="#"><i class="fab fa-facebook-f"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-google"></i></a>
    </div>
  </div>
</body>
</html>
