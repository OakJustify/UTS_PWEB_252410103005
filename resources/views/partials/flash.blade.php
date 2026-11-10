@if (session('error'))
    <div class="container">
        <p class="alert alert--error" role="alert">{{ session('error') }}</p>
    </div>
@endif

@if (session('success'))
    <div class="container">
        <p class="alert alert--success" role="alert">{{ session('success') }}</p>
    </div>
@endif
