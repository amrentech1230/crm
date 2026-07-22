<div class="container-fluid">
	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div
				class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">Dashboard</h4>

				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a
								href="javascript: void(0);">Upcube</a></li>
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
					<form class="d-flex gap-3">
					  <div>
						<label>Start Date</label>
					    <input type="date" name="startdate" class="form-control" placeholder="start-date" value="{{ $_GET['startdate'] ?? '' }}">
					  </div>
					  <div>
						<label>End Date</label>
						 <input type="date" name="enddate" class="form-control" placeholder="end-date" value="{{ $_GET['enddate'] ?? '' }}">
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
					  <div>
					  <input type="submit" class="btn btn-primary waves-effect waves-light mt-4" name="submit" value="Filter">
					  </div>
					</form>
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