<!doctype html>
<html lang="en">
<head>
    <x-header-tag></x-header-tag>
    <title>Smart Resource - A Web Banking Resource System</title>
</head>
<body>
<x-header></x-header>

<main class="main">


    @if($errors->has('msg'))
        <div id="modal_info" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal__text__notice">
                    <img src="{{asset('icons/notice-logo.svg')}}" alt="notice">
                    Notice
                    <img src="{{asset('icons/notice-logo.svg')}}" alt="notice">
                </p>
                <p class="modal__text">{{ $errors->first('msg') }}</p>
            </div>
        </div>
    @elseif($errors->has('error'))
        <div id="modal_info" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal__text__error">
                    <img src="{{asset('icons/denied-logo.svg')}}" alt="access denied">
                    Warning
                    <img src="{{asset('icons/denied-logo.svg')}}" alt="access denied">
                </p>
                <p class="modal__text">{{ $errors->first('error') }}</p>
            </div>
        </div>
    @endif
</main>

<script src="{{asset('js/index.js')}}"></script>
<script>
    var modal_fail = document.getElementById("modal_info");
    var close_span = document.getElementsByClassName("close")[0];

    // Events that close both modals
    close_span.onclick = function () {
        modal_fail.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target === modal_fail) {
            modal_fail.style.display = "none";
        }
    };
</script>
</body>
</html>
