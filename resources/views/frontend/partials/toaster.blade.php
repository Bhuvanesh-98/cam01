<link rel="stylesheet" href="{{ asset('backend/css/izitoast.min.css') }}">
<script src="{{ asset('backend/js/izitoast.min.js') }}"></script>
@if(session()->has('notify'))
    @foreach(session('notify') as $msg)
        <script> 
            "use strict";
            iziToast.{{ $msg[0] }}({message:"{{ __(notificationText($msg[1])) }}", position: "topRight"}); 
        </script>
    @endforeach
@endif

@if ($errors->any())
    @php
        $collection = collect($errors->all());
        $errors = $collection->unique();
    @endphp

    <script>
        "use strict";
        @foreach ($errors as $error)
        iziToast.error({
            message: '{{ __(notificationText($error)) }}',
            position: "topRight"
        });
        @endforeach
    </script>

@endif
<script>
    "use strict";
    function notify(status,message) {
        iziToast[status]({
            message: message,
            position: "topRight"
        });
    }
</script>