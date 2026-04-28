<div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
  <div class="card-body px-4 py-3">
    <div class="row align-items-center">
      
      <div class="col-9">
        <h4 class="fw-semibold mb-2">
          {{ $title }}
        </h4>

        @if(!empty($description))
          <p class="text-muted mb-3">
            {{ $description }}
          </p>
        @endif

        @isset($actions)
          <div class="d-flex gap-2">
            {{ $actions }}
          </div>
        @endisset
      </div>

      <div class="col-3">
        <div class="text-center mb-n5">
          <img
            src="{{ $image ?? asset('assets/dashboard/images/breadcrumb/ChatBc.png') }}"
            class="img-fluid mb-n4"
            alt="header-image"
          >
        </div>
      </div>

    </div>
  </div>
</div>
