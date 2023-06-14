@extends('layouts.main', ['title' => 'Tagihan', 'page_heading' => 'Data Tagihan'])

@section('content')
<section class="row">
   {{-- Start Statistics --}}
   <div class="col-6 col-lg-6 col-md-6">
		<div class="card">
			<div class="card-body px-3 py-4-4">
				<div class="row">
					<div class="col-md-4">
						<div class="stats-icon green">
							<i class="iconly-boldChart"></i>
						</div>
					</div>
					<div class="col-md-8">
						<h6 class="text-muted font-semibold">Total siswa telah melunasi</h6>
						<h5 class="font-extrabold mb-0"> {{ $data['students']['countStudentWhoHasBillingsDone'] }} </h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-6 col-lg-6 col-md-6">
		<div class="card">
			<div class="card-body px-3 py-4-4">
				<div class="row">
					<div class="col-md-4">
						<div class="stats-icon red">
							<i class="iconly-boldChart"></i>
						</div>
					</div>
					<div class="col-md-8">
						<h6 class="text-muted font-semibold">Total siswa belum melunasi</h6>
						<h5 class="font-extrabold mb-0"> {{ $data['students']['countStudentWhoHasBillingsDoneYet'] }}</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
   {{-- End of Statistics --}}

   @include('utilities.alert-flash-message')
   <div class="col card px-3 py-3">
      <div class="d-flex justify-content-end pb-3">
         <div class="btn-group d-gap gap-2">
						@role('admin')
							<a href="{{ route('billings.export') }}" class="btn btn-success">
								<i class="bi bi-file-earmark-excel-fill"></i>
								Export Excel
							</a>
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBillingsModal">
								<i class="bi bi-plus-circle"></i> Tambah Data
							</button>
            @endrole
         </div>
      </div>

      <div class="table-responsive">
         <table class="table table-sm w-100" id="datatable">
            <thead>
                <th scope="col">#</th>
                <th scope="col">NIS</th>
                <th scope="col">Nama Siswa</th>
                <th scope="col">Total tagihan</th>
                <th scope="col">total lunas</th>
                <th scope="col">status</th>
            </thead>
            <tbody>
            </tbody>
         </table>
      </div>
   </div>
</section>
@endsection

@push('modal')
@include('billings.modal.create')
@endpush


@push('js')
@include('billings.script')
@endpush
