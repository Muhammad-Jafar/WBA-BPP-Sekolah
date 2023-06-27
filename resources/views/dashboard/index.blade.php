@extends('layouts.main', ['title' => 'Dashboard', 'page_heading' => 'Dashboard'])

@section('content')
<section class="row">
	<div class="col-12 col-lg-12">
		<div class="row">
			<div class="col-6 col-lg-3 col-md-6">
				<a href="{{ route('students.index') }}">
					<div class="card card-stat">
						<div class="card-body px-3 py-4-5">
							<div class="row">
								<div class="col-md-4">
									<div class="stats-icon purple">
										<i class="iconly-boldProfile"></i>
									</div>
								</div>
								<div class="col-md-8">
									<h6 class="text-muted font-semibold">Siswa</h6>
									<h6 class="font-extrabold {{ $studentCount <= 0 ? 'text-danger' : '' }} mb-0">
										{{ $studentCount }}
									</h6>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-6 col-lg-3 col-md-6">
				<div class="card card-stat">
					<div class="card-body px-3 py-4-5">
						<div class="row">
							<div class="col-md-4">
								<div class="stats-icon blue">
									<i class="iconly-boldBookmark"></i>
								</div>
							</div>
							<div class="col-md-8">
								<h6 class="text-muted font-semibold">Kelas</h6>
								<h6 class="font-extrabold {{ $schoolClassCount <= 0 ? 'text-danger' : '' }} mb-0">
									{{ $schoolClassCount }}
								</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-6 col-lg-3 col-md-6">
				<div class="card card-stat">
					<div class="card-body px-3 py-4-5">
						<div class="row">
							<div class="col-md-4">
								<div class="stats-icon green">
									<i class="iconly-boldWork"></i>
								</div>
							</div>
							<div class="col-md-8">
								<h6 class="text-muted font-semibold">Jurusan</h6>
								<h6 class="font-extrabold {{ $schoolMajorCount <= 0 ? 'text-danger' : '' }} mb-0">
									{{ $schoolMajorCount }}
								</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-6 col-lg-3 col-md-6">
				<a href="{{ route('cash-transactions.index') }}">
					<div class="card card-stat">
						<div class="card-body px-3 py-4-5">
							<div class="row">
								<div class="col-md-4">
									<div class="stats-icon red">
										<i class="iconly-boldTicket"></i>
									</div>
								</div>
								<div class="col-md-8">
									<h6 class="text-muted font-semibold">Transaksi 3 bulan terakhir</h6>
									<h6 class="font-extrabold mb-0">{{ $amountThisMonth }}</h6>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		@include('dashboard.charts.chart')
		<div class="row">
			<div class="col-12 col-xl-12">
				<div class="card">
					<div class="card-header">
						<h4>5 transaksi terakhir</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-lg">
								<thead>
									<tr>
										<th>Daftar</th>
										<th>Kode transaksi</th>
										<th>Nama Siswa</th>
										<th>Jumlah Bayar</th>
										<th>Tanggal</th>
										<th>Catatan</th>
									</tr>
								</thead>
								<tbody>
									@forelse($latestCashTransactions as $latestCashTransaction)
									<tr>
										<td class="col-auto">
											<div class="d-flex align-items-center">
												<p class="font-bold ms-3 mb-0">
													{{ $loop->iteration }}
												</p>
											</div>
										</td>
										<td class="col-auto">
											<div class="d-flex align-items-center">
												<p class="font-bold ms-3 mb-0">
													{{ $latestCashTransaction->transaction_code }}
												</p>
											</div>
										</td>
										<td class="col-auto">
											<div class="d-flex align-items-center">
												<p class="font-bold ms-3 mb-0">
													{{ $latestCashTransaction->students->name }}
												</p>
											</div>
										</td>
										<td class="col-auto">
											<p class=" mb-0">
												{{ indonesianCurrency($latestCashTransaction->amount) }}
											</p>
										</td>
										<td class="col-auto">
											<p class=" mb-0">
												{{ date('d M Y', strtotime($latestCashTransaction->paid_on)) }}
											</p>
										</td>
											<td class="col-auto">
											<p class=" mb-0">
												{{ $latestCashTransaction->note }}
											</p>
										</td>
									</tr>
									@empty
									<tr>
										<td colspan="5">
											<p class="fw-bold text-danger text-center text-uppercase">Data kosong!</p>
										</td>
									</tr>
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
