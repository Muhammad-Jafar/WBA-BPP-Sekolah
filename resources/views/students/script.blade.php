<script>
	$(function () {
		let loadingAlert = $('.modal-body #loading-alert');

		$('#datatable').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('students.index') }}",
			columns: [
				{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
				{ data: 'student_identification_number', name: 'student_identification_number' },
				{ data: 'name', name: 'name' },
				{ data: 'gender', name: 'gender' },
				{ data: 'email', name: 'email' },
				{ data: 'phone_number', name: 'phone_number' },
				{ data: 'school_class_id', name: 'school_classes.name' },
				{ data: 'school_major', name: 'school_majors.name' },
				{ data: 'school_year_start', name: 'school_year_start' },
				{ data: 'action', name: 'action' },
			]
		});

		$('#datatable').on('click', '.student-edit', function () {
			loadingAlert.show();

			let id = $(this).data('id');
			let url = "{{ route('api.student.edit', ':param') }}";
			url = url.replace(':param', id);


			let formActionURL = "{{ route('students.update', ':param') }}"
			formActionURL = formActionURL.replace(':param', id);

			let editStudentModalEveryInput = $('#editStudentModal :input').not('button[type=button], input[name=_token], input[name=_method]')
				.each(function () {
					$(this).not('select').val('Sedang mengambil data..');
					$(this).prop('disabled', true);
				});

			$.ajax({
				url: url,
				headers: {
					'Authorization': 'Bearer ' + localStorage.getItem('token'),
					'Accept': 'application/json',
				},

				success: function (response) {
					loadingAlert.slideUp();

					editStudentModalEveryInput.prop('disabled', false);

					$('#editStudentModal #edit-student-form').attr('action', formActionURL)

					$('#editStudentModal #student_identification_number').val(response.data.student_identification_number);
					$('#editStudentModal #name').val(response.data.name);
					$('#editStudentModal #gender').val(response.data.gender);
					$('#editStudentModal #school_class_id').val(response.data.school_class_id).select2();
					$('#editStudentModal #school_major_id').val(response.data.school_major_id).select2();
					$('#editStudentModal #email').val(response.data.email);
					$('#editStudentModal #phone_number').val(response.data.phone_number);
					$('#editStudentModal #school_year_start').val(response.data.school_year_start);
					$('#editStudentModal #school_year_end').val(response.data.school_year_end);
				}
			});
		});
		
	});
</script>
