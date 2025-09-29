@include('layouts.header')
<main class="main-wrapper clearfix">
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Student Management</h6>
            <p class="page-title-description mr-0 d-none d-md-inline-block">Student Details</p>
        </div>
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('student-management.index') }}">Student Management</a>
                </li>
                <li class="breadcrumb-item active">Student Details</li>
            </ol>
        </div>
    </div>

    <div class="widget-list row">
        <div class="widget-holder widget-outside-header col-lg-12">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">person</i> Student Information</h5>
                <div class="widget-actions">
                    <a href="{{ route('student-management.index') }}" class="btn btn-secondary">Back to Students</a>
                </div>
            </div>
            <div class="widget">
                <div class="widget-body">
                    @include('components.alert')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Student ID:</strong></td>
                                    <td>{{ $student->student_id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Full Name:</strong></td>
                                    <td>{{ $student->full_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $student->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created Date:</strong></td>
                                    <td>{{ $student->created_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-dark">
                                <div class="card-body text-center">
                                    <h4>{{ $assessments->count() }}</h4>
                                    <p class="mb-0">Total Assessments</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="widget-holder widget-outside-header col-lg-12">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">assignment</i> Student Assessments</h5>
            </div>
            <div class="widget-bg">
                <div class="widget-body pb-0">
                    @if($assessments->count() > 0)
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Course Code</th>
                                    <th>Score</th>
                                    <th>Max Score</th>
                                    <th>Status</th>
                                    <th>Assessment Date</th>
                                    <th>Files</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assessments as $assessment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($assessment->question)
                                                {{ $assessment->question->course_code }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $assessment->score >= 70 ? 'success' : ($assessment->score >= 50 ? 'warning' : 'danger') }}">
                                                {{ $assessment->score }}
                                            </span>
                                        </td>
                                        <td>{{ $assessment->question->max_total }}</td>
                                        <td>
                                            <span class="badge badge-{{ $assessment->status === 'completed' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($assessment->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $assessment->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            @if($assessment->uploads->count() > 0)
                                                @foreach($assessment->uploads as $upload)
                                                    <a href="{{ Storage::url($upload->url) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="feather feather-download"></i> File {{ $loop->iteration }}
                                                    </a>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No files</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="feather feather-info mr-2"></i>
                            This student has no assessments yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@include('layouts.footer') 