@include('layouts.student-header')
        <main class="main-wrapper clearfix">
            <!-- Page Title Area -->
            <div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">Assessment Details</h6>
                    <p class="page-title-description mr-0 d-none d-md-inline-block">{{ $student->full_name }} ({{ $student->student_id }})</p>
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('student.assessments') }}">My Assessments</a>
                        </li>
                        <li class="breadcrumb-item active">Assessment Details</li>
                    </ol>
                </div>
                <!-- /.page-title-right -->
            </div>
            <!-- /.page-title -->
            <!-- =================================== -->
            <!-- Different data widgets ============ -->
            <!-- =================================== -->
            <div class="widget-list row">

                <!-- Assessment Details -->
                <div class="widget-holder widget-outside-header col-lg-8">
                    <div class="widget-heading">
                        <h5 class="widget-title"><i class="material-icons mr-2">question_answer</i> Question Details</h5>
                    </div>
                    <div class="widget-bg">
                            <div class="mb-3">
                                <strong>Question:</strong>
                                <p class="mt-2">{{ $assessment->question->question_text ?? 'N/A' }}</p>
                            </div>
                            
                            @if($assessment->question->questionUpload)
                                <div class="mb-3">
                                    <strong>Question File:</strong>
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $assessment->question->questionUpload->url) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="material-icons">download</i> Download Question File
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($assessment->question->answerUpload)
                                <div class="mb-3">
                                    <strong>Answer File:</strong>
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $assessment->question->answerUpload->url) }}" target="_blank" class="btn btn-outline-success btn-sm">
                                            <i class="material-icons">download</i> Download Answer File
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($assessment->uploads->count() > 0)
                                <div class="mb-3">
                                    <strong>Your Submission Files:</strong>
                                    <div class="mt-2">
                                        @foreach($assessment->uploads as $upload)
                                            <a href="{{ asset('storage/' . $upload->url) }}" target="_blank" class="btn btn-outline-info btn-sm mr-2 mb-2">
                                                <i class="material-icons">download</i> Download Submission {{ $loop->iteration }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                    </div>
                </div>

                <div class="widget-holder widget-outside-header col-lg-4">
                    <div class="widget-heading">
                        <h5 class="widget-title"><i class="material-icons mr-2">info</i> Assessment Information</h5>
                    </div>
                    <div class="widget-bg">
                            
                            <div class="mb-3">
                                <strong>Course Code:</strong>
                                <span class="badge badge-info">{{ $assessment->question->course_code ?? 'N/A' }}</span>
                            </div>

                            <div class="mb-3">
                                <strong>Difficulty:</strong>
                                <span class="badge badge-{{ $assessment->question->difficulty === 'hard' ? 'danger' : ($assessment->question->difficulty === 'medium' ? 'warning' : 'success') }}">
                                    {{ ucfirst($assessment->question->difficulty ?? 'N/A') }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <strong>Max Score:</strong>
                                <span class="badge badge-primary">{{ $assessment->question->max_total ?? 'N/A' }}</span>
                            </div>

                            <div class="mb-3">
                                <strong>Your Score:</strong>
                                <span class="badge badge-{{ $assessment->score >= ($assessment->question->max_total * 0.7) ? 'success' : ($assessment->score >= ($assessment->question->max_total * 0.5) ? 'warning' : 'danger') }}">
                                    {{ $assessment->score ?? 'N/A' }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <strong>Percentage:</strong>
                                <span class="badge badge-{{ $assessment->percentage >= 70 ? 'success' : ($assessment->percentage >= 50 ? 'warning' : 'danger') }}">
                                    {{ $assessment->percentage ?? 'N/A' }}%
                                </span>
                            </div>

                            <div class="mb-3">
                                <strong>Status:</strong>
                                <span class="badge badge-{{ $assessment->status === 'completed' ? 'success' : 'info' }}">
                                    {{ ucfirst($assessment->status ?? 'pending') }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <strong>Submitted Date:</strong>
                                <p class="text-muted">{{ $assessment->created_at->format('M d, Y H:i') }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Last Updated:</strong>
                                <p class="text-muted">{{ $assessment->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                    </div>
                </div>

                <!-- Performance Indicator -->
                <div class="widget-holder widget-outside-header col-lg-4">
                    <div class="widget-heading">
                        <h5 class="widget-title"><i class="material-icons mr-2">trending_up</i> Performance</h5>
                    </div>
                    <div class="widget-bg">
                            @if($assessment->percentage)
                                <div class="progress mb-2">
                                    <div class="progress-bar 
                                        @if($assessment->percentage >= 70) bg-success
                                        @elseif($assessment->percentage >= 50) bg-warning
                                        @else bg-danger
                                        @endif" 
                                        role="progressbar" 
                                        style="width: {{ $assessment->percentage }}%"
                                        aria-valuenow="{{ $assessment->percentage }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                        {{ $assessment->percentage }}%
                                    </div>
                                </div>
                                <p class="text-muted small">
                                    @if($assessment->percentage >= 70)
                                        Excellent work! You scored above 70%.
                                    @elseif($assessment->percentage >= 50)
                                        Good effort! You scored above 50%.
                                    @else
                                        Keep practicing! Consider reviewing the material.
                                    @endif
                                </p>
                            @else
                                <p class="text-muted">No score available yet.</p>
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
