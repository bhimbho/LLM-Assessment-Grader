@include('layouts.student-header')
        <main class="main-wrapper clearfix">
            <!-- Page Title Area -->
            <div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">Student Dashboard</h6>
                    <p class="page-title-description mr-0 d-none d-md-inline-block">Welcome, {{ $student->full_name }} ({{ $student->student_id }})</p>
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>
                <!-- /.page-title-right -->
            </div>
            <!-- /.page-title -->
            <!-- =================================== -->
            <!-- Different data widgets ============ -->
            <!-- =================================== -->
            <div class="widget-list row">

                <!-- Stats Cards -->
                <div class="widget-holder widget-sm col-md-3 widget-full-height">
                    <div class="widget-bg">
                        <div class="widget-body">
                            <div class="counter-w-info media">
                                <div class="media-body">
                                    <p class="text-muted mr-b-5">Total Assessments</p><span class="counter-title color-primary"><span class="counter">{{ $stats['total_assessments'] }}</span> </span>
                                    <div class="mr-t-20"><span data-toggle="sparklines" data-height="15" data-width="70" data-line-color="#1976d2" data-line-width="3" data-spot-radius="1" data-fill-color="rgba(0,0,0,0)" data-spot-color="undefined" data-min-spot-color="undefined"
                                        data-max-spot-color="undefined" data-highlight-line-color="undefined"><!-- 10,5,7,8,3,0,4,12,10,8,12 --></span>
                                    </div>
                                </div>
                                <!-- /.media-body -->
                                <div class="pull-right align-self-center"><i class="list-icon feather feather-book bg-primary"></i>
                                </div>
                            </div>
                            <!-- /.counter-w-info -->
                        </div>
                        <!-- /.widget-body -->
                    </div>
                    <!-- /.widget-bg -->
                </div>
                <!-- /.widget-holder -->
                <div class="widget-holder widget-sm col-md-3 widget-full-height">
                    <div class="widget-bg">
                        <div class="widget-body">
                            <div class="counter-w-info media">
                                <div class="media-body">
                                    <p class="text-muted mr-b-5">Average Score</p><span class="counter-title color-success"><span class="counter">{{ number_format($stats['average_percentage'], 1) }}%</span></span>
                                    <div class="progress" style="width: 70%; position: relative; top: 25px">
                                        <div class="progress-bar bg-success" style="width: {{ $stats['average_percentage'] }}%" role="progressbar"><span class="sr-only">{{ $stats['average_percentage'] }}% Complete</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.media-body -->
                                <div class="pull-right align-self-center"><i class="list-icon feather feather-trending-up bg-success"></i>
                                </div>
                            </div>
                            <!-- /.counter-w-info -->
                        </div>
                        <!-- /.widget-body -->
                    </div>
                    <!-- /.widget-bg -->
                </div>
                <!-- /.widget-holder -->
                <div class="widget-holder widget-sm col-md-3 widget-full-height">
                    <div class="widget-bg">
                        <div class="widget-body">
                            <div class="counter-w-info media">
                                <div class="media-body">
                                    <p class="text-muted mr-b-5">Highest Score</p><span class="counter-title color-warning"><span class="counter">{{ number_format($stats['highest_score'], 1) }}</span> </span>
                                    <div class="progress" style="width: 70%; position: relative; top: 25px">
                                        <div class="progress-bar bg-warning" style="width: 100%" role="progressbar"><span class="sr-only">100% Complete</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.media-body -->
                                <div class="pull-right align-self-center"><i class="list-icon feather feather-award bg-warning"></i>
                                </div>
                            </div>
                            <!-- /.counter-w-info -->
                        </div>
                        <!-- /.widget-body -->
                    </div>
                    <!-- /.widget-bg -->
                </div>
                <!-- /.widget-holder -->
                <div class="widget-holder widget-sm col-md-3 widget-full-height">
                    <div class="widget-bg">
                        <div class="widget-body">
                            <div class="counter-w-info media">
                                <div class="media-body">
                                    <p class="text-muted mr-b-5">Lowest Score</p><span class="counter-title color-info"><span class="counter">{{ number_format($stats['lowest_score'], 1) }}</span> </span>
                                    <div style="margin-top: 15px"><span data-toggle="sparklines" data-height="15" data-bar-width="3" data-type="bar" data-chart-range-min="0" data-bar-spacing="3" data-bar-color="#17a2b8"><!-- 2,4,5,3,2,3,5,3,2,3,5,4,2 --></span>
                                    </div>
                                </div>
                                <!-- /.media-body -->
                                <div class="pull-right align-self-center"><i class="list-icon feather feather-activity bg-info"></i>
                                </div>
                            </div>
                            <!-- /.counter-w-info -->
                        </div>
                        <!-- /.widget-body -->
                    </div>
                    <!-- /.widget-bg -->
                </div>
                <!-- /.widget-holder -->

                <!-- Recent Assessments -->
                <div class="widget-holder widget-outside-header col-lg-12">
                    <div class="widget-heading">
                        <h5 class="widget-title"><i class="material-icons mr-2">assessment</i> Recent Assessments</h5>
                        <div class="widget-actions">
                            <a href="{{ route('student.assessments') }}" class="btn btn-primary">View All</a>
                        </div>
                    </div>
                    <div class="widget-bg">
                        @if($assessments->count() > 0)
                            <div class="widget-body pb-0">
                                <table class="widget-invoice-table table mb-0 headings-font-family fs-13" valign="center">
                                    <thead class="lh-43 fs-12">
                                        <tr>
                                            <th>Assessment ID</th>
                                            <th class="w-30">Question</th>
                                            <th>Score</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($assessments->take(5) as $assessment)
                                            <tr>
                                                <td><span class="headings-color"># {{ substr($assessment->id, 0, 8) }}</span></td>
                                                <td class="w-25"><span class="headings-color fw-bold">{{ Str::limit($assessment->question->question_text ?? 'N/A', 30) }}</span></td>
                                                <td><span class="text-muted">{{ $assessment->score ?? 'N/A' }} ({{ $assessment->percentage ?? 'N/A' }}%)</span></td>
                                                <td><span class="text-muted">{{ $assessment->created_at->format('d/m/Y') }}</span></td>
                                                <td>
                                                    <div class="d-flex">
                                                        @if($assessment->status === 'completed')
                                                            <a href="#" class="btn btn-xs px-3 mr-3 fw-900 fs-9 text-uppercase btn-outline-success flex-1 justify-content-center">Completed</a>
                                                        @else
                                                            <a href="#" class="btn btn-xs px-3 mr-3 fw-900 fs-9 text-uppercase btn-outline-warning flex-1 justify-content-center">Pending</a>
                                                        @endif
                                                        <a href="{{ route('student.assessment.show', $assessment) }}" class="btn btn-xs px-0 content-color flex-2"><i class="fa fa-chevron-right"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="material-icons text-muted" style="font-size: 3rem;">assessment</i>
                                <p class="text-muted mt-2">No assessments found</p>
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
