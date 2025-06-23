@include('layouts.header')
        <main class="main-wrapper clearfix">
            <!-- Page Title Area -->
            <div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">Dashboard</h6>
                    <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p>
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
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
                <div class="widget-holder widget-sm col-md-3 widget-full-height">
                    <div class="widget-bg">
                        <div class="widget-body">
                            <div class="counter-w-info media">
                                <div class="media-body">
                                    <p class="text-muted mr-b-5">Total Assessments</p><span class="counter-title color-primary"><span class="counter">{{ $pendingCount + $completedCount }}</span> </span>
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
                                    <p class="text-muted mr-b-5">Pending Assessments</p><span class="counter-title color-info"><span class="counter">{{ $pendingCount }}</span></span>
                                    {{-- <!-- /.counter-title --> <span class="counter-difference text-danger"><i class="feather feather-arrow-down"></i> 8%</span> --}}
                                    <div class="progress" style="width: 70%; position: relative; top: 25px">
                                        <div class="progress-bar bg-info" style="width: 66%" role="progressbar"><span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.media-body -->
                                <div class="pull-right align-self-center"><i class="list-icon feather feather-clock bg-info"></i>
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
                                    <p class="text-muted mr-b-5">Completed Assessments</p><span class="counter-title"><span class="counter">{{ $completedCount }}</span> </span>
                                    <!-- /.counter-title -->
                                    <div class="progress" style="width: 70%; position: relative; top: 25px">
                                        <div class="progress-bar bg-danger" style="width: 100%" role="progressbar"><span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.media-body -->
                                <div class="pull-right align-self-center"><i class="list-icon feather feather-award bg-danger"></i>
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
                                    <p class="text-muted mr-b-5">Total Students</p><span class="counter-title color-pink"><span class="counter">{{ $studentCount }}</span> </span>
                                    <div style="margin-top: 15px"><span data-toggle="sparklines" data-height="15" data-bar-width="3" data-type="bar" data-chart-range-min="0" data-bar-spacing="3" data-bar-color="#ff6b88"><!-- 2,4,5,3,2,3,5,3,2,3,5,4,2 --></span>
                                    </div>
                                </div>
                                <!-- /.media-body -->
                                <div class="pull-right align-self-center"><i class="list-icon feather feather-users bg-pink"></i>
                                </div>
                            </div>
                            <!-- /.counter-w-info -->
                        </div>
                        <!-- /.widget-body -->
                    </div>
                    <!-- /.widget-bg -->
                </div>
                <!-- /.widget-holder -->
                @if(auth()->user()->role === 'admin')
                <div class="widget-holder widget-sm col-md-3 widget-full-height">
                    <div class="widget-bg">
                        <div class="widget-body">
                            <div class="counter-w-info media">
                                <div class="media-body">
                                    <p class="text-muted mr-b-5">Total Staff</p><span class="counter-title color-success"><span class="counter">{{ $users }}</span> </span>
                                    <div style="margin-top: 15px"><span data-toggle="sparklines" data-height="15" data-bar-width="3" data-type="bar" data-chart-range-min="0" data-bar-spacing="3" data-bar-color="#28a745"><!-- 1,2,3,2,1,2,3,2,1,2,3,2,1 --></span>
                                    </div>
                                </div>
                                <!-- /.media-body -->
                                <div class="pull-right align-self-center"><i class="list-icon feather feather-user-check bg-success"></i>
                                </div>
                            </div>
                            <!-- /.counter-w-info -->
                        </div>
                        <!-- /.widget-body -->
                    </div>
                    <!-- /.widget-bg -->
                </div>
                <!-- /.widget-holder -->
                @endif
            </div>
            <!-- /.widget-list -->
            <hr>
            <!-- /.widget-list -->
            <hr>
            <div class="widget-list row">
                <!-- /.widget-holder -->
                <div class="widget-holder widget-outside-header col-lg-12">
                    <div class="widget-heading">
                        <h5 class="widget-title"><i class="material-icons mr-2">error_outline</i> Last 5 Assessments Status</h5>
                        <div class="widget-actions">
                            <div class="predefinedRanges badge badge-pill bg-success px-3 cursor-pointer heading-font-family" data-plugin-options='{

	                 "locale": {

		                 "format": "MMM YYYY"

	                 }

                 }'><span></span>  <i class="feather feather-chevron-down ml-1"></i>
                            </div>
                        </div>
                        <!-- /.widget-actions -->
                    </div>
                    <!-- /.widget-heading -->
                    <div class="widget-bg">
                        <div class="widget-body pb-0">
                            <table class="widget-invoice-table table mb-0 headings-font-family fs-13" valign="center">
                                <thead class="lh-43 fs-12">
                                    <tr>
                                        <th>Assessment ID</th>
                                        <th class="w-30">Course</th>
                                        <th>Student ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lastAssessments as $assessment)
                                        @php
                                            $response = json_decode($assessment->response, true);
                                            $studentId = $response['student_id'] ?? 'Unknown';
                                        @endphp
                                        <tr>
                                            <td><span class="headings-color"># {{ substr($assessment->id, 0, 8) }}</span></td>
                                            <td class="w-25"><span class="headings-color fw-bold">{{ $assessment->question->course_code }}</span></td>
                                            <td><span class="text-muted">{{ $studentId }}</span></td>
                                            <td><span class="text-muted">{{ $assessment->created_at->format('d/m/Y') }}</span></td>
                                            <td>
                                                <div class="d-flex">
                                                    @if($assessment->status === 'completed')
                                                        <a href="#" class="btn btn-xs px-3 mr-3 fw-900 fs-9 text-uppercase btn-outline-success flex-1 justify-content-center">Completed</a>
                                                    @else
                                                        <a href="#" class="btn btn-xs px-3 mr-3 fw-900 fs-9 text-uppercase btn-outline-warning flex-1 justify-content-center">Pending</a>
                                                    @endif
                                                    <a href="{{ route('assessment.show', $assessment->question->id) }}" class="btn btn-xs px-0 content-color flex-2"><i class="fa fa-chevron-right"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No assessments found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.widget-body -->
                    </div>
                    <!-- /.widget-bg -->
                </div>
                <!-- /.widget-holder -->
            </div>
            <!-- /.widget-list -->
            <hr>
        </main>
        <!-- /.main-wrappper -->
    @include('layouts.footer')