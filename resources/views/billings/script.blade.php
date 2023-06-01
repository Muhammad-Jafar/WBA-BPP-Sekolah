<script>
   $(function () {
      let loadingAlert = $('.modal-body #loading-alert');

      $('#datatable').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{ route('billings.index')}}",
         columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'students.student_identification_number', name: 'students.student_identification_number' },
            { data: 'students.name', name: 'students.name' },
            { data: 'billings', name: 'billings' },
			{ data: 'recent_bill', name: 'recent_bill' },
			{ data: 'status', name: 'status' },
         ]
      });


   });
</script>
