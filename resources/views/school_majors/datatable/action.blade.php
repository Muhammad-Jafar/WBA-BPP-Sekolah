@role('admin')
	<div class="btn-group" role="group">
			<div class="mx-1">
					<button type="button" data-id="{{ $model->id }}" class="btn btn-success school-major-edit"
							data-bs-toggle="modal" data-bs-target="#editSchoolMajorModal">
							<i class="bi bi-pencil-square"></i>
					</button>
			</div>

			<div class="mx-1">
					<form action="{{ route('school-majors.destroy', $model->id) }}" method="POST">
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

