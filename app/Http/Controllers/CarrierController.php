<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use \App\Models\External;
use App\Models\Country;
use App\Models\State;
use \App\Models\Manger;
use \App\Models\TeamLeader;
use App\Models\User;

class CarrierController extends Controller
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
            $carriers = External::with('user.teamLeaderInfo','user.managerInfo')
            ->orderBy("id", "desc")
            ->paginate(50);

            $allcarriers = External::with('user.teamLeaderInfo','user.managerInfo')
            ->orderBy("id", "desc")
            ->paginate(50);
            $allcountry = Country::get();
			$state = State::get();
            $users = User::with('role', 'department', 'managers', 'teamleader', 'office')->where('department', 3)->get();
        }else{
            // $carriers = External::where('user_id', Auth::id())->orderBy("id", "desc")->paginate(2);
            $carriers = External::with('user.teamLeaderInfo','user.managerInfo')
            ->where('user_id', Auth::id())
            ->orderBy("id", "desc")
            ->paginate(50);

            $allcarriers = External::with('user.teamLeaderInfo','user.managerInfo')
            ->orderBy("id", "desc")
            ->paginate(50);
            $allcountry = Country::get();
			$state = State::get();
            $users = User::with('role', 'department', 'managers', 'teamleader', 'office')->where('department', 3)->get();
        }
		if ($request->ajax()) {
			
			if($request->input('tab') == '#my-carrier'){
				return view('broker.partials.carrier_table', compact('userInfos', 'allcountry','state','carriers', 'allcarriers', 'users'))->render();
			}else{
				return view('broker.partials.all_carrier_table', compact('userInfos','allcountry','state','carriers', 'allcarriers', 'users'))->render();
			}
				
			}
       
       
        return view('broker.carrier',compact('userInfos', 'allcountry','state','carriers', 'allcarriers', 'users'));
    }

     public function mycarriersearch(Request $request)
    {
        $q = $request->input('query');
        if (!empty($q)) {
            // Split the query by commas to get multiple terms
            $searchTerms = array_filter(explode(',', $q), function($term) {
                return !empty(trim($term)); // Only keep non-empty terms
            });

            if (count($searchTerms) > 0) {
                // Search for non-empty terms with 'orWhere'
                $carriers = External::with('user.teamLeaderInfo','user.managerInfo')
                ->where('user_id', Auth::id())
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhere('carrier_mc_ff_input', 'like', "%$term%");
                            $query->orWhere('carrier_dot', 'like', "%$term%");
                            $query->orwhere('carrier_name', 'like', "%$term%");
                        }
                    })
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                // If no valid terms, return an empty collection or handle accordingly
                $carriers = collect();
            }
        } else {
            // If query is empty, return a paginated result without any filter
            $carriers = External::with('user.teamLeaderInfo','user.managerInfo')
                ->where('user_id', Auth::id())
                ->orderBy("id", "desc")
                ->paginate(10);
        }

        $allcountry = Country::get();
        
        return view('broker.partials.carrier_table', compact('carriers', 'allcountry'))->render();
    }
	
	public function carrier_search_user(Request $request)
    {
        $user_id = $request->input('user_id');
       
                // Search for non-empty terms with 'orWhere'
                $carriers = External::with('user.teamLeaderInfo','user.managerInfo')
                ->where('user_id', $user_id)
                    ->orderBy('id', 'desc')
                    ->get();
            
        $allcountry = Country::get();
        
		if ($request->ajax()) {
			
			if($request->input('activeTab') == '#my-carrier'){
				return view('broker.partials.carrier_table', compact('carriers', 'allcountry'))->render();
			}
				 
		}
        
    }
 
     public function allcarriersearch(Request $request)
    {
         $q = $request->input('query');
        if (!empty($q)) {
            // Split the query by commas to get multiple terms
            $searchTerms = array_filter(explode(',', $q), function($term) {
                return !empty(trim($term)); // Only keep non-empty terms
            });

            if (count($searchTerms) > 0) {
                // Search for non-empty terms with 'orWhere'
                $allcarriers = External::with('user.teamLeaderInfo','user.managerInfo')
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhere('carrier_mc_ff_input', 'like', "%$term%");
                            $query->orWhere('carrier_dot', 'like', "%$term%");
                            $query->orwhere('carrier_name', 'like', "%$term%");
                        }
                    })
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                // If no valid terms, return an empty collection or handle accordingly
                $allcarriers = collect();
            }
        } else {
            // If query is empty, return a paginated result without any filter
            $allcarriers = External::with('user.teamLeaderInfo','user.managerInfo')
                ->orderBy("id", "desc")
                ->paginate(10);
        }

        $allcountry = Country::get();
        
        return view('broker.partials.all_carrier_table', compact('allcarriers', 'allcountry'))->render();   
    }

    public function liveCustomerData()
    {
        $carriersData = External::where('user_id', Auth::id())
            ->orderBy("id", "desc")
            ->take(100)
            ->paginate(1);
    
        $html = view('broker.partials.carrier_table', compact('carriersData'))->render();
    
        return response()->json(['html' => $html]);
    }

    public function getStatescarrier($country_id)
    {
        $states = State::where('country_id', $country_id)->get();

        $html = '<option value="">Choose State</option>';
        foreach($states as $state){
            $html .= '<option value="'.$state->name.'">'.$state->name.'</option>';
        }
        return response()->json($html);
    }

    /**
     * Show the form for creating a new resource.
     */
