<ul class="ctg-tree ps-0 pe-1" id="main_categories">
    <li class="pt-title">
        <div class="disflex">
            <a href="javascript:void(0);" class="parent_category_id">All Services &amp; Tasks </a>
        </div>
    </li>
    @if ($categories->count())
        @foreach ($categories as $category)
            <li>
                <div class="disflex">
                    <a href="javascript:void(0);" class="parent_category_id" data-category_id="{{ $category->id }}"
                        data-duration="{{ $category->duration }}">{{ $category->category_name }}</a>
                </div>
            </li>
        @endforeach
    @endif
</ul>
