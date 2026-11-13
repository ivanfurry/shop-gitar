@csrf

@if(!empty($product) && $product->exists)
    @method('PUT')
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <label for="title">Наименование</label>
    <input type="text" name="title" id="title" class="form-control"
           value="{{ old('title', $product->title ?? '') }}" required>
</div>

<div class="form-group">
    <label for="content">Описание</label>
    <textarea name="content" id="content" class="form-control" rows="4" required>{{ old('content', $product->content ?? '') }}</textarea>
</div>

<div class="form-row">
    <div class="col-md-4">
        <label for="price">Цена</label>
        <input type="number" step="0.01" name="price" id="price" class="form-control"
               value="{{ old('price', $product->price ?? 0) }}" required>
    </div>
    <div class="col-md-4">
        <label for="old_price">Старая цена</label>
        <input type="number" step="0.01" name="old_price" id="old_price" class="form-control"
               value="{{ old('old_price', $product->old_price ?? 0) }}">
    </div>
    <div class="col-md-4">
        <label for="qty">Количество</label>
        <input type="number" name="qty" id="qty" class="form-control"
               value="{{ old('qty', $product->qty ?? 0) }}">
    </div>
</div>

<div class="form-row mt-3">
    <div class="col-md-6">
        <label for="category_id">Категория</label>
        <select name="category_id" id="category_id" class="form-control" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    @selected(old('category_id', $product->category_id ?? null) == $category->id)>
                    {{ $category->title }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label for="status_id">Статус</label>
        <select name="status_id" id="status_id" class="form-control" required>
            @foreach($statuses as $status)
                <option value="{{ $status->id }}"
                    @selected(old('status_id', $product->status_id ?? null) == $status->id)>
                    {{ $status->title }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group mt-3">
    <label for="img">Картинка</label>
    <input type="file" name="img" id="img" class="form-control-file">
    @if(!empty($product) && $product->img)
        <div class="mt-2">
            <img src="{{ $product->getImage() }}" alt="" width="120" class="img-thumbnail">
        </div>
    @endif
</div>

<div class="form-check">
    <input type="checkbox" name="hit" value="1" id="hit" class="form-check-input"
           @checked(old('hit', $product->hit ?? 0))>
    <label class="form-check-label" for="hit">Hit</label>
</div>
<div class="form-check">
    <input type="checkbox" name="sale" value="1" id="sale" class="form-check-input"
           @checked(old('sale', $product->sale ?? 0))>
    <label class="form-check-label" for="sale">Sale</label>
</div>

<button type="submit" class="btn btn-primary mt-3">Сохранить</button>