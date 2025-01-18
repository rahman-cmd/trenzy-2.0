@php
    function renderStarRating($rating, $maxRating = 5)
    {
        $fullStar = "<i class = 'far fa-star filled'></i>";
        $halfStar = "<i class = 'far fa-star-half filled'></i>";
        $emptyStar = "<i class = 'far fa-star'></i>";
        $rating = $rating <= $maxRating ? $rating : $maxRating;

        $fullStarCount = (int) $rating;
        $halfStarCount = ceil($rating) - $fullStarCount;
        $emptyStarCount = $maxRating - $fullStarCount - $halfStarCount;

        $html = str_repeat($fullStar, $fullStarCount);
        $html .= str_repeat($halfStar, $halfStarCount);
        $html .= str_repeat($emptyStar, $emptyStarCount);
        $html = $html;
        return $html;
    }
@endphp

<div class="s-r-inner">
    @foreach ($items as $item)
        <!-- Wrap the entire card in a single <a> tag -->
        <a href="{{ route('front.product', $item->slug) }}" class="text-decoration-none mt-1">
            <div class="product-card p-col">
                <div class="product-thumb">
                    <img class="lazy" alt="Product" src="{{ asset('assets/images/' . $item->thumbnail) }}">
                </div>
                <div class="product-card-body">
                    <h3 class="product-title text-dark">
                        {{ Str::limit($item->name, 35) }}
                    </h3>
                    <div class="rating-stars">
                        {!! renderStarRating($item->reviews->avg('rating')) !!}
                    </div>
                    <h4 class="product-price text-dark">
                        {{ PriceHelper::grandCurrencyPrice($item) }}
                    </h4>
                </div>
            </div>
        </a>
    @endforeach
</div>

<div class="bottom-area">
    <a id="view_all_search_" href="javascript:;">{{ __('View all result') }}</a>
</div>
