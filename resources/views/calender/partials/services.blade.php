<ul class="ctg-tree ps-0 pe-1">
    <li class="pt-title">
        <div class="disflex">
            <label id="subcategory_text">All Services &amp; Tasks</label>
        </div>
        <ul id="sub_services">
            @if ($services->count())
                @foreach ($services as $service)
                    <li class="service_selected">
                        <a href="javascript:void(0);" class="services" data-services_id="{{ $service->id }}"
                            data-category_id="{{ $service->category_id }}"
                            data-duration="{{ $service->appearoncalender->duration }}">{{ $service->service->service_name }}</a>
                    </li>
                @endforeach
            @endif
        </ul>
    </li>
</ul>
