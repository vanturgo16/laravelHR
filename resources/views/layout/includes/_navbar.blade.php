<style>
    /* span {
        color: white;
        font-weight: 700;
    }

    .subnav-text {
        color: white;
        font-weight: 700;
    } */

</style>
<nav class="main-menu">
    {{-- @if(auth()->user()->is_admin == '1') --}}
        <ul>
            <li>
                <a href="{{url('/home')}}">
                    <i class="fa fa-home nav_icon"></i>
                    <span class="nav-text">
                    Home
                    </span>
                </a>
            </li>
            <li>
                <a href="{{url('/candidates')}}">
                    <i class="fa fa-file-text-o nav_icon"></i>
                    <span class="nav-text">
                    Candidates
                    </span>
                </a>
            </li>
        </ul>
    {{-- @endif --}}

    <ul class="logout">
        <li>
        <a href="{{ url('/logout') }}">
        <i class="icon-off nav-icon"></i>
        <span class="nav-text">
        Logout
        </span>
        </a>
        </li>
    </ul>
    
</nav>