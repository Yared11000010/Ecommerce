@extends('admindashboard.maindashboard')
@section('dashboard')
<style>

    .error-container {
      height: 100%;
      width: 100%;
      text-align: center;
      padding: 30px;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-color: #ffffff;
    }

    .error-code {
      font-size: 72px;
      font-weight: bold;
      margin-bottom: 10px;
      color: #dc3545;
    }

    .error-message {
      font-size: 24px;
      color: #343a40;
    }

    .back-btn {
      margin-top: 20px;
    }
  </style>
<div class="error-container">
    <div class="error-code">404</div>
    <div class="error-message">Oops! Page not found.</div>
    <a href="{{ url('admin/dashboard') }}" class="btn btn-primary back-btn">Go Back to Home</a>
  </div>
@endsection
