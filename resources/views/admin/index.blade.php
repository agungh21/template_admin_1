@extends('layouts.back')

@section('content-back')
<h2 class="main-title text-uppercase">Dashboard</h2>
<div class="row stat-cards">
  <div class="col-md-6 col-xl-3">
    <article class="stat-cards-item">
      <div class="stat-cards-icon primary">
        <i class="fa-solid fa-user"></i>
      </div>
      <div class="stat-cards-info">
        <p class="stat-cards-info__num">{{ $users }}</p>
        <p class="stat-cards-info__title">Total Users</p>
      </div>
    </article>
  </div>
</div>
@endsection
