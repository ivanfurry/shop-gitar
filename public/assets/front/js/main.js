// Глобальные функции для отображения и загрузки корзины
function showCart(cart) {
    $('#cart-modal .modal-body').html(cart);
    $('#cart-modal').modal('show');

    // Получаем текст, убираем пробелы и преобразуем в число для надежной проверки
    let qtyText = $('#modal-cart-qty').text().trim();
    let cartQty = qtyText ? parseInt(qtyText, 10) : 0;
    
    $('.mini-cart-qty').text(cartQty);

    // ИСПРАВЛЕНО: было carQty, стало cartQty > 0
    if (cartQty > 0) {
        $('#cart-modal .modal-footer button.btn-cart').removeClass('d-none');
    } else {
        $('#cart-modal .modal-footer button.btn-cart').addClass('d-none');
    }
}

function getCart(action) {
    $.ajax({
        url: action,
        type: 'get',
        success: function (result) {
            showCart(result);
        },
        error: function () {
            alert('Ошибка при загрузке корзины');
        }
    });
}

// Добавлено из первого изображения: глобальная функция очистки корзины с редиректом
function clearCart(action) {
    $.ajax({
        url: action,
        type: 'get',
        success: function (result) {
            let now_location = document.location.pathname;
            if (now_location == '/cart/checkout') {
                location = '/cart/checkout';
            } else {
                showCart(result);
            }
        },
        error: function () {
            alert('Error');
        }
    });
}

$(function () {
    // 1. ЗАЩИТА ПОЛЯ КОЛИЧЕСТВА (запрет отрицательных чисел и ведущего нуля)
    $('input[name="qty"]').on('input', function() {
        let value = $(this).val().replace(/[^0-9]/g, ''); // Оставляем только цифры
        value = value.replace(/^0+/, ''); // Удаляем ведущие нули
        
        if (value === '' || parseInt(value, 10) < 1) {
            value = 1; // Минимальное значение по умолчанию
        }
        $(this).val(value);
    });

    // 2. ДОБАВЛЕНИЕ В КОРЗИНУ
    $('.addtocart').on('submit', function (e) {
        e.preventDefault(); // Надежно отменяем стандартную перезагрузку страницы
        
        let form = $(this);
        let qty = parseInt(form.find('input[name="qty"]').val(), 10);
        
        if (isNaN(qty) || qty < 1) {
            alert('Количество должно быть не менее 1');
            return;
        }

        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            type: 'post',
            success: function (result) {
                showCart(result);
            },
            error: function (msg) {
                alert('Ошибка при добавлении в корзину');
                console.log(msg.responseJSON);
            }
        });
    });

    // 3. УДАЛЕНИЕ ТОВАРА ИЗ КОРЗИНЫ (Обновлено из второго изображения)
    $('#cart-modal .modal-body, .cart-table').on('click', '.del-item', function () {
        $.ajax({
            url: $(this).data('action'),
            type: 'get',
            success: function (result) {
                let now_location = document.location.pathname;
                if (now_location == '/cart/checkout') {
                    location = '/cart/checkout';
                } else {
                    showCart(result);
                }
            },
            error: function (msg) {
                alert('Error!');
            }
        });
    });

    // 4. ОЧИСТКА КОРЗИНЫ ЧЕРЕЗ ДЕЛЕГИРОВАНИЕ СОБЫТИЙ (перенаправляет на clearCart)
    $(document).on('click', '.btn-clear-cart', function () {
        if (confirm('Вы уверены, что хотите очистить корзину?')) {
            let actionUrl = $(this).data('action');
            clearCart(actionUrl);
        }
    });

    // 5. ОТКРЫТИЕ КОРЗИНЫ (Главная кнопка в шапке сайта)
    $(document).on('click', '.open-cart-link', function (e) {
        e.preventDefault(); // Отменяем стандартный переход по ссылке
        
        // Берем URL из атрибута href или data-action
        let actionUrl = $(this).attr('href') || $(this).data('action');
        
        console.log("Запрос корзины по URL:", actionUrl); // Для отладки в консоли (F12)
        getCart(actionUrl); // Вызываем вашу функцию загрузки
    });
});
