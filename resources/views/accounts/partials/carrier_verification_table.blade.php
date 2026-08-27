@foreach($loads as $load)


<tr>
    <td style="display:none;">
        <input type="hidden" name="load_id" class="load_id" value="{{ $load->id }}">
    </td>

    <td>
        <b>{{  $load->load_number }}</b>
    </td>
    <td>
        <b>{{  $load->load_bill_to }}</b>
    </td>
    <td>
        <b>{{  $load->load_carrier }}</b>
    </td>
    <td>
        <b>{{  $load->load_dispatcher }}</b>
    </td>
    @php

    $bankInfo = optional($load->carrierVerification)->bank_information ?? '';
    @endphp

    <td>
        <select name="bank_information" class="form-control bank_information">
            <option value="">Please Select</option>
            <option value="Void Cheque" {{ $bankInfo === 'Void Cheque' ? 'selected' : '' }}>Void Cheque
            </option>
            <option value="Physical Cheque" {{ $bankInfo === 'Physical Cheque' ? 'selected' : '' }}>Physical
                Cheque</option>
            <option value="LOR" {{ $bankInfo === 'LOR' ? 'selected' : '' }}>LOR
            </option>
            <option value="NOA" {{ $bankInfo === 'NOA' ? 'selected' : '' }}>NOA
            </option>
        </select>
    </td>
@php
    $factoring = optional($load->carrierVerification)->factoring ?? '';
    $factorings = \App\Models\Factoring::orderBy('factoring_name','asc')->get();
@endphp

<td>
<select name="factoring" class="form-control factoring select2">
    <option value="">Select Factoring</option>

    @foreach($factorings as $item)
        <option value="{{ $item->factoring_name }}"
            {{ $factoring == $item->factoring_name ? 'selected' : '' }}>
            {{ $item->factoring_name }}
        </option>
    @endforeach
</select>

</td>





    <td>
        @php
        $status = optional($load->carrierVerification)->verification_factoring
        ??
        '';
        @endphp

        <select name="verification_factoring" class="form-control verification_factoring">
            <option value="">Please Select Status</option>
            <option value="Verified" {{ $status == 'Verified' ? 'selected' : '' }} style="background-color:green">Verified</option>
            <option value="Not Verified" {{ $status == 'Not Verified' ? 'selected' : '' }} style="background-color:red">Not Verified</option>
            <option value="Pending" {{ $status == 'Pending' ? 'selected' : '' }} style="background-color:yellow">Pending</option>
        </select>
    </td>

    <td>
        <div class="phone-container">
            <div class="phone-row mb-2">
                <input type="text" name="verification_carrier_phone_number" class="form-control phone-input"
                    placeholder="Enter phone number"
                    value="{{ $load->carrierVerification->verification_carrier_phone_number ?? '' }}">
            </div>
        </div>
    </td>


    <td>
        <div class="email-container">
            <div class="email-row mb-2">
                <input type="email" name="verification_carrier_email" class="form-control email-input"
                    placeholder="Enter email address"
                    value="{{ $load->carrierVerification->verification_carrier_email ?? '' }}">
            </div>
        </div>

    </td>

    <td>
        <textarea name="verification_remark" class="form-control"
            id="follow_up_note">{{ optional($load->carrierVerification)->verification_remark }}</textarea>
    </td>

    <td>
        <div class="phone-container">
            <div class="phone-row mb-2">

                <input type="file" name="carrier_bank_docs[]" multiple class="form-control">

            </div>
        </div>
    </td>

    @if(optional($load->carrierVerification)->carrier_bank_docs)
    <td class="text-center">
        <i class="fas fa-eye text-primary view-files" style="cursor:pointer" data-load-id="{{ $load->id }}">
        </i>
    </td>
    @else
    <td><span style="color:red">No file uploaded yet</span></td>
    @endif




    <td>
        @php
        $followupnote = optional($load->carrierVerification)->follow_up_note ?? '';
        @endphp

        <select name="follow_up_note" class="form-control follow_up_note">
            <option value="">Please Select</option>

            @for($i = 1; $i <= 10; $i++) <option value="{{ $i }}" {{ $followupnote == (string)$i ? 'selected' : '' }}>
                {{ $i }} Time{{ $i > 1 ? 's' : '' }}
                </option>
                @endfor

                <option value="More than 10 time" {{ $followupnote == 'More than 10 time' ? 'selected' : '' }}>
                    More than 10 times
                </option>
        </select>
    </td>
    <td class="dynamic-data"><a href="{{ route('accounts.view_loads_detail', $load->id) }}"
            class="btn btn-primary btn-sm"> <i class="fas fa-eye"></i></a></td>



