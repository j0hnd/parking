@if ($errors->any())
    <div class="error-container">
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Something went wrong...<br>
            <ul class="error-wrapper" style="padding-left: 17px;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if (session('success'))
    <div class="success-message-container alert alert-success">
        <strong><span id="message-prefix">Success!</span></strong> <span class="message">{{ session('success') }}</span> <br>
    </div>
@endif
