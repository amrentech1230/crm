<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\http\Controllers\LoadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use \App\Models\Customer;
use \App\Models\Load;
use App\Models\Shipper;
use App\Models\Consignee;
use App\Models\Country;
use App\Models\State;
use App\Models\CustomerApprovalForm;
use Carbon\Carbon;
use \App\Models\Manger;
use \App\Models\User;
use \App\Models\TeamLeader;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role_id = Auth::user()->role_id;

        $authId = auth()->id();
        $allIds = collect();
        
		if($role_id == 20){
			$teamLeader = TeamLeader::where('user_id', $authId)->first();
			// If user is a team leader
			if ($teamLeader) {
			 
				// Get users under this team leader
				$userIds = User::where('team_lead', $teamLeader->id)->pluck('id');
				$allIds = $allIds->merge($userIds);
			}
		}
		
		if($role_id == 19){
			$manager = Manger::where('user_id', $authId)->first();
			
			if ($manager) {
				// Get team leaders under this manager
				$teamLeaders = TeamLeader::where('leader_manager', $manager->id)->get();
				$teamLeaderIds = $teamLeaders->pluck('id');
				$allIds = $allIds->merge($teamLeaderIds);
				// Get users under these team leaders
				$userIds = User::whereIn('team_lead', $teamLeaderIds)->pluck('id');
				$allIds = $allIds->merge($userIds);
			}
		}

    // Make sure IDs are unique and return as array
    $userInfos = User::whereIn('id', $allIds)->where('status', 'Active')->pluck('name', 'id')->toArray();
        
        $role_ids = [1, 2 ,3];
        if(in_array($role_id, $role_ids)){
            $customers = Customer::with('user.teamLeaderInfo','user.managerInfo')->orderBy("id", "desc")->paginate(10);
            $allcountry = Country::get();
            
        }else{
            $customers = Customer::with('user.teamLeaderInfo','user.managerInfo')->where('user_id', Auth::id())->orderBy("id", "desc")->paginate(10);
            $allcountry = Country::get();
        }
		
		if ($request->ajax()) {
				return view('broker.partials.customer_table', compact('userInfos', 'allcountry','customers'))->render();
			}