public function create(Request $request)
{
    // === Validation ===
    $validator = Validator::make($request->all(), [
        'carrier_name' => 'required|string|max:255',
        'carrier_mc_ff' => 'required|string',
        'carrier_mc_ff_input' => 'required|string|unique:externals,carrier_mc_ff_input',
    ],[
        'carrier_mc_ff_input.unique' => 'This MC number already exists in our database.',
    ]);

   if ($validator->fails()) {
        return redirect()->back()
            ->with('popup_error', $validator->errors()->first())
            ->withInput();
    }

    // === Manual Safety Check (Optional but Recommended) ===
    if (External::where('carrier_mc_ff_input', $request->carrier_mc_ff_input)->exists()) {
        return redirect()->back()
            ->withErrors(['carrier_mc_ff_input' => 'This MC number already exists in our database.'])
            ->withInput();
    }

    if (!empty($request->carrier_dot) && External::where('carrier_dot', $request->carrier_dot)->exists()) {
        return redirect()->back()
            ->withErrors(['carrier_dot' => 'This DOT number already exists in our database.'])
            ->withInput();
    }

    // === Save New Carrier ===
    $external = new External();
    $external->user_id = $request->user_id ?? Auth::user()->id;
    $external->dispatcher_name = $request->dispatcher_name ?? Auth::user()->name;
    $external->carrier_name = $request->carrier_name;
    $external->carrier_mc_ff = $request->carrier_mc_ff;
    $external->carrier_mc_ff_input = $request->carrier_mc_ff_input;
    $external->carrier_dot = $request->carrier_dot;

    $external->carrier_address_two = $request->carrier_address_two;
    $external->carrier_country = $request->carrier_country;
    $external->carrier_state = $request->carrier_state;
    $external->carrier_city = $request->carrier_city;
    $external->carrier_zip = $request->carrier_zip;
    $external->carrier_contact_name = $request->carrier_contact_name;
    $external->carrier_email = $request->carrier_email;
    $external->carrier_telephone = $request->carrier_telephone;
    $external->carrier_extn = $request->carrier_extn;
    $external->carrier_fax = $request->carrier_fax;
    $external->carrier_status = $request->carrier_status;
    $external->carrier_payment_terms = $request->carrier_payment_terms;
    $external->carrier_factoring_company = $request->carrier_factoring_company;
    $external->carrier_notes = $request->carrier_notes;

    // === File Upload ===
    if ($request->hasFile('carrier_file_upload')) {
        $files = [];

        foreach ($request->file('carrier_file_upload') as $file) {
            if ($file->isValid()) {
                $filename = time().'_'.$file->getClientOriginalName();
                $destinationPath = public_path('uploads/carrier');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0775, true);
                }

                $file->move($destinationPath, $filename);
                $files[] = 'uploads/carrier/'.$filename;
            }
        }

        $external->carrier_file_upload = json_encode($files);
    }

    $external->save();

    $subject = "Broker Created the Carrier, carrierid:-" . $external->id;
    addToLog($customerId ='', $id='', $subject, $oldData ='', $newData ='');

    return redirect()->back()->with('success', 'Carrier saved successfully!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'carrier_name'        => 'required|string|max:255',
            'carrier_mc_ff'       => 'required',
            'carrier_mc_ff_input' => 'required',
            'carrier_mc_ff_input' => 'required',
        ]);
       
        $carrier = External::findOrFail($id);
        $oldData = json_encode($carrier);

        $carrier->user_id = $request->user_id ?? Auth::user()->id;
        $carrier->dispatcher_name = $request->dispatcher_name ?? Auth::user()->name;
        $carrier->carrier_name = $request->carrier_name;
        $carrier->carrier_mc_ff = $request->carrier_mc_ff;
        $carrier->carrier_mc_ff_input = $request->carrier_mc_ff_input;
        $carrier->carrier_dot = $request->carrier_dot;
        $carrier->carrier_address_two = $request->carrier_address_two;
        $carrier->carrier_country = $request->carrier_country;
        $carrier->carrier_state = $request->carrier_state;
        $carrier->carrier_city = $request->carrier_city;
        $carrier->carrier_zip = $request->carrier_zip;
        $carrier->carrier_contact_name = $request->carrier_contact_name;
        $carrier->carrier_email = $request->carrier_email;
        $carrier->carrier_telephone = $request->carrier_telephone;
        $carrier->carrier_extn = $request->carrier_extn;
        $carrier->carrier_fax = $request->carrier_fax;
        $carrier->carrier_status = $request->carrier_status;
        $carrier->carrier_factoring_company = $request->carrier_factoring_company;
        $carrier->carrier_notes = $request->carrier_notes;

        if ($request->hasFile('carrier_file_upload')) {
            $files = [];

            foreach ($request->file('carrier_file_upload') as $file) {
                if ($file->isValid()) {
                   $filename = time() . '_' . $file->getClientOriginalName();
                    $destinationPath = public_path('uploads/carrier');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0775, true);
                    }

                    $file->move($destinationPath, $filename);
                    $files[] = 'uploads/carrier/' . $filename;
                }
            }
            $carrier->carrier_file_upload = json_encode($files); // Save as JSON
        }
        $carrier->save();

        $newData = json_encode($carrier);

        $subject = "Broker update the Carrier, Carrierid:-".$id;
        addToLog($customerId ='', $loadId ='', $subject, $oldData, $newData);
    
        return redirect()->back()->with('success','Carrier updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        External::findOrFail($id)->delete();
        return redirect()->back()->with('success','Carrier deleted.');
    }
}
