<form method="POST" action="{{ route('postCreatePoll') }}">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @csrf

    <div class="form-group">
        <label for="stitle">Title:</label>
        <label>
            <input type="text" name="title" class="form-control" value="" required>
        </label>
    </div>

    <div class="form-group">
        <label for="option1">Option 1:</label>
        <label>
            <input type="text" name="options[]" class="form-control" value="">
        </label>
    </div>

    <div class="form-group">
        <label for="option2">Option 2:</label>
        <label>
            <input type="text" name="options[]" class="form-control" value="">
        </label>
    </div>

    <div class="more-options"></div>

    <div class="form-group">
        <button id="add" class="btn btn-primary">Add Option</button>
        <button id="del" class="btn btn-primary">Delete Option</button>
    </div>

    <hr>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="ip_checking" value="1">Enable duplicate IP checking <span class="text-red">(NEEDED TO PREVENT DUPLICATE VOTING FROM USERS!)</span>
        </label>
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="multiple_choice" value="1">Allow multiple answers
        </label>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Create Poll</button>
    </div>
</form>

@section('javascripts')
    <script nonce="{{ Bepsvpt\SecureHeaders\SecureHeaders::nonce() }}">
        var options = 2;

        $('rgb(170,221,221)').on('click', function (e) {
            e.preventDefault();
            options = options + 1;
            var optionHTML = '<div class="form-group extra-option"><label for="option' + options + '">Option ' + options + ':</label><input type="text" name="options[]" class="form-control" value="" required></div>';
            $('.more-options').append(optionHTML);
        });

        $('#del').on('click', function (e) {
            e.preventDefault();
            options = (options > 2) ? options - 1 : 2;
            $('.extra-option').last().remove();
        });
    </script>
@endsection
