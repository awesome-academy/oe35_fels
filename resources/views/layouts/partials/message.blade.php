<div class="container">
    {{-- Show session flash error --}}
    @if (Session::has('error') || isset($error))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <strong>{{ Session::get('error') ?? $error }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
    </div>
    @endif

    {{-- Show session flash success --}}
    @if (Session::has('success') || isset($success))
    <div class="alert alert-success alert-dismissible" role="alert">
        <strong>{{ Session::get('success') ?? $success }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
    </div>
    @endif

    {{-- Show session flash errors validate form --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
