@if(Session::has('flash_message'))
    <div class="flash_message">
        <i class="fas fa-check"></i>
        {{ session('flash_message') }}
    </div>
@endif
