@if(!empty(session('cart')))
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Фото</th>
                    <th>Наименование</th>
                    <th>Цена</th>
                    <th>Кол-во</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('cart') as $item)
                    <tr>
                        <td>
                            <a href="{{ route('products.show', ['slug' => $item['slug']]) }}">
                                <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" style="max-width: 60px; height: auto;">
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('products.show', ['slug' => $item['slug']]) }}" class="text-decoration-none text-dark">
                                {{ $item['title'] }}
                            </a>
                        </td>
                        <td>@price_format($item['price']) руб.</td>
                        <td>{{ $item['qty'] }}</td>
                        <td>
                            <!-- УЛУЧШЕННАЯ КНОПКА УДАЛЕНИЯ ТОВАРА -->
                            <button type="button" class="btn btn-sm btn-outline-danger del-item" 
                                    data-action="{{ route('cart.del_item', ['product_id' => $item['id']]) }}" 
                                    title="Удалить из корзины">
                                <i class="fas fa-trash-alt"></i> Удалить
                            </button>
                        </td>
                    </tr>
                @endforeach
                <tr class="table-active fw-bold">
                    <td colspan="3" class="text-end">Итого товаров:</td>
                    <td id="modal-cart-qty">{{ session('cart_qty') }}</td>
                    <td></td>
                </tr>
                <tr class="table-active fw-bold fs-5">
                    <td colspan="3" class="text-end">На сумму:</td>
                    <td id="modal-cart-total" colspan="2">@price_format(session('cart_total')) руб.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- НИЖНЯЯ ПАНЕЛЬ С КНОПКАМИ -->
    <div class="d-flex justify-content-between mt-3 pt-3 border-top">
        <!-- Кнопка полной очистки корзины (использует функцию clearCart) -->
        <button type="button" class="btn btn-secondary btn-clear-cart" 
                data-action="{{ route('cart.clear') }}">
            <i class="fas fa-trash"></i> Очистить корзину
        </button>
        
        <!-- Кнопка оформления заказа -->
        <a href="#" class="btn btn-success">
            Оформить заказ <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
        <h4>Корзина пуста</h4>
        <p class="text-muted">Добавьте товары, чтобы начать покупки</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary mt-2">Перейти в каталог</a>
    </div>
@endif