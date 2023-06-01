@role('admin')
<span class="badge rounded-pill bg-warning">
	{{ $model->is_paid }}
</span>
@endrole
@role('supervisor')
	<span class="badge bg-warning">Diakses oleh admin</span>
@endrole
