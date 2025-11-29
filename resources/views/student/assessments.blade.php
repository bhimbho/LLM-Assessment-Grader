@include('layouts.student-header')
        <main class="main-wrapper clearfix">
            <!-- Page Title Area -->
            <div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">My Assessments</h6>
                    <p class="page-title-description mr-0 d-none d-md-inline-block">{{ $student->full_name }} ({{ $student->student_id }})</p>
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">My Assessments</li>
                    </ol>
                </div>
                <!-- /.page-title-right -->
            </div>
            <!-- /.page-title -->
            <!-- =================================== -->
            <!-- Different data widgets ============ -->
            <!-- =================================== -->
            <div class="widget-list row">

                <!-- Assessments Table -->
                <div class="widget-holder widget-outside-header col-lg-12">
                    <div class="widget-heading">
                        <h5 class="widget-title"><i class="material-icons mr-2">assessment</i> All My Assessments</h5>
                    </div>
                    <div class="widget-bg">
                        @if($assessments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Assessment ID</th>
                                            <th>Course Code</th>
                                            <th>Score</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($assessments as $assessment)
                                            <tr>
                                                <td><span class="text-white"># {{ substr($assessment->id, 0, 8) }}</span></td>
                                                <td>
                                                    <span class="badge badge-info">
                                                        {{ $assessment->question->course_code ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-{{ $assessment->score >= ($assessment->question->max_total * 0.7) ? 'success' : ($assessment->score >= ($assessment->question->max_total * 0.5) ? 'warning' : 'danger') }}">
                                                        <strong>{{ $assessment->score ?? 'N/A' }}</strong> / {{ $assessment->question->max_total ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $assessment->status === 'completed' ? 'success' : 'info' }}">
                                                        {{ ucfirst($assessment->status ?? 'pending') }}
                                                    </span>
                                                </td>
                                                <td>{{ $assessment->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <a href="{{ route('student.assessment.show', $assessment) }}" class="btn btn-sm btn-outline-primary">
                                                        View Details
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $assessments->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="material-icons text-muted" style="font-size: 4rem;">assessment</i>
                                <h5 class="text-muted mt-3">No assessments found</h5>
                                <p class="text-muted">You don't have any assessments yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- /.wrapper -->
    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/material-design.js') }}"></script>
</body>

</html>
