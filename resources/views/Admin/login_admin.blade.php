@extends('layouts.app')

@section('title', 'Login Admin | Ngalalana')

@section('content')
<section class="d-flex align-items-center justify-content-center text-light"
         style="background: url('{{ asset('image/babancong.jpg') }}') no-repeat center center/cover; height: 100vh; position: relative;">
    
    <!-- Overlay gelap -->
    <div class="container position-relative z-3">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card bg-dark bg-opacity-75 shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">
                        <h3 class="text-center fw-bold text-softblue mb-4">
                            Login Sebagai Administrator
                        </h3>

                        {{-- Form Login --}}
                        <form action="{{ route('admin.login.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label text-light fw-semibold">Email</label>
                                <input type="email" class="form-control form-control-lg bg-transparent text-light border-softblue" 
                                    id="email" name="email" placeholder="Masukkan email anda" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label text-light fw-semibold">Kata Sandi</label>
                                <input type="password" class="form-control form-control-lg bg-transparent text-light border-softblue" 
                                    id="password" name="password" placeholder="Masukkan kata sandi" required>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-softblue w-100 py-2 shadow-sm">
                                Masuk
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@if(session('success_logout'))
    @php $logoutNotif = session('success_logout'); @endphp
    <div class="modal fade show" id="logoutNotifModal" tabindex="-1" aria-hidden="true" style="display:block;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content soft-modal text-light shadow-lg border-0 rounded-4 text-center py-4">
                <i class="bi bi-box-arrow-left text-success fs-1 mb-3"></i>
                <h5 class="fw-semibold mb-2">{!! $logoutNotif['title'] !!}</h5>
                <p class="text-muted small mb-0">{!! $logoutNotif['message'] !!}</p>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const modal = document.getElementById('logoutNotifModal');
            if(modal){ modal.remove(); }
        }, 2500);
    </script>
@endif
@endsection

@push('styles')
<style>
/* Login page specific styles */
.border-softblue {
    border: 1px solid rgba(66,165,245,0.6) !important;
}
.border-softblue:focus {
    border-color: var(--softblue) !important;
    box-shadow: 0 0 8px rgba(66,165,245,0.6);
}
}
</style>
@endpush

@push('scripts')
<script>
    // Replace the login page history entry so browser back won't return to a cached login page after auth
    try {
        if (window.history && history.replaceState) {
            history.replaceState(null, document.title, location.href);
        }
    } catch (e) {
        // ignore
    }
</script>
@endpush
