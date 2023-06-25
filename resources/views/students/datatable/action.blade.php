@role('admin')
	<div class="btn-group" role="group">
			<div class="mx-1">
				{{-- <a href="{{ route('students.edit', $model->id) }}">
					<button type="button" class="btn btn-success"><i class="bi bi-pencil-square"></i></button>
				</a> --}}

					<button type="button" data-id="{{ $model->id }}" class="btn btn-success student-edit"
						data-bs-toggle="modal" data-bs-target="#editStudentModal">
						<i class="bi bi-pencil-square"></i>
				</button>
			</div>

			<div class="mx-1">
					<form action="{{ route('students.destroy', $model->id) }}" method="POST">
							@csrf @method('DELETE')
							<button type="submit" class="btn btn-danger delete-notification">
									<i class="bi bi-trash-fill"></i>
							</button>
					</form>
			</div>
	</div>
@endrole
@role('supervisor')
	<span class="badge bg-warning">Diakses oleh admin</span>
@endrole