if ($request->has('download') && $request->download === 'excel') {

    // Get customer IDs based on current role
    if (in_array($role_id, [1, 2, 3])) {
        $customerIds = Customer::pluck('id');
    } else {
        $customerIds = Customer::where('user_id', Auth::id())->pluck('id');
    }

    $agedLoads = Load::whereIn('customer_id', $customerIds)
        ->where('invoice_status', 'Paid')
        ->orderBy('invoice_date', 'asc')
        ->get();

    $filename = "customer_aging_report_" . now()->format('Ymd_His') . ".xls";

    $content = '';

    $fields = [
        'Load ID',
        'Customer Name',
        'Load Status',
        'Invoice Number',
        'Invoice Date',
        'Agent Name',
        'Shipper Final Payment',
        'Aging Days'
    ];

    $content .= implode("\t", $fields) . "\n";

    foreach ($agedLoads as $load) {

           $agingDays = $load->invoice_date
        ? round(
            \Carbon\Carbon::parse($load->invoice_date)
                ->subDay()
                ->diffInDays(today())
          )
        : '';

        $row = [
            $load->load_number,
            $load->load_bill_to,
            'Invoice',
            $load->invoice_number,
            $load->invoice_date,
            $load->load_dispatcher,
            $load->shipper_load_final_rate,
            $agingDays,
        ];

        $content .= implode("\t", $row) . "\n";
    }

    return response($content)
        ->header('Content-Type', 'application/vnd.ms-excel')
        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
}
        
        return view('broker.customer', compact('userInfos', 'allcountry','customers'));
    }
	
	public function customer_search(Request $request){
		
		$role_id = Auth::user()->role_id;
        
		$role_ids = [1, 2 ,3];
			
		$q = $request->input('query');
        if (!empty($q)) {
            // Split the query by commas to get multiple terms
            $searchTerms = array_filter(explode(',', $q), function($term) {
                return !empty(trim($term)); // Only keep non-empty terms
            });

            if (count($searchTerms) > 0) {
				
				if(in_array($role_id, $role_ids)){
				// Search for non-empty terms with 'orWhere'
                $customers = Customer::with('user.teamLeaderInfo','user.managerInfo')
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhere('customer_name', 'like', "%$term%");
                        }
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(10);
				
				}else{
					// Search for non-empty terms with 'orWhere'
                $customers = Customer::with('user.teamLeaderInfo','user.managerInfo')->where('user_id', Auth::id())
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhere('customer_name', 'like', "%$term%");
                        }
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(10);
				}
                
					$allcountry = Country::get();
            } else {
                // If no valid terms, return an empty collection or handle accordingly
                $broker_status = collect();
				$allcountry = Country::get();
            }
        } else {
           
			if(in_array($role_id, $role_ids)){
				$customers = Customer::with('user.teamLeaderInfo','user.managerInfo')->orderBy("id", "desc")->paginate(10);
				$allcountry = Country::get();
				
			}else{
				$customers = Customer::with('user.teamLeaderInfo','user.managerInfo')->where('user_id', Auth::id())->orderBy("id", "desc")->paginate(10);
				$allcountry = Country::get();
			}
        }
        
		
		return view('broker.partials.customer_table', compact('allcountry','customers'))->render();
			
	}
	
	public function customer_search_user(Request $request){
		
		$user_id = $request->input('user_id');
       
		$customers = Customer::with('user.teamLeaderInfo','user.managerInfo')->where('user_id', $user_id)
			->orderBy('id', 'desc')
			->paginate(50);
		
		$allcountry = Country::get();
            
		return view('broker.partials.customer_table', compact('allcountry','customers'))->render();
			
	}

    public function liveCustomerData()
    {
        $customers = Customer::where('user_id', Auth::id())
            ->orderBy("id", "desc")
            ->take(100)
            ->paginate(1);
    
        $html = view('broker.partials.customer_table', compact('customers'))->render();
    
        return response()->json(['html' => $html]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $user = Auth::user(); // Properly get authenticated user
    
        $yourModel = new Customer(); // Class name should be capitalized
        $yourModel->user_id = Auth::user()->id;
        $yourModel->customer_name = $request->input('customer_name') ?? ''; 
        $yourModel->customer_name = $request->input('customer_name') ?? ''; 
        $yourModel->customer_mc_ff = $request->input('customer_mc_ff') ?? '';
        $yourModel->customer_mc_ff_input = $request->input('customer_mc_ff_input') ?? '';
        $yourModel->customer_address = $request->input('customer_address') ?? '';
        $yourModel->customer_country = $request->input('customer_country') ?? '';
        $yourModel->customer_state = $request->input('customer_state') ?? '';
        $yourModel->customer_city = $request->input('customer_city') ?? '';
        $yourModel->customer_zip = $request->input('customer_zip') ?? '';
        $yourModel->customer_billing_address = $request->input('customer_billing_address') ?? '';
        $yourModel->customer_billing_country = $request->input('customer_billing_country') ?? '';
        $yourModel->customer_billing_state = $request->input('customer_billing_state') ?? '';
        $yourModel->customer_billing_city = $request->input('customer_billing_city') ?? '';
        $yourModel->customer_billing_zip = $request->input('customer_billing_zip') ?? '';
        $yourModel->customer_primary_contact = $request->input('customer_primary_contact') ?? '';
        $yourModel->customer_telephone = $request->input('customer_telephone') ?? '';
        $yourModel->customer_extn = $request->input('customer_extn') ?? '';
        $yourModel->customer_email = $request->input('customer_email') ?? '';
        $yourModel->customer_tollfree = $request->input('customer_tollfree') ?? '';
        $yourModel->customer_fax = $request->input('customer_fax') ?? '';
        $yourModel->customer_secondary_contact = $request->input('customer_secondary_contact') ?? '';
        $yourModel->customer_secondary_email = $request->input('customer_secondary_email') ?? '';
        $yourModel->customer_billing_email = $request->input('customer_billing_email') ?? '';
        $yourModel->customer_billing_telephone =  $request->input('customer_billing_telephone') ?? '';
        $yourModel->customer_billing_extn =  $request->input('customer_billing_extn') ?? '';
        $yourModel->adv_customer_currency_Setting =  $request->input('adv_customer_currency_Setting') ?? '';
        // $yourModel->adv_customer_credit_limit =  $request->input('adv_customer_credit_limit') ?? '0';
        $yourModel->remaining_credit =  $request->input('remaining_credit') ?? '0';
        $yourModel->adv_customer_payment_terms = $request->input('adv_customer_payment_terms') ?? '';
        $yourModel->adv_customer_factoring_company =  $request->input('adv_customer_factoring_company') ?? '';
        $yourModel->adv_customer_webiste_url =  $request->input('adv_customer_webiste_url') ?? '';
        $yourModel->adv_customer_duplicate =  $request->input('adv_customer_duplicate') ?? '';
        $yourModel->adv_customer_duplicate_two =  $request->input('adv_customer_duplicate_two') ?? '';
        $yourModel->adv_customer_internal_notes =  $request->input('adv_customer_internal_notes') ?? '';
        $yourModel->adv_customer_payment_terms_custome =  $request->input('adv_customer_payment_terms_custome') ?? '';
        $yourModel->customer_blacklisted =  $request->input('customer_blacklisted') ?? '';
        $yourModel->customer_status = $request->input('customer_status') ?? '';
        $yourModel->customer_corporation = $request->input('customer_corporation') ?? '';
        $yourModel->status = 'Not Approved' ;
        $yourModel->commenter_name = '';
        $remainingCredit = $request->input('remaining_credit');
        $remainingCredit = is_numeric($remainingCredit) ? (float) $remainingCredit : 0.0;
        $yourModel->status = 'Not Approved';
        $yourModel->commenter_name = '';
        
        if ($request->hasFile('customer_file_uploads')) {
            $files = [];

            foreach ($request->file('customer_file_uploads') as $file) {
                if ($file->isValid()) {
                   $filename = time() . '_' . $file->getClientOriginalName();
                    $destinationPath = public_path('uploads/customers/' . $yourModel->customer_name);
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0775, true);
                    }

                    $file->move($destinationPath, $filename);
                    $files[] = 'uploads/customers/' . $yourModel->customer_name.'/' . $filename;
                }
            }

            $yourModel->customer_file_upload = json_encode($files); // Save as JSON
            
        }else{
            $yourModel->customer_file_upload = ''; 
        }

        
    
        if ($request->AddAsConsignee) {
            Consignee::create([
                'user_id' => Auth::user()->id,
                'consignee_name' => $request->input('customer_name') ?? '',
                'consignee_address' => $request->input('customer_address') ?? '',
                'consignee_country' => $request->input('customer_country') ?? '',
                'consignee_state' => $request->input('customer_state') ?? '',
                'consignee_city' => $request->input('customer_city') ?? '',
                'consignee_zip' => $request->input('customer_zip') ?? '',
                'consignee_contact_name' => $request->input('customer_primary_contact') ?? '',
                'consignee_contact_email' => $request->input('customer_email') ?? '',
                'consignee_telephone' => $request->input('customer_telephone') ?? '',
                'consignee_ext' => $request->input('customer_extn') ?? '',
                'consignee_toll_free' => 'NA',
                'consignee_fax' => $request->input('customer_fax') ?? '',
                'consignee_hours' => now(),
                'consignee_appointments' => '',
                'consignee_major_intersections' => 'NA',
                'consignee_status' => $request->input('customer_status') ?? '',
                'consignee_shipping_notes' => 'NA',
                'consignee_internal_notes' => $request->input('adv_customer_internal_notes') ?? '',
            ]);
        }
    
        if ($request->AddAsShipper) {
            Shipper::create([
                'user_id' => Auth::user()->id,
                'shipper_name' => $request->input('customer_name') ?? '',
                'shipper_address' => $request->input('customer_address') ?? '',
                'shipper_country' => $request->input('customer_country') ?? '',
                'shipper_state' => $request->input('customer_state') ?? '',
                'shipper_city' => $request->input('customer_city') ?? '',
                'shipper_zip' => $request->input('customer_zip') ?? '',
                'shipper_contact_name' => $request->input('customer_primary_contact') ?? '',
                'shipper_contact_email' => $request->input('customer_email') ?? '',
                'shipper_telephone' => $request->input('customer_telephone') ?? '',
                'shipper_extn' => $request->input('customer_extn') ?? '',
                'shipper_toll_free' => 'NA',
                'shipper_fax' => $request->input('customer_fax') ?? '',
                'shipper_hours' => 'NA',
                'shipper_appointments' => 'NA',
                'shipper_major_intersections' => 'NA',
                'shipper_status' => $request->input('customer_status') ?? '',
                'shipper_shipping_notes' => 'NA',
                'shipper_internal_notes' => $request->input('shipper_shipping_notes') ?? '',
                'commenter_name' => 'NA',
            ]);
        }
        
        $yourModel->save();

        $subject = "Broker Craete the Customer, Customerid:-".$yourModel->id;;
        addToLog($customerId ='', $id='', $subject, $oldData ='', $newData ='');
    
        return redirect()->back()->with('success', 'Data has been saved!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::with('user.teamLeaderInfo','user.managerInfo')->where('id', $id)->first();
        $allcountry = Country::get();
		$state = State::get();
        return view('broker.customer-edit', compact('state','allcountry','customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
		
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
        ]);
	

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $yourModel = Customer::findOrFail($id);

        $oldData = json_encode($yourModel);

        $yourModel->customer_name = $request->input('customer_name') ?? ''; 
        $yourModel->customer_mc_ff = $request->input('customer_mc_ff') ?? '';
        $yourModel->customer_mc_ff_input = $request->input('customer_mc_ff_input') ?? '';
        $yourModel->customer_address = $request->input('customer_address') ?? '';
        $yourModel->customer_country = $request->input('customer_country') ?? '';
        $yourModel->customer_state = $request->input('customer_state') ?? '';
        $yourModel->customer_city = $request->input('customer_city') ?? '';
        $yourModel->customer_zip = $request->input('customer_zip') ?? '';
        $yourModel->customer_billing_address = $request->input('customer_billing_address') ?? '';
        $yourModel->customer_billing_country = $request->input('customer_billing_country') ?? '';
        $yourModel->customer_billing_state = $request->input('customer_billing_state') ?? '';
        $yourModel->customer_billing_city = $request->input('customer_billing_city') ?? '';
        $yourModel->customer_billing_zip = $request->input('customer_billing_zip') ?? '';
        $yourModel->customer_primary_contact = $request->input('customer_primary_contact') ?? '';
        $yourModel->customer_telephone = $request->input('customer_telephone') ?? '';
        $yourModel->customer_extn = $request->input('customer_extn') ?? '';
        $yourModel->customer_email = $request->input('customer_email') ?? '';
        $yourModel->customer_tollfree = $request->input('customer_tollfree') ?? '';
        $yourModel->customer_fax = $request->input('customer_fax') ?? '';
        $yourModel->customer_secondary_contact = $request->input('customer_secondary_contact') ?? '';
        $yourModel->customer_secondary_email = $request->input('customer_secondary_email') ?? '';
        $yourModel->customer_billing_email = $request->input('customer_billing_email') ?? '';
        $yourModel->customer_billing_telephone = $request->input('customer_billing_telephone') ?? '';
        $yourModel->customer_billing_extn = $request->input('customer_billing_extn') ?? '';
        $yourModel->adv_customer_currency_Setting = $request->input('adv_customer_currency_Setting') ?? '';
        $yourModel->remaining_credit = is_numeric($request->input('remaining_credit')) ? $request->input('remaining_credit') : 0;
        $yourModel->adv_customer_payment_terms = $request->input('adv_customer_payment_terms') ?? '';
        $yourModel->adv_customer_factoring_company = $request->input('adv_customer_factoring_company') ?? '';
        $yourModel->adv_customer_webiste_url = $request->input('adv_customer_webiste_url') ?? '';
        $yourModel->adv_customer_duplicate = $request->input('adv_customer_duplicate') ?? '';
        $yourModel->adv_customer_duplicate_two = $request->input('adv_customer_duplicate_two') ?? '';
        $yourModel->adv_customer_internal_notes = $request->input('adv_customer_internal_notes') ?? '';
        $yourModel->adv_customer_payment_terms_custome = $request->input('adv_customer_payment_terms_custome') ?? '';
        $yourModel->customer_blacklisted = $request->input('customer_blacklisted') ?? '';
        $yourModel->customer_status = $request->input('customer_status') ?? '';
        $yourModel->customer_corporation = $request->input('customer_corporation') ?? '';
        // $yourModel->status = 'Not Approved';
        $yourModel->commenter_name = '';

        // Handle file uploads (replace old files if needed)
      
        if ($request->hasFile('customer_file_uploads')) {
            $files = [];

            foreach ($request->file('customer_file_uploads') as $file) {
                if ($file->isValid()) {
                   $filename = time() . '_' . $file->getClientOriginalName();
                    $destinationPath = public_path('uploads/customers/' . $yourModel->customer_name);
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0775, true);
                    }

                    $file->move($destinationPath, $filename);
                    $files[] = 'uploads/customers/' . $yourModel->customer_name.'/' . $filename;
                }
            }

            $yourModel->customer_file_upload = json_encode($files); // Save as JSON
            
        }

        $yourModel->save();

         $newData = json_encode($yourModel);

        $subject = "Broker update the Customer, customerid:-".$id;
        addToLog($customerId ='', $loadId ='', $subject, $oldData, $newData);

        return redirect()->back()->with('success', 'Customer data updated successfully!');
    }

    public function getStates($country_id)
    {
        $states = State::where('country_id', $country_id)->get();

        $html = '<option value="">Choose State</option>';
        foreach($states as $state){
            $html .= '<option value="'.$state->id.'">'.$state->name.'</option>';
        }
        return response()->json($html);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
	
	
public function uploadRemittance(Request $request)
{
    $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'remittance.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10240',
        'note' => 'nullable|string',
    ]);

    $customer = Customer::findOrFail($request->customer_id);
    $existingFiles = json_decode($customer->remittance, true);
    $existingFiles = is_array($existingFiles) ? $existingFiles : [];

    $timezone = 'America/New_York';
    $timestamp = Carbon::now($timezone)->format('Y-m-d H:i:s');
    $allFiles = [];
    $uploadedFilePaths = [];

    if ($request->hasFile('remittance')) {
        foreach ($request->file('remittance') as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = 'uploads/remittances/' . $filename;
            $file->move(public_path('uploads/remittances'), $filename);

            $uploadedFilePaths[] = public_path($filePath);

            $allFiles[] = [
                'path' => $filePath,
                'uploaded_at' => $timestamp,
                'note' => $request->note ?? '',
            ];
        }

        $mergedFiles = array_merge($existingFiles, $allFiles);
        $customer->remittance = json_encode($mergedFiles);
        $customer->save();

        // Email details
        $to = 'ar@cargoconvoy.co';
        $cc = 'credit@cargoconvoy.co';
        $from = auth()->user()->email ?? 'no-reply@cargoconvoy.co';
        $subject = 'Remittance for ' . $customer->customer_name;

        $bodyMessage = "Hi,\n\n"
            . "New remittance uploaded for customer: " . $customer->customer_name
            . " on " . $timestamp . ".\n\n";

        if (!empty($request->note)) {
            $bodyMessage .= "Note: " . $request->note . "\n\n";
        }

        $bodyMessage .= "Regards,\nCargo Convoy";

        // ✅ Use Mail::raw() instead of setBody()
        Mail::raw($bodyMessage, function ($message) use ($to, $cc, $from, $subject, $uploadedFilePaths) {
            $message->to($to)
                ->cc($cc)
                ->from($from)
                ->subject($subject);

            // Attach uploaded files
            foreach ($uploadedFilePaths as $filePath) {
                $message->attach($filePath);
            }
        });

        addToLog('Remittance uploaded for Customer: ' . $customer->customer_name . ' by User: ' . (auth()->user()->name ?? 'System'));
    }

    return response()->json([
        'status' => 'success',
        'files' => $mergedFiles ?? $existingFiles,
    ]);
}

    public function filterRemittanceFiles(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id'
        ]);

        $customer = Customer::findOrFail($request->customer_id);
        $allFiles = json_decode($customer->remittance ?? '[]', true);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $filteredFiles = array_filter($allFiles, function ($file) use ($startDate, $endDate) {
            if (!isset($file['uploaded_at'])) return false;

            $fileTime = Carbon::parse($file['uploaded_at']);

            if ($startDate && $fileTime->lt(Carbon::parse($startDate)->startOfDay())) {
                return false;
            }

            if ($endDate && $fileTime->gt(Carbon::parse($endDate)->endOfDay())) {
                return false;
            }

            return true;
        });

        // Sort by date
        usort($filteredFiles, function ($a, $b) {
            return Carbon::parse($b['uploaded_at'])->timestamp <=> Carbon::parse($a['uploaded_at'])->timestamp;
        });

        // ✅ Ensure each file has a `note`
        foreach ($filteredFiles as &$file) {
            if (!isset($file['note'])) {
                $file['note'] = '';
            }
        }

        return response()->json([
            'files' => array_values($filteredFiles) // reindex
        ]);
    }


	public function remittanceFiles(Request $request)
	{
		$request->validate([
			'customer_id' => 'required|exists:customers,id'
		]);

		$customer = Customer::findOrFail($request->customer_id);
		$files = json_decode($customer->remittance ?? '[]', true);
		return response()->json(['files' => $files]);
	}

	public function deleteRemittanceFile(Request $request)
	{
		$request->validate([
			'customer_id' => 'required|exists:customers,id',
			'file' => 'required|string'
		]);

		$customer = Customer::findOrFail($request->customer_id);
		$files = json_decode($customer->remittance ?? '[]', true);

		if (($key = array_search($request->file, $files)) !== false) {
			// Remove from array
			unset($files[$key]);
			$customer->remittance = json_encode(array_values($files));
			$customer->save();

			// Delete file from disk
			$filePath = public_path('public/' . $request->file);
			if (File::exists($filePath)) {
				File::delete($filePath);
			}
		}
		//LogActivity::addToLog('Remittance file deleted for Customer: ' . $customer->customer_name.'By User: '.session('user')->name); 
		// Return success response
		return response()->json(['status' => 'success', 'message' => 'File deleted.']);
	}
    public function customerApprovalFormBroker()
    {
        $customerApprovalFormBroker = CustomerApprovalForm::where('agent_email',Auth::user()->email)->paginate(50);
        
        return view('broker.customerapprovalformbroker',compact('customerApprovalFormBroker'));
    }

