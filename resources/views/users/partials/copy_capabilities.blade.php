<div class="modal fade" id="copy_capabilities_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Copy capabilities</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Copy capabilities from:</label>
                    <select class="form-select form-control" name="staff_cap" id="staff_cap">
                        <option selected disabled> -- Select Staff -- </option>
                        @foreach ($alluser as $user)
                            <option value="{{ $user->id }}"> {{ $user->name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="copyCap">Save</button>
            </div>
        </div>
    </div>
</div>
