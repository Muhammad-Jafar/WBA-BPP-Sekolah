<script>
	$(function () {
        $('#filter').click(function () {
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();

            $.ajax({
                url: "{{ route('cash-transactions.filter') }}",
                data: {
                    start_date: start_date,
                    end_date: end_date,
                },
                success: function (res) {
                    $('#datatable-wrap').removeAttr('style');

                    Toastify({
                        text: "Berhasil mengambil data",
                        duration: 3000,
                        close: true,
                        backgroundColor: "#4fbe87",
                    }).showToast();

                    $('#datatable').DataTable({
                        data: res.data,
                        destroy: true,
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
                },
                error: function () {
                    $('#datatable-wrap').css('display', 'none');

                    Toastify({
                        text: "Kesalahan internal!",
                        duration: 3000,
                        close: true,
                        backgroundColor: "#f3616d",
                    }).showToast()
                }
            });
        });
    });
</script>
