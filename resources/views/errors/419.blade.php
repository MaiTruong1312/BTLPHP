{{-- resources/views/errors/419.blade.php --}}

@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message')
    <p>Rất tiếc, phiên làm việc của bạn đã hết hạn.</p>
    <p>Vui lòng quay lại trang trước và thử lại.</p>
    <a href="{{ url()->previous() }}" class="btn btn-primary">Quay lại</a>
    <a href="{{ route('home') }}" class="btn btn-secondary">Về trang chủ</a>
@endsection

<style>
    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        text-decoration: none;
        margin: 5px;
    }
    .btn-primary {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-secondary {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }
</style>
