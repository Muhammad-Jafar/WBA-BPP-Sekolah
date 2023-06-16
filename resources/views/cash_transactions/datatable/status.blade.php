@role('admin')
	@if ($model->is_paid == 'PENDING')
		<span class="badge rounded-pill bg-warning">
			{{ $model->is_paid }}
		</span>
	@elseif ($model->is_paid == 'APPROVED')
		<span class="badge rounded-pill bg-success">
			{{ $model->is_paid }}
		</span>
	@endif
@endrole
@role('supervisor')
	<span class="badge bg-warning">Diakses oleh admin</span>
@endrole
