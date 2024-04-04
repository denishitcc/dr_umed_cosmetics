<div class="app-nav-left">
    @if (auth()->user()->is_staff_memeber == 1 && auth()->user()->role_type != 'admin')
        <select class="form-select" id="staff">
            <option>Select Staff</option>
        </select>
    @elseif (auth()->user()->is_staff_memeber == 1 && auth()->user()->role_type == 'admin')
        <select class="form-select" id="staff">
            <option>Select Staff</option>
        </select>
        <select class="form-select" id="locations">
            <option>Select Location</option>
        </select>
    @else
        <select class="form-select" id="staff">
            <option>Select Staff</option>
        </select>
        <select class="form-select" id="locations">
            <option>Select Location</option>
        </select>
    @endif

</div>