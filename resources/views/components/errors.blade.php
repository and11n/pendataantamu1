@if ($errors->any() || session('error') || session('success'))
    <div class="alert alert-danger" role="alert">
        <!-- Validation Errors -->
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <!-- Custom Error Message -->
        @if (session('error'))
            <p>{{ session('error') }}</p>
        @endif

        <!-- Custom Success Message -->
        @if (session('success'))
            <p>{{ session('success') }}</p>
        @endif
    </div>
@endif
