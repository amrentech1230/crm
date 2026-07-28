<style>
	.dashboard-page {
		background: linear-gradient(135deg, #f4f7ff 0%, #fff 48%, #f0fbf8 100%);
		min-height: 100vh;
		padding: 1.5rem;
	}
	.dashboard-page .page-title-box {
		background: linear-gradient(120deg, #4338ca, #0f766e);
		border-radius: 18px;
		padding: 1.25rem 1.5rem;
		margin-bottom: 1.5rem;
		box-shadow: 0 12px 28px rgba(67, 56, 202, .18);
	}
	.dashboard-page .page-title-box h4,
	.dashboard-page .page-title-box .breadcrumb-item,
	.dashboard-page .page-title-box .breadcrumb-item a { color: #fff !important; }
	.dashboard-page .card {
		border: 0;
		border-radius: 18px;
		box-shadow: 0 8px 24px rgba(30, 41, 59, .08);
		overflow: hidden;
		transition: transform .2s ease, box-shadow .2s ease;
	}
	.dashboard-page .card:hover { transform: translateY(-4px); box-shadow: 0 14px 30px rgba(30, 41, 59, .14); }
	.dashboard-page .row:first-of-type > div:nth-child(4n+1) .card { border-top: 4px solid #6366f1; }
	.dashboard-page .row:first-of-type > div:nth-child(4n+2) .card { border-top: 4px solid #10b981; }
	.dashboard-page .row:first-of-type > div:nth-child(4n+3) .card { border-top: 4px solid #f59e0b; }
	.dashboard-page .row:first-of-type > div:nth-child(4n) .card { border-top: 4px solid #ec4899; }
	.dashboard-page .avatar-title { box-shadow: 0 6px 14px rgba(0,0,0,.08); }
	.dashboard-page .card-body { padding: 1.35rem; }
	.dashboard-page .chart-container { padding: 1.5rem; }
	.dashboard-page .chart-container h2 { color: #1e293b; font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; }
	.dashboard-page form { flex-wrap: wrap; align-items: flex-end; width: 100%; }
	.dashboard-page form > div { flex: 1 1 145px; }
	.dashboard-page form .d-flex.gap-3 { flex: 2 1 260px; }
	.dashboard-page form .d-flex.align-items-end { flex: 0 1 auto; }
	.dashboard-page label { color: #475569; font-size: .78rem; font-weight: 700; margin-bottom: .35rem; }
	.dashboard-page .form-control { border: 1px solid #dbe3ef; border-radius: 9px; min-height: 40px; }
	.dashboard-page .form-control:focus { border-color: #6366f1; box-shadow: 0 0 0 .2rem rgba(99,102,241,.15); }
	.dashboard-page .btn { border: 0; border-radius: 9px; font-weight: 600; }
	.dashboard-page .btn-primary { background: linear-gradient(135deg, #4f46e5, #7c3aed); }
	.dashboard-page .btn-success { background: linear-gradient(135deg, #059669, #14b8a6); }
	.dashboard-page .accordion-item { border: 1px solid #edf2f7; margin-bottom: .5rem; border-radius: 10px !important; overflow: hidden; }
	.dashboard-page .accordion-button { color: #334155; background: #f8fafc; }
	.dashboard-page .accordion-button:not(.collapsed) { color: #4338ca; background: #eef2ff; box-shadow: none; }
	@media (max-width: 768px) { .dashboard-page { padding: .75rem; } .dashboard-page form .d-flex.align-items-end { width: 100%; } .dashboard-page form .d-flex.align-items-end .btn { flex: 1; } }
</style>
<div class="container-fluid dashboard-page">
	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div
				class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">Dashboard</h4>

				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a
								href="javascript: void(0);">CCI</a></li>
						<li class="breadcrumb-item active">Dashboard</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<!-- end page title -->

	<div class="row">
		<div class="col-xl-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<p class="text-truncate font-size-14 mb-2">Total Revenue</p>
							<h4 class="mb-2">${{ $revenue }}</h4>
							
						</div>
						<div class="avatar-sm">
							<span class="avatar-title bg-light text-primary rounded-3">
								<i class="mdi mdi-currency-usd font-size-24"></i>
							</span>
						</div>
					</div>
				</div>
				<!-- end cardbody -->
			</div>
			<!-- end card -->
		</div>
		<!-- end col -->
		<div class="col-xl-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<p class="text-truncate font-size-14 mb-2">Total Margin</p>
							<h4 class="mb-2">${{ $finalTotal }}</h4>
							
						</div>
						<div class="avatar-sm">
							<span class="avatar-title bg-light text-success rounded-3">
								<i class="mdi mdi-currency-usd font-size-24"></i>
							</span>
						</div>
					</div>
				</div>
				<!-- end cardbody -->
			</div>
			<!-- end card -->
		</div>
		<!-- end col -->
		<div class="col-xl-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<p class="text-truncate font-size-14 mb-2">Yesterday Loads
							</p>
							<h4 class="mb-2">{{ $loadCount }}</h4>
							
						</div>
						<div class="avatar-sm">
							<span class="avatar-title bg-light text-primary rounded-3">
								<i class="ri-shopping-cart-2-line font-size-24"></i>
							</span>
						</div>
					</div>
				</div>
				<!-- end cardbody -->
			</div>
			<!-- end card -->
		</div>
		<!-- end col -->
		<div class="col-xl-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<p class="text-truncate font-size-14 mb-2">Total Customer
								Added
							</p>
							<h4 class="mb-2">{{ $newCoustmerAdded }}</h4>
							
						</div>
						<div class="avatar-sm">
							<span class="avatar-title bg-light text-success rounded-3">
								<i class="ri-user-3-line font-size-24"></i>
							</span>
						</div>
					</div>
				</div>
				<!-- end cardbody -->
			</div>
			<!-- end card -->
		</div>
				<div class="col-xl-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<p class="text-truncate font-size-14 mb-2">Total Revenue</p>
							<h4 class="mb-2">${{ $revenue }}</h4>
							
						</div>
						<div class="avatar-sm">
							<span class="avatar-title bg-light text-primary rounded-3">
								<i class="mdi mdi-currency-usd font-size-24"></i>
							</span>
						</div>
					</div>
				</div>
				<!-- end cardbody -->
			</div>
			<!-- end card -->
		</div>
		<!-- end col -->
		<div class="col-xl-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<p class="text-truncate font-size-14 mb-2">Total Margin</p>
							<h4 class="mb-2">${{ $finalTotal }}</h4>
							
						</div>
						<div class="avatar-sm">
							<span class="avatar-title bg-light text-success rounded-3">
								<i class="mdi mdi-currency-usd font-size-24"></i>
							</span>
						</div>
					</div>
				</div>
				<!-- end cardbody -->
			</div>
			<!-- end card -->
		</div>
		<!-- end col -->
		<div class="col-xl-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<p class="text-truncate font-size-14 mb-2">Yesterday Loads
							</p>
							<h4 class="mb-2">{{ $loadCount }}</h4>
							
						</div>
						<div class="avatar-sm">
							<span class="avatar-title bg-light text-primary rounded-3">
								<i class="ri-shopping-cart-2-line font-size-24"></i>
							</span>
						</div>
					</div>
				</div>
				<!-- end cardbody -->
			</div>
			<!-- end card -->
		</div>
		<!-- end col -->
		<div class="col-xl-3 col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<p class="text-truncate font-size-14 mb-2">Total Customer
								Added
							</p>
							<h4 class="mb-2">{{ $newCoustmerAdded }}</h4>
							
						</div>
						<div class="avatar-sm">
							<span class="avatar-title bg-light text-success rounded-3">
								<i class="ri-user-3-line font-size-24"></i>
							</span>
						</div>
					</div>
				</div>
				<!-- end cardbody -->
			</div>
			<!-- end card -->
		</div>
		<!-- end col -->
	</div>
	<!-- end row -->

	<div class="row">
		
		<div class="col-xl-8">
		
			<div class="card">
				<div class="card-body">
					<div class="d-flex">
					<form class="d-flex gap-3" method="GET" action="{{ url()->current() }}">
					  <div>
						<label for="periodSelect">Period</label>
						<select name="period" id="periodSelect" class="form-control">
							<option value="weekly" {{ request('period', 'weekly') == 'weekly' ? 'selected' : '' }}>Weekly</option>
							<option value="monthly" {{ request('period') == 'monthly' ? 'selected' : '' }}>Monthly</option>
							<option value="yearly" {{ request('period') == 'yearly' ? 'selected' : '' }}>Yearly</option>
							<option value="custom" {{ request('period') == 'custom' ? 'selected' : '' }}>Date Range</option>
						</select>
					  </div>
					  <div id="customDateRange" class="d-flex gap-3 {{ request('period') == 'custom' ? '' : 'd-none' }}">
						<div>
							<label for="startdate">From</label>
							<input type="date" id="startdate" name="startdate" class="form-control" value="{{ request('startdate') }}">
						</div>
						<div>
							<label for="enddate">To</label>
							<input type="date" id="enddate" name="enddate" class="form-control" value="{{ request('enddate') }}">
						</div>
					  </div>
					  <div>
						<label>Office</label>
						<select name="office" class="form-control" id="officeSelect">
							<option value="">Select Office</option>
							@foreach($office as $offices)
								<option value="{{ $offices->id }}" 
									{{ (request('office') == $offices->id) ? 'selected' : '' }}>
									{{ $offices->office_name }}
								</option>
							@endforeach
						</select>
					  </div>
					  <div>
						<label>Agent</label>
						<select name="agent" class="form-control" id="agentSelect">
							<option value="">Select Agent</option>
							@foreach($agents_data as $agent)
								<option value="{{ $agent->id }}" 
									{{ (request('agent') == $agent->id) ? 'selected' : '' }}>
									{{ $agent->name }}
								</option>
							@endforeach
							
						</select>
					  </div>
					  <div class="d-flex align-items-end gap-2">
					  <button type="submit" class="btn btn-primary waves-effect waves-light mt-4" name="submit" value="filter">Filter</button>
					  <button type="submit" class="btn btn-success waves-effect waves-light mt-4" name="export" value="excel">Download Excel</button>
					  </div>
					</form>
					<script>
						document.getElementById('periodSelect').addEventListener('change', function () {
							document.getElementById('customDateRange').classList.toggle('d-none', this.value !== 'custom');
						});
					</script>
					</div>
				</div>
				<!-- end cardbody -->
			</div>
		
			<div class="card">
				<div class="chart-container">
					<h2>Daily Sales</h2>
					<canvas id="salesChart"></canvas>
				</div>
			</div>
			<!-- end card -->
		</div>
		<div class="col-xl-4">
			<div class="card">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<p class="text-truncate font-size-14 mb-2">Total Loads
							</p>
							<h4 class="mb-2">{{ $count }}</h4>
						</div>
						<div class="avatar-sm">
							<span class="avatar-title bg-light text-primary rounded-3">
								<i class="ri-shopping-cart-2-line font-size-24"></i>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<p class="text-truncate font-size-14 mb-2">Total Agents
							</p>
							<h4 class="mb-2">{{ $agents }}</h4>
						</div>
						<div class="avatar-sm">
							<span class="avatar-title bg-light text-primary rounded-3">
								<i class="ri-user-3-line font-size-24"></i>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<p class="text-truncate font-size-14 mb-2">Maximum Loads With Customers</p>
					<div class="accordion" id="accordionExample">
					@foreach($topMaximumLoadCustomers as $key => $loadCount)
						<div class="accordion-item">
							<h2 class="accordion-header" id="heading{{ $key }}">
								<button class="accordion-button {{ $key === 0 ? '' : 'collapsed' }}" 
										type="button" style="font-weight: 600;"
										data-bs-toggle="collapse" 
										data-bs-target="#collapse{{ $key }}" 
										aria-expanded="{{ $key === 0 ? 'true' : 'false' }}" 
										aria-controls="collapse{{ $key }}">
									{{ $loadCount->load_bill_to }}
								</button>
							</h2>
							<div id="collapse{{ $key }}" 
								 class="accordion-collapse collapse {{ $key === 0 ? 'show' : '' }}" 
								 aria-labelledby="heading{{ $key }}" 
								 data-bs-parent="#accordionExample">
								<div class="accordion-body">
									<div class="d-flex justify-content-between">
										<span>Total Loads</span>
										<span style="cursor: pointer; color: #007bff; font-weight: 600;"
											  data-bs-toggle="modal" 
											  data-bs-target="#dashboard-load-modal"
											  data-customer="{{ $loadCount->load_bill_to }}">
											{{ $loadCount->load_count }}
										</span>
									</div>
								</div>
							</div>
						</div>
					@endforeach
					</div>

				</div>
			</div>
			<!-- end card -->
		</div>
		<!-- end row -->

	   
	</div>
	<!-- end row -->
</div>
<script>
$(document).ready(function() {

    // When Office is selected
    $('#officeSelect').on('change', function() {
        var officeId = $(this).val();
        if (officeId) {
            $.ajax({
                url: '/account/get-related-agent/' + officeId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    
                    // Populate Agents
                    $('#agentSelect').empty().append('<option value="">-- Select Agent --</option>');
                    $.each(data.agents, function(key, value) {
                        $('#agentSelect').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            // Reset all if no office
            $('#agentSelect').empty().append('<option value="">Select Agent</option>');
        }
    });
});
</script>
<script>

// Select all accordion items
const accordionItems = document.querySelectorAll('.accordion-item');

accordionItems.forEach(item => {
    // When the mouse enters the element
    item.addEventListener('mouseenter', () => {
        item.style.filter = 'blur(0)';
    });

    // When the mouse leaves the element
    item.addEventListener('mouseleave', () => {
        item.style.filter = ''; // or 'none' to clear it
    });
});

</script>