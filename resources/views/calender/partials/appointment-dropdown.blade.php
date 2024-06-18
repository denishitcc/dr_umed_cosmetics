<div class="app-nav-left">
    @if (auth()->user()->is_staff_memeber == 1 && auth()->user()->role_type != 'admin')
        <select class="form-select" id="locations">
            <!-- <option>All Location</option> -->
        </select>
        <select class="form-select" id="staff">
            <option>all</option>
        </select>
    @elseif (auth()->user()->is_staff_memeber == 1 && auth()->user()->role_type == 'admin')
        <select class="form-select" id="locations">
        <option>All Location</option>
        </select>
        <select class="form-select" id="staff">
            <option value="all">All staff</option>
            <option disabled>Individual staff</option>
        </select>
    @else
        <select class="form-select" id="locations">
            <!-- <option>All Location</option> -->
        </select>
        <select class="form-select" id="staff">
            <option>all</option>
        </select>
    @endif

</div>