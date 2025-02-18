<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="#">
            <span class="align-middle">LMS Pyramakerz</span>
        </a>

        <ul class="sidebar-nav">

            <li class="sidebar-item {{ request()->is('admin') ? 'active' : '' }}">

                <a class="sidebar-link" href="{{ route('admin.dashboard') }}">

                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/images') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('images.index') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Images</span>
                </a>
            </li>
            {{-- <li class="sidebar-item {{ request()->is('admin/teacher_resources') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('teacher_resources.index') }}">
                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Teacher
                    resources</span>
            </a>
            </li> --}}

            <li class="sidebar-item {{ request()->is('admin/types') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('types.index') }}">
                    <i class="align-middle" data-feather="sliders"></i><span class="align-middle">
                        Types</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/ebooks') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('ebooks.create') }}">
                    <i class="align-middle" data-feather="sliders"></i><span class="align-middle">
                        Add E-Book</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/admins') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admins.index') }}">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">School</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/stages') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('stages.index') }}">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Grade</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/classes') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('classes.index') }}">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Class</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->is('admin/material') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('material.index') }}">
                    <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Theme</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->is('admin/units') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('units.index') }}">
                    <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Unit
                    </span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->is('admin/chapters') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('chapters.index') }}">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Chapter</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/lessons') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('lessons.index') }}">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Lesson</span>
                </a>
            </li>



            {{-- <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('ebooks.index') }}">
            <i class="align-middle" data-feather="square"></i> <span class="align-middle">Ebook</span>
            </a>
            </li> --}}
            <li class="sidebar-item {{ request()->is('admin/students') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('students.index') }}">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Student</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/teachers') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('teachers.index') }}">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Teacher</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/observers') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('observers.index') }}">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Observer</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/observers/observation_questions') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('observers.addQuestions') }}">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Observation Questions</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/observers/observation_report_admin') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('observers.obsReport') }}">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Observation Report</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/reports/assesment_report') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.assesmentReport') }}">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Assessment Report</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/reports/assignment_avg_report') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.assignmentAvgReport') }}">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Assignment Report</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/reports/compare_report') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.compareReport') }}">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Comparison Report</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/reports/login_report') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.loginReport') }}">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Login Report</span>
                </a>
            </li>
        </ul>

    </div>
</nav>