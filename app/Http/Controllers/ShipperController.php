<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\Shipper;
use \App\Models\Consignee;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use \App\Models\Manger;
use \App\Models\TeamLeader;

class ShipperController extends Controller
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
            $shipper = Shipper::with('user.teamLeaderInfo','user.managerInfo')->orderBy("id", "desc")->paginate(10);
            $allcountry = Country::get();
			$state = State::get();
            $users = User::with('role', 'department', 'managers', 'teamleader', 'office')->where('department', 3)->get();

        }else{
            $shipper = Shipper::with('user.teamLeaderInfo','user.managerInfo')->where('user_id', Auth::id())->orderBy("id", "desc")->paginate(10);
            $allcountry = Country::get();
			$state = State::get();
            $users = User::with('role', 'department', 'managers', 'teamleader', 'office')->where('department', 3)->get();

        }
		
		if ($request->ajax()) {
				return view('broker.partials.shipper_table', compact('userInfos', 'state','shipper', 'allcountry', 'users'))->render();
			}
        
        return view('broker.shipper',compact('userInfos', 'state','shipper', 'allcountry', 'users'));
    }
	
	public function shipper_search(Request $request){
		
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
                $shipper = Shipper::with('user.teamLeaderInfo','user.managerInfo')
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhere('shipper_name', 'like', "%$term%");
                        }
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(10);
				
				}else{
					// Search for non-empty terms with 'orWhere'
                $shipper = Shipper::with('user.teamLeaderInfo','user.managerInfo')->where('user_id', Auth::id())
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhere('shipper_name', 'like', "%$term%");
                        }
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(10);
				}
                
				$allcountry = Country::get();
				$state = State::get();
				$users = User::with('role', 'department', 'managers', 'teamleader', 'office')->where('department', 3)->get();
            } else {
                // If no valid terms, return an empty collection or handle accordingly
                $shipper = collect();
				$allcountry = Country::get();
				$state = State::get();
				$users = User::with('role', 'department', 'managers', 'teamleader', 'office')->where('department', 3)->get();
            }
        } else {
           
			if(in_array($role_id, $role_ids)){
				$shipper = Shipper::with('user.teamLeaderInfo','user.managerInfo')->orderBy("id", "desc")->paginate(10);
				
				
			}else{
				$shipper = Shipper::with('user.teamLeaderInfo','user.managerInfo')->where('user_id', Auth::id())->orderBy("id", "desc")->paginate(10);
			
			}
			$allcountry = Country::get();
			$state = State::get();
            $users = User::with('role', 'department', 'managers', 'teamleader', 'office')->where('department', 3)->get();
        }
        
		
		return view('broker.partials.shipper_table', compact('state','shipper', 'allcountry', 'users'))->render();
			
	}
	
	public function shipper_search_user(Request $request){
			
		$user_id = $request->input('user_id');
			// Search for non-empty terms with 'orWhere'
		$shipper = Shipper::with('user.teamLeaderInfo','user.managerInfo')->where('user_id', $user_id)
			->orderBy('id', 'desc')
			->paginate(10);
		
		$allcountry = Country::get();
		$state = State::get();
		$users = User::with('role', 'department', 'managers', 'teamleader', 'office')->where('department', 3)->get();
          
		return view('broker.partials.shipper_table', compact('state','shipper', 'allcountry', 'users'))->render();	
	}

    public function getStatesshipper($country_id)
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
        $validator = Validator::make($request->all(), [
            'shipper_name' => 'required|string|max:255',
            // Add validation rules for other fields if needed
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // ✅ Get validated data
        $validated = $validator->validated();
    
        $sharedData = [
            'user_id' => $request->input('user_id') ?? Auth::user()->id,
            'shipper_name' => $validated['shipper_name'],
            'shipper_address' => $request->input('shipper_address'),
            'shipper_country' => $request->input('shipper_country'),
            'shipper_state' => $request->input('shipper_state'),
            'shipper_city' => $request->input('shipper_city'),
            'shipper_zip' => $request->input('shipper_zip'),
            'shipper_contact_name' => $request->input('shipper_contact_name', ''),
            'shipper_contact_email' => $request->input('shipper_contact_email', ''),
            'shipper_telephone' => $request->input('shipper_telephone', ''),
            'shipper_extn' => $request->input('shipper_extn', ''),
            'shipper_toll_free' => $request->input('shipper_toll_free', ''),
            'shipper_fax' => $request->input('shipper_fax', ''),
            'shipper_hours' => $request->input('shipper_hours', ''),
            'shipper_appointments' => $request->input('shipper_appointments', ''),
            'shipper_major_intersections' => $request->input('shipper_major_intersections', ''),
            'shipper_status' => $request->input('shipper_status', ''),
            'shipper_shipping_notes' => $request->input('shipper_shipping_notes', ''),
            'shipper_internal_notes' => $request->input('shipper_internal_notes', ''),
        ];
    
        // Insert into Shipper
        $shipper = Shipper::create($sharedData);

        
        if($request->same_as_consignee) {
    
            // Insert into Consignee
            Consignee::create([
                'user_id' => $request->input('user_id') ?? Auth::user()->id,
                'consignee_name' => $sharedData['shipper_name'],
                'consignee_address' => $sharedData['shipper_address'],
                'consignee_country' => $sharedData['shipper_country'],
                'consignee_state' => $sharedData['shipper_state'],
                'consignee_city' => $sharedData['shipper_city'],
                'consignee_zip' => $sharedData['shipper_zip'],
                'consignee_contact_name' => $sharedData['shipper_contact_name'],
                'consignee_contact_email' => $sharedData['shipper_contact_email'],
                'consignee_telephone' => $sharedData['shipper_telephone'],
                'consignee_ext' => $sharedData['shipper_extn'],
                'consignee_toll_free' => $sharedData['shipper_toll_free'],
                'consignee_fax' => $sharedData['shipper_fax'],
                'consignee_hours' => $sharedData['shipper_hours'],
                'consignee_appointments' => $sharedData['shipper_appointments'],
                'consignee_major_intersections' => $sharedData['shipper_major_intersections'],
                'consignee_status' => $sharedData['shipper_status'],
                'consignee_shipping_notes' => $sharedData['shipper_shipping_notes'],
                'consignee_internal_notes' => $sharedData['shipper_internal_notes'],
            ]);
        }

         $subject = "Broker Craete the Shipper, shipperid:-".$shipper->id;
        addToLog($customerId ='', $id='', $subject, $oldData ='', $newData ='');
    
        return redirect()->back()->with('success', 'Shipper Data has been saved!');
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
        $data = $request->validate([
            'shipper_name'         => 'required|string|max:255',
            'shipper_address'      => 'required|string',
            'shipper_telephone'    => 'required|string',
           
        ]);

        $sharedData = [
            'user_id' =>  $request->input('user_id'),
            'shipper_name' => $request->input('shipper_name'),
            'shipper_address' => $request->input('shipper_address'),
            'shipper_country' => $request->input('shipper_country'),
            'shipper_state' => $request->input('shipper_state'),
            'shipper_city' => $request->input('shipper_city'),
            'shipper_zip' => $request->input('shipper_zip'),
            'shipper_contact_name' => $request->input('shipper_contact_name', ''),
            'shipper_contact_email' => $request->input('shipper_contact_email', ''),
            'shipper_telephone' => $request->input('shipper_telephone', ''),
            'shipper_extn' => $request->input('shipper_extn', ''),
            'shipper_toll_free' => $request->input('shipper_toll_free', ''),
            'shipper_fax' => $request->input('shipper_fax', ''),
            'shipper_hours' => $request->input('shipper_hours', ''),
            'shipper_appointments' => $request->input('shipper_appointments', ''),
            'shipper_major_intersections' => $request->input('shipper_major_intersections', ''),
            'shipper_status' => $request->input('shipper_status', ''),
            'shipper_shipping_notes' => $request->input('shipper_shipping_notes', ''),
            'shipper_internal_notes' => $request->input('shipper_internal_notes', ''),
        ];
       
        $shipper = Shipper::findOrFail($id);

        $oldData = json_encode($shipper);
        
        $shipper->update($sharedData);

         if($request->same_as_consignee) {
        Consignee::create([
            'user_id' => $request->input('user_id') ?? Auth::user()->id,
            'consignee_name' => $sharedData['shipper_name'],
            'consignee_address' => $sharedData['shipper_address'],
            'consignee_country' => $sharedData['shipper_country'],
            'consignee_state' => $sharedData['shipper_state'],
            'consignee_city' => $sharedData['shipper_city'],
            'consignee_zip' => $sharedData['shipper_zip'],
            'consignee_contact_name' => $sharedData['shipper_contact_name'],
            'consignee_contact_email' => $sharedData['shipper_contact_email'],
            'consignee_telephone' => $sharedData['shipper_telephone'],
            'consignee_ext' => $sharedData['shipper_extn'],
            'consignee_toll_free' => $sharedData['shipper_toll_free'],
            'consignee_fax' => $sharedData['shipper_fax'],
            'consignee_hours' => $sharedData['shipper_hours'],
            'consignee_appointments' => $sharedData['shipper_appointments'],
            'consignee_major_intersections' => $sharedData['shipper_major_intersections'],
            'consignee_status' => $sharedData['shipper_status'],
            'consignee_shipping_notes' => $sharedData['shipper_shipping_notes'],
            'consignee_internal_notes' => $sharedData['shipper_internal_notes'],
        ]);
    }


        $newData = json_encode($sharedData);

        $subject = "Broker update the shipper, shipperid:-".$id;
        addToLog($customerId ='', $loadId ='', $subject, $oldData, $newData);

        return redirect()->back()->with('success', 'Shipper updated successfully!');
    }

    public function destroy($id)
    {
        Shipper::destroy($id);
        return redirect()->back()->with('success', 'Shipper deleted successfully!');
    }
}
