<div class="sidebar-header">
	<div class="d-flex justify-content-center">
		<div class="logo">
			<a href="{{ route('dashboard') }}" class="d-flex justify-content-center">
				<img class="align-item-center" style="width:96px; height:128px; padding:8px" src="{{ asset('img/logo/app-logo.png') }}" alt="logo">
			</a>
			<h5 class="text-center">Layanan BPP</h5>
			<h6 class="text-center">SMAN 1 ALAS</h6>
		</div>
		<div class="toggler">
			<a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
		</div>
	</div>
</div>
<div class="sidebar-menu">
	<ul class="menu">
		<li class="sidebar-title">Menu - {{ auth()->user()->name }}</li>
		<li class="sidebar-item {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
			<a href="{{ route('dashboard') }}" class='sidebar-link'>
				<i class="bi bi-grid-fill"></i>
				<span>Dashboard</span>
			</a>
		</li>
		@hasrole('admin')
			<li class="sidebar-item {{ request()->routeIs('students.*') ? 'active' : '' }}">
				<a href="{{ route('students.index') }}" class='sidebar-link'>
					<i class="bi bi-people-fill"></i>
					<span>Siswa</span>
				</a>
			</li>
			{{-- <li class="sidebar-item has-sub {{ request()->routeIs('cash-transactions.*') ? 'active' : '' }}">
				<a href="#" class='sidebar-link'>
					<i class="bi bi-cash-stack"></i>
					<span>Transaksi</span>
				</a>
				<ul class="submenu {{ request()->routeIs('cash-transactions.*') ? 'active' : '' }}">
					<li class="submenu-item {{ request()->routeIs('cash-transactions.index') ? 'active' : '' }}">
						<a href="{{ route('cash-transactions.index') }}">Data Transaksi</a>
					</li>
					<li class="submenu-item {{ request()->routeIs('cash-transactions.filter') ? 'active' : '' }}">
						<a href="{{ route('cash-transactions.filter') }}">Filter Transaksi</a>
					</li>
				</ul>
			</li> --}}
			<li class="sidebar-item {{ request()->is('cash-transactions*') ? 'active' : '' }}">
				<a href="{{ route('cash-transactions.index') }}" class='sidebar-link'>
					<i class="bi bi-cash-stack"></i>
					<span>Transaksi</span>
				</a>
			</li>
			<li class="sidebar-item {{ request()->is('billings*') ? 'active' : '' }}">
				<a href="{{ route('billings.index') }}" class='sidebar-link'>
					<i class="bi bi-receipt"></i>
					<span>Tagihan</span>
				</a>
			</li>
			<li class="sidebar-item {{ request()->is('report*') ? 'active' : '' }}">
				<a href="{{ route('report.index') }}" class='sidebar-link'>
					<i class="bi bi-menu-app-fill"></i>
					<span>Laporan</span>
				</a>
			</li>
			{{-- <li class="sidebar-item {{ request()->routeIs('administrators.*') ? 'active' : '' }}">
				<a href="{{ route('administrators.index') }}" class='sidebar-link'>
					<i class="bi bi-person-badge-fill"></i>
					<span>Administrator</span>
				</a>
			</li> --}}
		@elserole('supervisor')
			<li class="sidebar-item {{ request()->is('report*') ? 'active' : '' }}">
				<a href="{{ route('report.index') }}" class='sidebar-link'>
					<i class="bi bi-menu-app-fill"></i>
					<span>Rekapitulasi</span>
				</a>
			</li>
		@endrole
		<li class="sidebar-item">
			<form method="POST" action="{{ route('logout') }}" id="logout">
				@csrf
				<a href="{{ route('logout') }}" class='sidebar-link'>
					<i class="bi bi-box-arrow-left"></i>
					<span>Logout</span>
				</a>
			</form>
		</li>
	</ul>
</div>
<button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