</tr>
@endforeach
<div class="modal fade" id="fileViewerModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Carrier Verification Files</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="fileViewerBody"></div>

        </div>
    </div>
</div>




<script>
    /* =========================
   Save Carrier Verification
========================= */
    function saveCarrierVerification(row) {

        let formData = new FormData();

        formData.append('_token', "{{ csrf_token() }}");
        formData.append('load_id', row.find("input[name='load_id']").val());
        formData.append('bank_information', row.find("select[name='bank_information']").val());
        formData.append('factoring', row.find("select[name='factoring']").val());
        formData.append('verification_factoring', row.find("select[name='verification_factoring']").val());
        formData.append('verification_carrier_email', row.find("input[name='verification_carrier_email']").val());
        formData.append('phone_number', row.find(".phone-input").first().val());
        formData.append('email', row.find(".email-input").first().val());
        formData.append('verification_remark', row.find("textarea[name='verification_remark']").val());
        formData.append('follow_up_note', row.find("select[name='follow_up_note']").val());

        // ✅ Append files properly
        let fileInput = row.find("input[name='carrier_bank_docs[]']")[0];
        if (fileInput && fileInput.files.length > 0) {
            $.each(fileInput.files, function (i, file) {
                formData.append('carrier_bank_docs[]', file);
            });
        }

        $.ajax({
            url: "{{ route('carrier.verification.save') }}",
            type: "POST",
            data: formData,
            processData: false, // REQUIRED
            contentType: false, // REQUIRED
            success: function () {
                $("#mc-success-message")
                    .text("Saved Successfully!")
                    .stop(true, true)
                    .show()
                    .delay(2000)
                    .fadeOut();
            },
            error: function (xhr) {
                $("#mc-error-message")
                    .text("Error saving data!")
                    .stop(true, true)
                    .show()
                    .delay(2000)
                    .fadeOut();

                console.error(xhr.responseText);
            }
        });
    }

    /* =========================
       Trigger on Change / Keyup
    ========================= */
    $(document).on(
        "change keyup",
        "#carrier_verification_table select, #carrier_verification_table input:not([type='file']), #carrier_verification_table textarea",
        function () {
            let row = $(this).closest("tr");
            saveCarrierVerification(row);
        }
    );

    // Separate trigger for file upload
    $(document).on(
        "change",
        "#carrier_verification_table input[type='file']",
        function () {
            let row = $(this).closest("tr");
            saveCarrierVerification(row);
        }
    );
</script>
<script>
    $(document).on('click', '.view-files', function () {

        let loadId = $(this).data('load-id');

        $('#fileViewerBody').html('<div class="text-center p-3">Loading...</div>');
        $('#fileViewerModal').modal('show');

        $.ajax({
            url: "{{ route('carrier.verification.files') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                load_id: loadId
            },
            success: function (response) {

                if (!response.files || response.files.length === 0) {
                    $('#fileViewerBody').html('<p class="text-center">No files found</p>');
                    return;
                }

                let html = `<div class="accordion" id="filesAccordion">`;

                response.files.forEach(function (file, index) {
                    let fileName = file.split('/').pop();
                    let ext = fileName.split('.').pop().toLowerCase();
                    let collapseId = `collapseFile${index}`;

                    let fileContent = '';

                    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                        fileContent =
                            `<img src="${file}" class="img-fluid rounded border mb-3">`;
                    } else if (ext === 'pdf') {
                        fileContent =
                            `<embed src="${file}" type="application/pdf" width="100%" height="450" class="mb-3">`;
                    } else {
                        fileContent =
                            `<p><a href="${file}" target="_blank">${fileName}</a></p>`;
                    }

                    html += `
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading${index}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
                                ${fileName}
                            </button>
                        </h2>
                        <div id="${collapseId}" class="accordion-collapse collapse" aria-labelledby="heading${index}" data-bs-parent="#filesAccordion">
                            <div class="accordion-body">
                                ${fileContent}
                            </div>
                        </div>
                    </div>
                `;
                });

                html += `</div>`; // close accordion
                $('#fileViewerBody').html(html);
            },
            error: function () {
                $('#fileViewerBody').html('<p class="text-danger">Failed to load files</p>');
            }
        });
    });
</script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Select Factoring",
        allowClear: true,
        width: '100%'
    });
});
</script>
