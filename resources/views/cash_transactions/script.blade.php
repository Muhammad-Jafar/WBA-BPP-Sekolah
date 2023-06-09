<script>
	$(function () {
		let loadingAlert = $('.modal-body #loading-alert');

		$('#datatable').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('cash-transactions.index') }}",
			columns: [
				{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
				{ data: 'transaction_code', name: 'transaction_code' },
				{ data: 'students.name', name: 'students.name' },
				{ data: 'amount', name: 'amount' },
				{ data: 'paid_on', name: 'paid_on' },
				{ data: 'note', name: 'note' },
				{ data: 'is_paid', name: 'is_paid' },
			]
		});

	});
</script>
