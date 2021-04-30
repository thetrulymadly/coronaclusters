@if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
    <button class="btn btn-secondary {{ isset($btn_sm) && $btn_sm === true ? 'btn-sm ': '' }}" type="button" data-toggle="modal" data-target="#logout_modal">
        Logout<i class="fa fas fa-user ml-1"></i>
    </button>
@else
    <button class="btn btn-primary {{ isset($btn_sm) && $btn_sm === true ? 'btn-sm ': '' }}" type="button" data-toggle="modal" data-target="#login_modal">
        Login<i class="fa fas fa-user ml-1"></i>
    </button>
@endif