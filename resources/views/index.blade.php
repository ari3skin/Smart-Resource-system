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
        <div id="modal_fail" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal__text__notice">!! Notice !!</p>
                <p class="modal__text">{{ $errors->first('msg') }}</p>
            </div>
        </div>
    @elseif($errors->has('error'))
        <div id="modal_fail" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal__text__error">!! Warning !!</p>
                <p class="modal__text">{{ $errors->first('error') }}</p>
            </div>
        </div>
    @endif
</main>

<script src="{{asset('js/index.js')}}"></script>
<script>
    var modal_fail = document.getElementById("modal_fail");
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
