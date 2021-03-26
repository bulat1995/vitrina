@if(!empty($products))
    <div class="shop_page_nav d-flex flex-row">
    @if ($products->lastPage() > 1)
            <a href="{{ $products->url(1) }}">
                <div class="page_prev d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-chevron-left"></i>
                </div>
            </a>
            <ul class="page_nav d-flex flex-row">
            @for ($i = 1; $i <= $products->lastPage(); $i++)
                <li class="{{ ($products->currentPage() == $i) ? ' active' : '' }}">
                    <a href="{{ $products->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            </ul>
            <a href="{{ $products->url($products->currentPage()+1) }}" >
                <div class="page_next d-flex flex-column align-items-center justify-content-center"><i class="fas fa-chevron-right"></i></div>
            </a>
    @endif
</div>
@endif
