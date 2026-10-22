<article class="product" data-product-id="{{ $product['id'] }}" data-product-category="{{ $product['category'] }}">
    <div class="product-image"><img src="/vkusno/{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy"><span>{{ $product['badge'] }}</span></div>
    <div class="product-title"><h3>{{ $product['name'] }}</h3><small>{{ $product['weight'] }}</small></div>
    <p>{{ $product['description'] }}</p>
    @if(!empty($product['price_is_estimate']))<p class="product-price-note">Предварительная цена — уточним в кафе</p>@elseif(in_array('name', $product['inferred_fields'] ?? []))<p class="product-price-note">Название уточняется</p>@elseif(empty($product['source_photo']) && $cafe['demo_menu'])<p class="product-price-note">Примерная позиция</p>@endif
    <div class="product-bottom">
        <strong>{{ $product['price'] }} ₽@if(in_array($product['weight'], ['100 г', '1 кг'])) <small>/ {{ $product['weight'] }}</small>@endif</strong>
        <div class="product-cart-control">
            <span class="product-cart-status" data-product-cart-status hidden>В корзине</span>
            <div class="product-quantity" role="group" aria-label="Количество: {{ $product['name'] }}">
                <button type="button" data-subtract="{{ $product['id'] }}" aria-label="Уменьшить количество: {{ $product['name'] }}" hidden>−</button>
                <span data-product-quantity hidden>0 шт.</span>
                <button type="button" data-add="{{ $product['id'] }}" aria-label="Добавить {{ $product['name'] }} в корзину">+</button>
            </div>
        </div>
    </div>
</article>
