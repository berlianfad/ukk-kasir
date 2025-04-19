<nav class="navbar navbar-expand-lg navbar-light">
    <div class="navbar-collapse justify-content-end">
        <ul class="navbar-nav flex-row align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="" width="35"
                        class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <div class="message-body">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
