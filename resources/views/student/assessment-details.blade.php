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
                
                <!-- Score Summary Cards -->
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="widget-holder widget-bg-color-white widget-p-md">
                                <div class="widget-bg">
                                    <div class="text-center py-4">
                                        <p class="text-muted mb-3">Course Code</p>
                                        <h3 class="mb-0">{{ $assessment->question->course_code ?? 'N/A' }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="widget-holder widget-bg-color-white widget-p-md">
                                <div class="widget-bg">
                                    <div class="text-center py-4">
                                        <p class="text-muted mb-3">Max Score</p>
                                        <h3 class="mb-0">{{ $assessment->question->max_total ?? 'N/A' }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="widget-holder widget-bg-color-white widget-p-md">
                                <div class="widget-bg">
                                    <div class="text-center py-4">
                                        <p class="text-muted mb-3">Your Score</p>
                                        <h3 class="mb-0 text-{{ $assessment->score >= ($assessment->question->max_total * 0.7) ? 'success' : ($assessment->score >= ($assessment->question->max_total * 0.5) ? 'warning' : 'danger') }}">
                                            {{ $assessment->score ?? 'N/A' }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="widget-holder widget-bg-color-white widget-p-md">
                                <div class="widget-bg">
                                    <div class="text-center py-4">
                                        <p class="text-muted mb-3">Status</p>
                                        <h3 class="mb-0 text-{{ $assessment->status === 'completed' ? 'success' : 'info' }}">
                                            {{ ucfirst($assessment->status ?? 'pending') }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question Details -->
                <div class="widget-holder widget-outside-header col-lg-8 mt-4">
                    <div class="widget-heading">
                        <h5 class="widget-title"><i class="material-icons mr-2">question_answer</i> Question</h5>
                    </div>
                    <div class="widget-bg">
                        <div class="widget-body p-4">
                            @if($assessment->question->question_text)
                                <div class="alert alert-light border p-4 mb-4">
                                    <p class="mb-0" style="white-space: pre-wrap; line-height: 1.6;">{{ $assessment->question->question_text }}</p>
                                </div>
                            @else
                                <div class="alert alert-warning p-4 mb-4">
                                    <i class="material-icons mr-2">info</i> No question text provided. Please check the question file.
                                </div>
                            @endif
                            
                            <div class="row mt-4">
                                @if($assessment->question->questionUpload)
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-primary">
                                            <div class="card-body text-center p-4">
                                                <i class="material-icons text-primary" style="font-size: 48px;">description</i>
                                                <h6 class="mt-3 mb-3">Question File</h6>
                                                <a href="{{ asset('storage/' . $assessment->question->questionUpload->url) }}" target="_blank" class="btn btn-primary btn-sm btn-block">
                                                    <i class="material-icons" style="font-size: 16px; vertical-align: middle;">download</i> Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($assessment->question->answerUpload)
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-success">
                                            <div class="card-body text-center p-4">
                                                <i class="material-icons text-success" style="font-size: 48px;">check_circle</i>
                                                <h6 class="mt-3 mb-3">Answer Key</h6>
                                                <a href="{{ asset('storage/' . $assessment->question->answerUpload->url) }}" target="_blank" class="btn btn-success btn-sm btn-block">
                                                    <i class="material-icons" style="font-size: 16px; vertical-align: middle;">download</i> Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submission & Info -->
                <div class="col-lg-4 mt-4">
                    <!-- Your Submission -->
                    @if($assessment->uploads->count() > 0)
                        <div class="widget-holder widget-outside-header mb-4">
                            <div class="widget-heading">
                                <h5 class="widget-title"><i class="material-icons mr-2">cloud_upload</i> Your Submission</h5>
                            </div>
                            <div class="widget-bg">
                                <div class="widget-body p-4">
                                    @foreach($assessment->uploads as $upload)
                                        <div class="card border-info mb-3">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="material-icons text-info mr-3" style="font-size: 36px;">insert_drive_file</i>
                                                    <div class="flex-1">
                                                        <p class="mb-2 text-muted">File {{ $loop->iteration }}</p>
                                                        <a href="{{ asset('storage/' . $upload->url) }}" target="_blank" class="btn btn-info btn-sm btn-block">
                                                            <i class="material-icons" style="font-size: 14px; vertical-align: middle;">download</i> Download
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Timeline Info -->
                    <div class="widget-holder widget-outside-header">
                        <div class="widget-heading">
                            <h5 class="widget-title"><i class="material-icons mr-2">schedule</i> Timeline</h5>
                        </div>
                        <div class="widget-bg">
                            <div class="widget-body p-4">
                                <div class="d-flex mb-4 pb-4 border-bottom">
                                    <i class="material-icons text-primary mr-3" style="font-size: 28px;">date_range</i>
                                    <div>
                                        <p class="mb-1 text-muted">Submitted Date</p>
                                        <p class="mb-1 fw-600" style="font-size: 16px;">{{ $assessment->created_at->format('M d, Y') }}</p>
                                        <p class="mb-0 text-muted">{{ $assessment->created_at->format('h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <i class="material-icons text-success mr-3" style="font-size: 28px;">update</i>
                                    <div>
                                        <p class="mb-1 text-muted">Last Updated</p>
                                        <p class="mb-1 fw-600" style="font-size: 16px;">{{ $assessment->updated_at->format('M d, Y') }}</p>
                                        <p class="mb-0 text-muted">{{ $assessment->updated_at->format('h:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
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
