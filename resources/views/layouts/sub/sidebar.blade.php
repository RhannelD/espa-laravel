<aside id="sidebar" class="sidebar">
    @php
        $active_nav = $active_nav??'';
    @endphp
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a @class(['nav-link', 'collapsed' => $active_nav!='dashboard']) href="">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a @class(['nav-link', 'collapsed' => $active_nav!='student']) href="{{ route('student') }}">
                <i class="bi bi-person-badge"></i>
                <span>Student</span>
            </a>
        </li>

        <li class="nav-item">
            <a @class(['nav-link', 'collapsed' => $active_nav!='college']) href="{{ route('college') }}">
                <i class="bi bi-building"></i>
                <span>College</span>
            </a>
        </li>

        <li class="nav-item">
            <a @class(['nav-link', 'collapsed' => $active_nav!='program']) href="{{ route('program') }}">
                <i class="bi bi-building"></i>
                <span>Program</span>
            </a>
        </li>

        <li class="nav-item">
            <a @class(['nav-link', 'collapsed' => $active_nav!='course']) href="{{ route('course') }}">
                <i class="bi bi-building"></i>
                <span>Course</span>
            </a>
        </li>
    </ul>
</aside>