@include('layouts.header')
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Assessments</h6>
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
        <!-- /.widget-holder -->
        <div class="widget-holder widget-outside-header col-lg-12">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">error_outline</i> All Questions</h5>
                <div class="widget-actions">
                    <a href="#" class="btn btn-primary">Add Question</a>
                </div>
                <!-- /.widget-actions -->
            </div>
            <!-- /.widget-heading -->
            <div class="widget-bg">
                <div class="widget-body pb-0">
                    <table class="table table-striped table-responsive" data-toggle="datatables" data-plugin-options='{"searching": false}'>
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Question</th>
                                <th>Subject</th>
                                <th>Difficulty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($questions as $question)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $question->question }}</td>
                                    <td>{{ $question->subject }}</td>
                                    <td>{{ $question->difficulty }}</td>
                                    <td>{{ $question->action }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No questions found</td>
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