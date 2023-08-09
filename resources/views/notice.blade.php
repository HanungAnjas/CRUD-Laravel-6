@extends('layout.admin')

@push('css')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
@endpush

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Center the box vertically */
        .login-box {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
    </style>
</head>
<div class="container">
    <div class="row justify-content-center">
        <div class="row g-3 align-items-center">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center mt-4">
      <a href="../../index2.html" class="h1">CV. Nore Inovasi</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Data berhasil dikirim melalui email Silakan cek email Anda</p>

      <form action="/notice" method="post">
      @csrf
          <!-- /.col -->
          <div class="row justify-content-center">
                <a href="/email/verify/resend" class="btn btn-info">Kirim ulang verifikasi</a>
                
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('script')
<!-- jQuery -->
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
</body>
@endpush