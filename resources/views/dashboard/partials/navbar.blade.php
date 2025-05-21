<nav class="topnav navbar navbar-light">
    <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>

    <ul class="nav">

        <!-- SWITCHER -->
        <li class="nav-item">
            @include('dashboard.partials.language')
        </li>


        {{--        <li class="nav-item"> --}}
        {{--            <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-shortcut"> --}}
        {{--                <span class="fe fe-grid fe-16"></span> --}}
        {{--            </a> --}}
        {{--        </li> --}}
        {{--        <li class="nav-item nav-notif"> --}}
        {{--            <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-notif"> --}}
        {{--                <span class="fe fe-bell fe-16"></span> --}}
        {{--                <span class="dot dot-md bg-success"></span> --}}
        {{--            </a> --}}
        {{--        </li> --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="avatar avatar-sm mt-2">
                    <img src="{{ auth()->user()->getProfileImageUrl() }}" alt="..."
                        class="avatar-img rounded-circle">
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">{{ __('keys.profile') }}</a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">{{ __('keys.logout') }}</button>
                </form>
            </div>
        </li>
    </ul>
</nav>
