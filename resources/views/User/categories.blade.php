<div class="categories news-div">
    <h2><img src="data:image/png;base64,{{ $icon['category'] }}" class="icon-filter" width="25"> CATEGORIES</h2>
    <ul>


        @foreach ($parentCategories as $parent_category)
            <li><a href="/category/{{ $parent_category->created_at->timestamp }}/{{ $parent_category->id }}">
                    <img src="data:image/png;base64,{{ $icon['right'] }}" class="icon-filter" width="25">
                    {{ $parent_category->name }}
                </a>
                <span class="count">0</span>
                <ul class="sub-cat-ul">
                    @foreach ($subCategories as $sub_category)
                        @if ($parent_category->id === $sub_category->parent_category_id)
                            <li class="sub-cat-li"><a href="/category/{{ $sub_category->created_at->timestamp }}/{{ $sub_category->id }}">
                                    <img src="data:image/png;base64,{{ $icon['right'] }}" class="icon-filter"
                                        width="25">
                                    {{ $sub_category->name }}</a>
                                <span class="count">0</span>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</div>
