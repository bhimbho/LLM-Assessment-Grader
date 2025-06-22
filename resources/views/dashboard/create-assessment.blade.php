@include('layouts.header')
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Assess Students</h6>
            <p class="page-title-description mr-0 d-none d-md-inline-block">Create Multiple Student Assessments</p>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('assessment.show', $question->id) }}">Question Bank</a>
                </li>
                <li class="breadcrumb-item active">Create Assessment</li>
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
                <h5 class="widget-title">Create Assessment for {{ $question->course_code }} - {{ $question->session }} - Level {{ $question->level }}</h5>
                <!-- /.widget-actions -->
            </div>
            <!-- /.widget-heading -->
            <div class="widget">
                <div class="widget-body pb-0">
                    @include('components.alert')
                    
                    <!-- Instructions -->
                    <div class="alert alert-info">
                        <h6><i class="feather feather-info"></i> Instructions:</h6>
                        <ul class="mb-0">
                            <li>Add student groups one by one</li>
                            <li>Each student can have multiple assessment files (images or PDFs)</li>
                            <li>AI will automatically extract student IDs from the uploaded files</li>
                            <li>Group files by student - all files for one student should be uploaded together</li>
                        </ul>
                    </div>

                    <form action="{{ route('assessment.store', $question->id) }}" method="post" enctype="multipart/form-data" id="assessmentForm">
                        @csrf
                        
                        <!-- Student Assessment Groups -->
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="feather feather-users"></i> Student Assessment Groups</h6>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addStudentRow()">
                                    <i class="feather feather-plus"></i> Add Student Group
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="studentsTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="70%">Assessment Files</th>
                                                <th width="15%">Files Count</th>
                                                <th width="10%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="studentsTableBody">
                                            <!-- Student rows will be added here -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="feather feather-info"></i> 
                                        Each row represents one student's assessment. AI will extract the student ID from the uploaded files.
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mt-4">
                            <label for="llm_model">LLM Model</label>
                            <select name="llm_model" id="llm_model" class="form-control" required>
                                <option value="">Select LLM Model</option>
                                <option value="gpt-4o">GPT-4o</option>
                                <option value="gemini-pro">Gemini Pro</option>
                                <option value="claude-3-5-sonnet">Claude 3.5 Sonnet</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="feather feather-upload"></i> Upload All Assessments
                            </button>
                            <button type="button" class="btn btn-secondary ml-2" onclick="previewUploads()">
                                <i class="feather feather-eye"></i> Preview
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Preview</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- Preview content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<style>
.file-preview {
    display: inline-block;
    margin: 2px;
    padding: 4px 8px;
    background: #e9ecef;
    border-radius: 4px;
    font-size: 0.875rem;
}

.student-row {
    background-color: #f8f9fa;
}

.student-row:nth-child(even) {
    background-color: #ffffff;
}

.file-upload-area {
    min-height: 60px;
}
</style>

<script>
let studentCounter = 0;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    addStudentRow();
});

function addStudentRow() {
    studentCounter++;
    const tbody = document.getElementById('studentsTableBody');
    
    const row = document.createElement('tr');
    row.className = 'student-row';
    row.innerHTML = `
        <td>${studentCounter}</td>
        <td>
            <div class="file-upload-area" data-student="${studentCounter}">
                <input type="file" name="students[${studentCounter}][assessment_files][]" 
                       class="form-control form-control-sm student-files" 
                       accept="image/*, application/pdf" multiple 
                       onchange="updateFileCount(this)">
                <div class="file-preview-container mt-2" id="preview-${studentCounter}"></div>
            </div>
        </td>
        <td>
            <span class="file-count" id="count-${studentCounter}">0</span>
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeStudentRow(this)" ${studentCounter === 1 ? 'disabled' : ''}>
                <i class="feather feather-trash-2"></i>
            </button>
        </td>
    `;
    
    tbody.appendChild(row);
}

function removeStudentRow(button) {
    const row = button.closest('tr');
    const rowIndex = Array.from(row.parentNode.children).indexOf(row);
    
    // Prevent removal of the first row
    if (rowIndex === 0) {
        return;
    }
    
    row.remove();
    updateRowNumbers();
}

function updateRowNumbers() {
    const rows = document.querySelectorAll('#studentsTableBody tr');
    rows.forEach((row, index) => {
        row.cells[0].textContent = index + 1;
    });
}

function updateFileCount(input) {
    const studentId = input.closest('.file-upload-area').dataset.student;
    const count = input.files.length;
    document.getElementById(`count-${studentId}`).textContent = count;
    
    // Update file preview
    updateFilePreview(input, studentId);
}

function updateFilePreview(input, studentId) {
    const container = document.getElementById(`preview-${studentId}`);
    container.innerHTML = '';
    
    Array.from(input.files).forEach(file => {
        const preview = document.createElement('div');
        preview.className = 'file-preview';
        preview.innerHTML = `
            <i class="feather feather-file"></i> ${file.name}
            <small class="text-muted">(${(file.size / 1024 / 1024).toFixed(2)} MB)</small>
        `;
        container.appendChild(preview);
    });
}

function previewUploads() {
    const students = [];
    const rows = document.querySelectorAll('#studentsTableBody tr');
    
    rows.forEach((row, index) => {
        const fileInput = row.querySelector('input[name*="[assessment_files]"]');
        const files = Array.from(fileInput.files).map(f => f.name);
        
        students.push({
            studentId: `Student ${index + 1}`,
            files,
            count: files.length
        });
    });
    
    // Show preview in modal
    const previewContent = document.getElementById('previewContent');
    let html = '<div class="table-responsive"><table class="table table-sm">';
    html += '<thead><tr><th>Student Group</th><th>Files</th><th>Count</th></tr></thead><tbody>';
    
    students.forEach(student => {
        html += `<tr>
            <td><strong>${student.studentId}</strong></td>
            <td>${student.files.map(f => `<span class="badge badge-secondary">${f}</span>`).join(' ')}</td>
            <td><span class="badge badge-primary">${student.count}</span></td>
        </tr>`;
    });
    
    html += '</tbody></table></div>';
    html += '<div class="alert alert-info mt-3">';
    html += '<small><i class="feather feather-info"></i> Student IDs will be extracted by AI during assessment processing.</small>';
    html += '</div>';
    previewContent.innerHTML = html;
    
    $('#previewModal').modal('show');
}
</script>

@include('layouts.footer')
