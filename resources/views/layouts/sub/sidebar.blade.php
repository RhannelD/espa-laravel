<aside id="sidebar" class="sidebar">
    @php
        $active_nav = $active_nav??'';
    @endphp
    <ul class="sidebar-nav" id="sidebar-nav">
        @can('viewAnyDashboard')
            <li class="nav-item">
                <a @class(['nav-link', 'collapsed' => $active_nav!='dashboard']) href="{{ route('dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        @endcan

        @can('viewAnyStudent', \App\Models\User::class)
            <li class="nav-item">
                <a @class(['nav-link', 'collapsed' => $active_nav!='student']) href="{{ route('student') }}">
                    <i class="bi bi-person-badge"></i>
                    <span>Student</span>
                </a>
            </li>
        @endcan

        @can('viewAny', \App\Models\Curriculum::class)
            <li class="nav-item">
                <a @class(['nav-link', 'collapsed' => $active_nav!='curriculum']) href="{{ route('curriculum') }}">
                    <i class="bi bi-file-medical"></i>
                    <span>Curriculum</span>
                </a>
            </li>
        @endcan

        @can('viewAnyOfficer', \App\Models\User::class)
            <li class="nav-item">
                <a @class(['nav-link', 'collapsed' => $active_nav!='officer']) href="{{ route('officer') }}">
                    <i class="bi bi-person-square"></i>
                    <span>Officer</span>
                </a>
            </li>
        @endcan

        @can('viewAny', \App\Models\College::class)
            <li class="nav-item">
                <a @class(['nav-link', 'collapsed' => $active_nav!='college']) href="{{ route('college') }}">
                    <i class="bi bi-building"></i>
                    <span>College</span>
                </a>
            </li>
        @endcan

        @can('viewAny', \App\Models\Program::class)
            <li class="nav-item">
                <a @class(['nav-link', 'collapsed' => $active_nav!='program']) href="{{ route('program') }}">
                    <i class="bi bi-journals"></i>
                    <span>Program</span>
                </a>
            </li>
        @endcan

        @can('viewAny', \App\Models\Course::class)
            <li class="nav-item">
                <a @class(['nav-link', 'collapsed' => $active_nav!='course']) href="{{ route('course') }}">
                    <i class="bi bi-journal"></i>
                    <span>Course</span>
                </a>
            </li>
        @endcan

        @php
            $canSetting = [];
        @endphp
        @can(['viewAny'], \Spatie\Permission\Models\Permission::class)
            @php
                $canSetting[] = 'permission';
            @endphp
        @endcan
        @can(['viewAny'], \Spatie\Permission\Models\Role::class)
            @php
                $canSetting[] = 'role';
            @endphp
        @endcan
        @if (count($canSetting))
            <li class="nav-item">
                <a @class(['nav-link', 'collapsed' => !in_array($active_nav,['role', 'permission'])]) data-bs-target="#setting-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gear"></i>
                    <span>Setting</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="setting-nav" @class(['nav-content collapse', 'show' => in_array($active_nav,['role', 'permission'])]) data-bs-parent="#sidebar-nav">
                    @if(in_array('role', $canSetting))
                        <li>
                            <a @class(['active' => $active_nav=='role']) href="{{ route('role') }}">
                                <i class="bi bi-circle"></i><span>Role</span>
                            </a>
                        </li>
                    @endif
                    @if(in_array('permission', $canSetting))
                        <li>
                            <a @class(['active' => $active_nav=='permission']) href="{{ route('permission') }}">
                                <i class="bi bi-circle"></i><span>Permission</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
    </ul>
</aside>