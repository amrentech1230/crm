@extends('layout.compact.app')

@section('content')

<style>
    .dt-buttons.btn-group.flex-wrap {
        display: none;
    }

    div[id$="_filter"] {
        display: none;
    }

    .hide_blur_privacy {
        transition: 0.2s ease;
    }

    .hide_blur_privacy.blurred {
        filter: blur(6px);
    }

    .exlbtn {
        float: right;
        margin-bottom: 10px;
    }
    .status-dropdown {
    appearance: auto !important;
    -webkit-appearance: auto !important;
    -moz-appearance: auto !important;
}
.status-open {
    background-color: #ffdddd;
    color: #a30000;
    font-weight: 600;
}

.status-hold {
    background-color: #fff3cd;
    color: #856404;
    font-weight: 600;
}

.status-completed {
    background-color: #d4edda;
    color: #155724;
    font-weight: 600;
}
</style>
<!-- CENTER POPUP MODAL -->
<div class="modal fade" id="newTicketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">🔔 New Hardware Ticket</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <h5>A new hardware issue has been raised!</h5>
                <p class="mb-0">Please check the Open Issues tab.</p>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                    OK, Close
                </button>
            </div>

        </div>
    </div>
</div>


<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Hardware Issues Dashboard</h4>

                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">CCI</li>
                        <li class="breadcrumb-item active">Hardware</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Issue Management</h4>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified mb-3">

                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#open">Open Issues</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#hold">Hold Issues</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#completed">Completed Issues</a>
                    </li>
                </ul>

                <div class="tab-content">

                    <!-- OPEN -->
                    <div class="tab-pane fade show active" id="open">


                        <table class="table table-bordered table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Issue</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="customer-search">
                                @include('admin.it_hardware.it_hardware_open')
                            </tbody>
                        </table>
                    </div>

                    <!-- HOLD -->
                    <div class="tab-pane fade" id="hold">

       

                        <table class="table table-bordered table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Issue</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="carrier-search">
                                @include('admin.it_hardware.it_hardware_hold')
                            </tbody>
                        </table>
                    </div>

                    <!-- COMPLETED -->
                    <div class="tab-pane fade" id="completed">

      

                        <table class="table table-bordered table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Issue</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="consignee-search">
                                @include('admin.it_hardware.it_hardware_completed')
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Privacy blur toggle
    $(document).on('click', '.privacy_toggle', function () {
        $('table').toggleClass('blurred');
    });
</script>
<script>
$(document).ready(function () {

    // STATUS CHANGE
    $(document).on('change', '.status-dropdown', function () {

        let ticketId = $(this).data('ticket-id');
        let status = $(this).val();
        let remark = $('#remarks_' + ticketId).val();

        saveTicket(ticketId, status, remark);
    });

    // REMARK AUTOSAVE (after typing stop 800ms)
    let typingTimer;
    let doneTypingInterval = 800;

    $(document).on('keyup', 'textarea', function () {

        let ticketId = $(this).attr('id').split('_')[1];
        let remark = $(this).val();
        let status = $('.status-dropdown[data-ticket-id="'+ticketId+'"]').val();

        clearTimeout(typingTimer);

        typingTimer = setTimeout(function () {
            saveTicket(ticketId, status, remark);
        }, doneTypingInterval);
    });

    function saveTicket(ticketId, status, remark)
    {
        $.ajax({
            url: "{{ route('ticket.update.status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                ticket_id: ticketId,
                status: status,
                remark: remark
            },
            success: function () {
                console.log('Saved');
                location.reload(); // Reload to reflect changes in respective tabs
            },
            error: function () {
                console.log('Error saving');
            }
        });
    }

});
</script>
<script>
$(document).ready(function () {

    function applyColor(dropdown) {
        dropdown.removeClass('status-open status-hold status-completed');

        let value = dropdown.val();

        if (value === 'Open') {
            dropdown.addClass('status-open');
        } 
        else if (value === 'Hold') {
            dropdown.addClass('status-hold');
        } 
        else if (value === 'Completed') {
            dropdown.addClass('status-completed');
        }
    }

    // Apply color on page load
    $('.status-dropdown').each(function () {
        applyColor($(this));
    });

    // Apply color on change
    $('.status-dropdown').change(function () {
        applyColor($(this));
    });

});
</script>


<script>
$(document).ready(function () {

    let lastCount = null;

    function checkNewTickets() {
        $.ajax({
            url: "{{ route('ticket.count') }}",
            type: "GET",
            success: function (res) {

                if (lastCount === null) {
                    lastCount = res.count;
                    return;
                }

                if (res.count > lastCount) {

                    // SHOW CENTER MODAL
                    $('#newTicketModal').modal('show');

                    lastCount = res.count;
                }
            }
        });
    }

    // check every 5 sec
    setInterval(checkNewTickets, 5000);
});
</script>


