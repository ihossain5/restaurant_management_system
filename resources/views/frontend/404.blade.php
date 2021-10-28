@extends('layouts.frontend.master')
@section('title')
    404
@endsection
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/404.css') }}">
@endsection
@section('content')
<section class="not-found-section">
    <div class="container">
        <div class="not-found-content">
            <div class="not-found-inner">
                <img src="{{asset('frontend/assets/images/404.png')}}" alt="404" class="img-fluid">
                <h4>Error 404: Page not found</h4>
            </div>
        </div>
    </div>
</section>


<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#alertModal">
    Launch demo modal
</button>
<div class="modal alert-modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h3>You have already selected items from a different restaurant. If you continue, your cart & selection
                    will be removed</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="alert-modal-btn" data-bs-dismiss="modal">cancle</button>
                <button type="button" class="alert-modal-btn fill">continue</button>
            </div>
        </div>
    </div>
</div>
@endsection