private function appendToGoogleSheet($data)
{
    $url = "https://script.google.com/macros/s/AKfycbzjK0fiMeIYxg8F7B4mK92KVRlCL-UyWIpM1kFqa8ImZ0-QL2I462-ogVmZNaqEt5iWSA/exec";

    $response = \Illuminate\Support\Facades\Http::post($url, $data);

    return $response->body();
}






public function storeCustomerApprovalForm(Request $request)
{
    $customerApprovalFormBroker = CustomerApprovalForm::create([
        'agent_name'             => $request->agent_name,
        'agent_email'            => auth()->user()->email,
        'customer_email'         => $request->customer_email,
        'company_name'           => $request->company_name,
        'address'                => $request->address,
        'country'                => $request->country,
        'state'                  => $request->state,
        'city'                   => $request->city,
        'zip_code'               => $request->zip_code,
        'dispatcher_first_name'  => $request->dispatcher_first_name,
        'dispatcher_last_name'   => $request->dispatcher_last_name,
        'phone_number'           => $request->phone_number,
        'requested_credit_limit' => $request->requested_credit_limit,
    ]);

    // Send to Google Sheet
    $this->appendToGoogleSheet([
        "date" => now()->format('m-d-Y H:i:s'),
        "company_name" => $request->company_name,
        "address" => $request->address,
        "city" => $request->city,
        "state" => $request->state,
        "zip_code" => $request->zip_code,
        "contact_name" => $request->dispatcher_first_name . ' ' . $request->dispatcher_last_name,
        "phone" => $request->phone_number,
        "email" => $request->customer_email,
        "credit_limit" => $request->requested_credit_limit,
        "agent_email" => auth()->user()->email
    ]);

    return redirect()->back()->with('success', 'Customer Approval Form submitted + synced to Google Sheet!');
}



}  
