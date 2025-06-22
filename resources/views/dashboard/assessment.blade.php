@include('layouts.header')
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr/-r-5">Assessment Manager</h6>
            {{-- <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p> --}}
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Assessment</li>
            </ol>
        </div>
        <!-- /.page-title-right -->
    </div>
    <!-- /.page-title -->
    <!-- =================================== -->
    <!-- Different data widgets ============ -->
    <!-- =================================== -->

    <div class="widget-list row">
        <!-- /.widget-holder -->
        <div class="widget-holder widget-outside-header col-lg-12">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">error_outline</i> All Assessments for {{ $question->course_code }} - {{ $question->session }} - Level {{ $question->level }}</h5>
                <div class="widget-actions">
                    <a href="{{ route('assessment.export', $question->id) }}" class="btn btn-success mr-2">
                        <i class="feather feather-download"></i> Export CSV
                    </a>
                    <a href="{{ route('assessment.create', $question->id) }}" class="btn btn-primary">Add Assessment</a>
                </div>
                <!-- /.widget-actions -->
            </div>
            <!-- /.widget-heading -->
            <div class="widget-bg">
                <div class="widget-body pb-0">
                    <table class="table table-bordered table-responsive" data-toggle="datatables">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Course Code</th>
                                <th>StudentID</th>
                                <th>Score</th>
                                <th>Strictness Level</th>
                                <th>Status</th>
                                <th>Other Data</th>
                                <th>Uploaded File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assessments as $assessment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $assessment->question->course_code }}</td>
                                    <td>{{ json_decode($assessment->response)->student_id ?? 'AI Could not Determine Student ID' }}</td>
                                    <td>{{ $assessment->score ?? '0' }}/{{ $assessment->question->max_total }}</td>
                                    <td>{{ $assessment->question->difficulty }}</td>
                                    <td>{{ $assessment->status }}</td>
                                    <td>{{ $assessment->response }}</td>
                                    <td>
                                        @foreach ($assessment->uploads as $upload)
                                            <a href="{{ asset('storage/'.$upload->url) }}" target="download"><i class="feather feather-download"></i></a>
                                        @endforeach
                                    </td>
                                    <td>                
                                        <a href="{{ route('assessment.destroy', $assessment->id) }}">
                                            <i class="feather feather-trash-2"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No assessments found</td>
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
</div>
<!-- /.content-wrapper -->
@include('layouts.footer')