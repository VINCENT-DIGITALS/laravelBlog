<nav class="navbar">
    <div class="logo">Pinoy Blogs</div>
    <button class="hamburger" onclick="toggleMenu()">☰</button>
    <ul class="nav-links" id="nav-links">
        {{-- Home link (always displayed) --}}
        <li class="{{ Request::routeIs('returnHome') ? 'active' : '' }}">
            <a href="{{ route('returnHome') }}">Home</a>
        </li>

        {{-- Check if the user is an admin using the session role --}}
        @if (session('role') === 'Admin')
            <li class="{{ Request::is('AdminDashboard') ? 'active' : '' }}">
                <a href="{{ route('AdminDashboard') }}">Admin Dashboard</a>
            </li>
        @endif

        {{-- Check if the user is logged in using session 'user_id' --}}
        @if (session('user_id'))
            <li><a href="javascript:void(0)" onclick="showProfileModal()">Profile</a></li>
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();">Logout</a>
            </li>
        @else
            <li class="{{ Request::routeIs('chooseLogin') ? 'active' : '' }}">
                <a href="{{ route('chooseLogin') }}">Login</a>
            </li>
        @endif
    </ul>
</nav>

<script>
    function toggleMenu() {
        const navLinks = document.getElementById('nav-links');
        navLinks.classList.toggle('open');
    }
</script>

@include('includes.profile_modal')
