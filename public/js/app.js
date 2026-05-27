$(function () {
    const csrfToken = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').first().val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    function showAlert(type, message) {
        const $alert = $('#student-alert');
        if (!$alert.length) {
            return;
        }

        $alert.html(`<div class="alert alert-${type}" role="alert">${message}</div>`);
    }

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    function studentRow(student) {
        const middleName = student.mname ? ` ${escapeHtml(student.mname)}` : '';
        const degree = escapeHtml(student.degree || 'N/A');

        return `
            <tr id="student-row-${student.id}">
                <td>${escapeHtml(student.fname)}${middleName} ${escapeHtml(student.lname)}</td>
                <td>${escapeHtml(student.age)}</td>
                <td>${degree}</td>
                <td>
                    <div class="action-buttons">
                        <a href="/student/${student.id}" class="btn btn-info">View</a>
                        <a href="/student/${student.id}/edit" class="btn btn-primary">Edit</a>
                        <a href="/student/${student.id}/delete" class="btn btn-danger">Delete</a>
                    </div>
                </td>
            </tr>
        `;
    }

    function loadStudents(url) {
        const requestUrl = url || $('#student-filter-form').attr('action') || '/students';

        $.ajax({
            url: requestUrl,
            method: 'GET',
            data: $('#student-filter-form').serialize(),
            success: function (response) {
                const rows = response.students.length
                    ? response.students.map(studentRow).join('')
                    : '<tr><td colspan="4">No students found.</td></tr>';

                $('#students-table-body').html(rows);
                $('.pagination-wrapper').html(response.pagination_html);
            },
            error: function () {
                showAlert('danger', 'Unable to load students.');
            }
        });
    }

    if ($('#students-table-body').length) {
        loadStudents();
    }

    const $createForm = $('[data-clear-login-fields="true"]');
    if ($createForm.length) {
        setTimeout(function () {
            $createForm.find('[name="username"], [name="password"]').val('');
        }, 100);
    }

    $('#student-filter-form').on('submit', function (event) {
        event.preventDefault();
        loadStudents($(this).attr('action'));
    });

    $('.pagination-wrapper').on('click', 'a', function (event) {
        event.preventDefault();
        loadStudents($(this).attr('href'));
    });


    $('.student-ajax-form').on('submit', function (event) {
        event.preventDefault();

        const $form = $(this);
        const $button = $form.find('[type="submit"]');
        const originalText = $button.html();

        $button.prop('disabled', true).html('Saving...');
        $form.find('.ajax-error').remove();
        $form.find('.is-invalid').removeClass('is-invalid');

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function (response) {
                showAlert('success', response.message);
                setTimeout(function () {
                    window.location.href = $form.data('redirect') || '/students';
                }, 700);
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function (field, messages) {
                        const $input = $form.find(`[name="${field}"]`);
                        $input.addClass('is-invalid');
                        $input.after(`<span class="text-danger ajax-error" style="font-size: 0.75rem; margin-top: 2px;">${messages[0]}</span>`);
                    });
                    showAlert('danger', 'Please fix the errors below.');
                    return;
                }

                showAlert('danger', xhr.responseJSON?.message || 'Unable to save student.');
            },
            complete: function () {
                $button.prop('disabled', false).html(originalText);
            }
        });
    });
});
