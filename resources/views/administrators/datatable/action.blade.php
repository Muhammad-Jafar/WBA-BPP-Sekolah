@role('admin')
	<div class="btn-group" role="group">
			@if (auth()->id() === $model->id)
			<div class="mx-1">
					<button type="button" data-id="{{ $model->id }}" class="btn btn-success administrator-edit"
							data-bs-toggle="modal" data-bs-target="#editAdministratorModal">
							<i class="bi bi-pencil-square"></i>
					</button>
			</div>
			@endif
	</div>
@endrole
@role('supervisor')
	<span class="badge bg-warning">Diakses oleh admin</span>
@endrole
