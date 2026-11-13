@extends('admin.layouts.app')

@section('content')
    <h1>Редактировать товар: {{ $product->title }}</h1>
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @include('admin.products.form')
    </form>
@endsection