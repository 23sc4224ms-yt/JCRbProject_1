import './bootstrap';

$(document).ready(function() {
    // Set up CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ============================================
    // READ (LOAD) 
    // ============================================
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        
        const url = $(this).attr('href');
        const params = new URLSearchParams(url.split('?')[1]);
        
        // Add filters to the request
        const filterParams = {
            q: $('input[name="q"]').val(),
            degree_id: $('select[name="degree_id"]').val(),
            age_min: $('input[name="age_min"]').val(),
            age_max: $('input[name="age_max"]').val(),
            page: params.get('page')
        };
        
        loadStudents(filterParams);
    });

    // Filter form submission
    $('#student-filter-form').on('submit', function(e) {
        e.preventDefault();
        
        const filterParams = {
            q: $('input[name="q"]').val(),
            degree_id: $('select[name="degree_id"]').val(),
            age_min: $('input[name="age_min"]').val(),
            age_max: $('input[name="age_max"]').val(),
            page: 1
        };
        
        loadStudents(filterParams);
    });

    // Function to load students with filters and pagination
    function loadStudents(filterParams) {
        $.ajax({
            url: '/students',
            type: 'GET',
            data: filterParams,
            dataType: 'json',
            beforeSend: function() {
                $('#students-table-body').html('<tr><td colspan="4" style="text-align: center; padding: 2rem;"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>');
            },
            success: function(response) {
                // Populate table with student data
                let html = '';
                if (response.students.length > 0) {
                    response.students.forEach(function(student) {
                        html += `
                            <tr id="student-row-${student.id}">
                                <td>${student.fname} ${student.mname} ${student.lname}</td>
                                <td>${student.age}</td>
                                <td>${student.degree}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="/student/${student.id}" class="btn btn-info">View</a>
                                        <a href="/student/${student.id}/edit" class="btn btn-primary">Edit</a>
                                        <form action="/student/${student.id}" method="POST" class="action-form student-delete-form">
                                            <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = '<tr><td colspan="4" style="text-align: center;">No students found.</td></tr>';
                }
                
                $('#students-table-body').html(html);
                
                // Update pagination links
                $('.table-pagination').html(response.pagination_html);
            },
            error: function(error) {
                console.error('Error loading students:', error);
                $('#student-alert').html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Error loading students. Please try again.</div>');
            }
        });
    }

    // ============================================
    // CREATE (STORE) - Add Student
    // ============================================
    $('#addStudentForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            fname: $('input[name="fname"]').val(),
            mname: $('input[name="mname"]').val(),
            lname: $('input[name="lname"]').val(),
            age: $('input[name="age"]').val(),
            degree_id: $('select[name="degree_id"]').val(),
            contact: $('input[name="contact"]').val(),
            email: $('input[name="email"]').val(),
            username: $('input[name="username"]').val(),
            password: $('input[name="password"]').val(),
        };

        $.ajax({
            url: '/student',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Creating...');
            },
            success: function(response) {
                // Show success message
                $('#student-alert').html('<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' + response.message + '</div>');
                
                // Reset form
                $('#addStudentForm')[0].reset();
                
                // Redirect after 2 seconds
                setTimeout(function() {
                    window.location.href = '/students';
                }, 2000);
            },
            error: function(error) {
                console.error('Error creating student:', error);
                let errorMsg = 'An error occurred while creating the student.';
                
                if (error.responseJSON && error.responseJSON.message) {
                    errorMsg = error.responseJSON.message;
                } else if (error.responseJSON && error.responseJSON.errors) {
                    errorMsg = Object.values(error.responseJSON.errors)[0][0];
                }
                
                $('#student-alert').html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> ' + errorMsg + '</div>');
                $('button[type="submit"]').prop('disabled', false).html('Create Student');
            }
        });
    });

    // ============================================
    // UPDATE - Edit Student
    // ============================================
    $('#editStudentForm').on('submit', function(e) {
        e.preventDefault();
        
        const studentId = $('input[name="student_id"]').val();
        const formData = {
            fname: $('input[name="fname"]').val(),
            mname: $('input[name="mname"]').val(),
            lname: $('input[name="lname"]').val(),
            age: $('input[name="age"]').val(),
            degree_id: $('select[name="degree_id"]').val(),
            contact: $('input[name="contact"]').val(),
            email: $('input[name="email"]').val(),
            _method: 'PUT'
        };

        $.ajax({
            url: '/student/' + studentId,
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
            },
            success: function(response) {
                // Show success message
                $('#student-alert').html('<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' + response.message + '</div>');
                
                // Redirect after 2 seconds
                setTimeout(function() {
                    window.location.href = '/students';
                }, 2000);
            },
            error: function(error) {
                console.error('Error updating student:', error);
                let errorMsg = 'An error occurred while updating the student.';
                
                if (error.responseJSON && error.responseJSON.message) {
                    errorMsg = error.responseJSON.message;
                } else if (error.responseJSON && error.responseJSON.errors) {
                    errorMsg = Object.values(error.responseJSON.errors)[0][0];
                }
                
                $('#student-alert').html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> ' + errorMsg + '</div>');
                $('button[type="submit"]').prop('disabled', false).html('Update Student');
            }
        });
    });

    // ============================================
    // DELETE - Remove Student
    // ============================================
    $(document).on('submit', '.student-delete-form', function(e) {
        e.preventDefault();
        
        if (!confirm('Are you sure you want to delete this student? This action cannot be undone.')) {
            return;
        }
        
        const form = $(this);
        const studentId = $(this).attr('action').split('/')[2];
        const row = $('#student-row-' + studentId);

        $.ajax({
            url: '/student/' + studentId,
            type: 'DELETE',
            dataType: 'json',
            beforeSend: function() {
                row.css('opacity', '0.5');
            },
            success: function(response) {
                // Show success message
                $('#student-alert').html('<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' + response.message + '</div>');
                
                // Remove row with animation
                row.fadeOut(300, function() {
                    $(this).remove();
                    
                    // Check if there are any rows left
                    if ($('#students-table-body tr').length === 0) {
                        $('#students-table-body').html('<tr><td colspan="4" style="text-align: center;">No students found.</td></tr>');
                    }
                });
            },
            error: function(error) {
                console.error('Error deleting student:', error);
                let errorMsg = 'An error occurred while deleting the student.';
                
                if (error.responseJSON && error.responseJSON.message) {
                    errorMsg = error.responseJSON.message;
                }
                
                $('#student-alert').html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> ' + errorMsg + '</div>');
                row.css('opacity', '1');
            }
        });
    });
});
