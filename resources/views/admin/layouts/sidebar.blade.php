<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">AdminKit</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item active">
                <a class="sidebar-link" href="index.html">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admins.index') }}">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">School admin</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('stages.index') }}">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Stage</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('material.index') }}">
                    <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Material</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('units.index') }}">
                    <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Unit
                    </span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('chapters.index') }}">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Chapter</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('lessons.index') }}">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Lesson</span>
                </a>
            </li>



            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('ebooks.index') }}">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Ebook</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('students.index') }}">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Student</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('teachers.index') }}">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Teacher</span>
                </a>
            </li>


        </ul>

    </div>
</nav>