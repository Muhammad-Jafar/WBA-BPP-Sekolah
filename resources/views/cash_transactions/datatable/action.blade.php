@role('admin')
	<div class=" btn-group" role="group">
			<div class="mx-1">
					<button type="button" data-id="{{ $model->id }}" class="btn btn-primary cash-transaction-detail"
							data-bs-toggle="modal" data-bs-target="#showCashTransactionModal">
							<i class="bi bi-search"></i>
					</button>
			</div>

			<div class="mx-1">
					<button type="button" data-id="{{ $model->id }}" class="btn btn-success cash-transaction-edit"
							data-bs-toggle="modal" data-bs-target="#editCashTransactionModal">
							<i class="bi bi-pencil-square"></i>
					</button>
			</div>

			<div class="mx-1">
					<form action="{{ route('cash-transactions.destroy', $model->id) }}" method="POST">
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
