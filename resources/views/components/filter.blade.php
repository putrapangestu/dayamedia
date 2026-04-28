<!--  Search Bar -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content rounded-1">
          <form method="GET" action="{{ request()->url() }}">
            <div class="modal-header border-bottom">
              <input type="search" class="form-control fs-3" placeholder="Cari disini..." id="search" name="search" value="{{ request('search') }}" />
              <a href="javascript:void(0)" data-bs-dismiss="modal" class="lh-1">
                <i class="ti ti-x fs-5 ms-3"></i>
              </a>
            </div>
            <div class="modal-body message-body" data-simplebar="">
              <h5 class="mb-0 fs-5 p-1">Kategori</h5>
              <div class="row">
                  @foreach ($categories as $category)
                  <div class="col-sm-6 col-md-3 col-xxl-3 my-1">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input primary" type="checkbox" id="category-{{ $category->id }}" name="category_id[]" value="{{ $category->id }}" 
                               {{ in_array($category->id, request('category_id', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="category-{{ $category->id }}">{{ $category->name }}</label>
                      </div>
                  </div>
                  @endforeach
              </div>
            </div>
            <div class="modal-footer">
              <a href="{{ request()->url() }}" class="btn bg-secondary-subtle text-secondary">Reset</a>
              <button type="submit" class="btn btn-primary">Filter</button>
            </div>
          </form>
        </div>
      </div>
    </div>

