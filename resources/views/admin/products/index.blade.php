@extends('layouts.layout')

@section('title')@parent :: Товары@endsection

@section('content')
    <h1>Товары</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Добавить</a>

    <table class="table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Картинка</th>
                <th>Наименование</th>
                <th>Цена</th>
                <th>Старая цена</th>
                <th>Количество</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        <img src="{{ $product->getImage() }}" alt="" width="80">
                    </td>
                    <td>{{ $product->title }}</td>
                    <td>@price_format($product->price) руб.</td>
                    <td>
                        @if($product->old_price)
                            @price_format($product->old_price) руб.
                        @endif
                    </td>
                    <td>{{ $product->qty ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-pencil-alt"></i>
                        </a>

                        <form action="{{ route('admin.products.destroy', $product) }}"
                              method="post" class="d-inline"
                              onsubmit="return confirm('Удалить товар?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">Товаров пока нет</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->links() }}
@endsection