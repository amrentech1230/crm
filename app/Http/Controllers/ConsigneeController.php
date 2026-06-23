<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use \App\Models\Shipper;
use \App\Models\Consignee;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use \App\Models\Manger;
use \App\Models\TeamLeader;

class ConsigneeController extends Controller
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
            $consignees = Consignee::with('user.teamLeaderInfo','user.managerInfo')->orderBy("id", "desc")->paginate(10);
            $allcountry = Country::get();
			$state = State::get();
            $users = User::with('role', 'department', 'managers', 'teamleader', 'office')->where('department', 3)->get();
        }else{
            $consignees = Consignee::with('user.teamLeaderInfo','user.managerInfo')->where('user_id', Auth::id())->orderBy("id", "desc")->paginate(10);
            $allcountry = Country::get();
			$state = State::get();
            $users = User::with('role', 'department', 'managers', 'teamleader', 'office')->where('department', 3)->get();
        }
		if ($request->ajax()) {
				return view('broker.partials.consignee_table', compact('userInfos', 'state', 'allcountry', 'consignees', 'users'))->render();
			}
        return view('broker.consignee',compact('userInfos', 'state', 'allcountry', 'consignees', 'users'));
    }
	
	public function consignee_search(Request $request){
		
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
                $consignees = Consignee::with('user.teamLeaderInfo','user.managerInfo')
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhere('consignee_name', 'like', "%$term%");
                        }
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(10);
				
				}else{
					// Search for non-empty terms with 'orWhere'
                $consignees = Consignee::with('user.teamLeaderInfo','user.managerInfo')->where('user_id', Auth::id())
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhere('consignee_name', 'like', "%$term%");
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
                $consignees = collect();
				$allcountry = Country::get();
				$state = State::get();
				$users = User::with('role', 'department', 'managers', 'teamleader', 'office')->where('department', 3)->get();
            }
        } else {
           
			if(in_array($role_id, $role_ids)){
				$consignees = Consignee::with('user.teamLeaderInfo','user.managerInfo')->orderBy("id", "desc")->paginate(10);
				
				
			}else{
				$consignees = Consignee::with('user.teamLeaderInfo','user.managerInfo')->where('user_id', Auth::id())->orderBy("id", "desc")->paginate(10);
			
			}
			$allcountry = Country::get();
			$state = State::get();
            $users = User::with('role', 'department', 'managers', 'teamleader', 'office')->where('department', 3)->get();
        }
        
		
		return view('broker.partials.consignee_table', compact('state', 'allcountry', 'consignees', 'users'))->render();
			
	}
	public function consignee_search_user(Request $request){
		
		$user_id = $request->input('user_id');
		// Search for non-empty terms with 'orWhere'
		$consignees = Consignee::with('user.teamLeaderInfo','user.managerInfo')->where('user_id', $user_id)
			->orderBy('id', 'desc')
			->paginate(10);
		
		$allcountry = Country::get();
		$state = State::get();
		$users = User::with('role', 'department', 'managers', 'teamleader', 'office')->where('department', 3)->get();
            
		
		return view('broker.partials.consignee_table', compact('state', 'allcountry', 'consignees', 'users'))->render();
			
	}
	
    public function getStatesconsignee($country_id)
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
        $SessionData = session('user');
        $user = $SessionData;
           $consignee = Consignee::create([
                'user_id' => $request->input('user_id') ?? Auth::user()->id,
                'consignee_name' => $request->input('consignee_name') ?? '',
                'consignee_address' => $request->input('consignee_address') ?? '',
                'consignee_country' => $request->input('consignee_country') ?? '',
                'consignee_state' => $request->input('consignee_state') ?? '',
                'consignee_city' => $request->input('consignee_city') ?? '',
                'consignee_zip' => $request->input('consignee_zip') ?? '',
                'consignee_contact_name' => $request->input('consignee_contact_name') ?? '',
                'consignee_contact_email' => $request->input('consignee_contact_email') ?? '',
                'consignee_telephone' => $request->input('consignee_telephone') ?? '',
                'consignee_ext' => $request->input('consignee_ext') ?? '',
                'consignee_toll_free' => $request->input('consignee_toll_free') ?? '',
                'consignee_fax' => $request->input('consignee_fax') ?? '',
                'consignee_hours' => $request->input('consignee_hours') ?? '',
                'consignee_appointments' => $request->input('consignee_appointments') ?? '',
                'consignee_major_intersections' => $request->input('consignee_major_intersections') ?? '',
                'consignee_status' => $request->input('consignee_status') ?? '',
                'consignee_shipping_notes' => $request->input('consignee_shipping_notes') ?? '',
                'consignee_internal_notes' => $request->input('consignee_internal_notes') ?? '',
            ]);


        if($request->consignee_add_shippper) {
        
        Shipper::create([
            'user_id' =>  $request->input('user_id') ?? Auth::user()->id,
            'shipper_name' => $request->consignee_name ?? '',
            'shipper_address' => $request->consignee_address ?? '',
            'shipper_country' => $request->consignee_country ?? '',
            'shipper_state' => $request->consignee_state ?? '',
            'shipper_city' => $request->consignee_city ?? '',
            'shipper_zip' => $request->consignee_zip ?? '',
            'shipper_contact_name' => $request->consignee_contact_name ?? '',
            'shipper_contact_email' => $request->consignee_contact_email ?? '',
            'shipper_telephone' => $request->consignee_telephone ?? '',
            'shipper_extn' => $request->consignee_ext ?? '',
            'shipper_toll_free' => $request->consignee_toll_free ?? '',
            'shipper_fax' => $request->consignee_fax ?? '',
            'shipper_hours' => $request->consignee_hours ?? '',
            'shipper_appointments' => $request->consignee_appointments ?? '',
            'shipper_major_intersections' => $request->consignee_major_intersections ?? '',
            'shipper_status' => $request->consignee_status ?? '',
            'shipper_shipping_notes' => $request->consignee_shipping_notes ?? '',
            'shipper_internal_notes' => $request->consignee_internal_notes ?? '',
        ]);
        }

        $subject = "Broker Craete the Consignee, Consigneeid:-".$consignee->id;;
        addToLog($customerId ='', $id='', $subject, $oldData ='', $newData ='');

    return redirect()->back()->with(['message' => 'Consignee added successfully']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
      
        $consignee = Consignee::findOrFail($id);
        $oldData = json_encode($consignee);

        $consignee->update([
            'user_id' =>  $request->input('user_id') ?? $consignee->user_id,
            'consignee_name' => $request->input('consignee_name', $consignee->consignee_name),
            'consignee_address' => $request->input('consignee_address', $consignee->consignee_address),
            'consignee_country' => $request->input('consignee_country', $consignee->consignee_country),
            'consignee_state' => $request->input('consignee_state', $consignee->consignee_state),
            'consignee_city' => $request->input('consignee_city', $consignee->consignee_city),
            'consignee_zip' => $request->input('consignee_zip', $consignee->consignee_zip),
            'consignee_contact_name' => $request->input('consignee_contact_name', $consignee->consignee_contact_name),
            'consignee_contact_email' => $request->input('consignee_contact_email', $consignee->consignee_contact_email),
            'consignee_telephone' => $request->input('consignee_telephone', $consignee->consignee_telephone),
            'consignee_ext' => $request->input('consignee_ext', $consignee->consignee_ext),
            'consignee_toll_free' => $request->input('consignee_toll_free', $consignee->consignee_toll_free),
            'consignee_fax' => $request->input('consignee_fax', $consignee->consignee_fax),
            'consignee_hours' => $request->input('consignee_hours', $consignee->consignee_hours),
            'consignee_appointments' => $request->input('consignee_appointments', $consignee->consignee_appointments),
            'consignee_major_intersections' => $request->input('consignee_major_intersections', $consignee->consignee_major_intersections),
            'consignee_status' => $request->input('consignee_status', $consignee->consignee_status),
            'consignee_shipping_notes' => $request->input('consignee_shipping_notes', $consignee->consignee_shipping_notes),
            'consignee_internal_notes' => $request->input('consignee_internal_notes', $consignee->consignee_internal_notes),
        ]);

        if ($request->has('update_shipper') && $request->input('update_shipper') == 'on') {
            $shipper = Shipper::where('user_id', $consignee->user_id)->first();

            if ($shipper) {
                $shipper->update([
                    'user_id' =>  $request->input('user_id') ?? $shipper->user_id,
                    'shipper_name' => $request->input('shipper_name', $shipper->shipper_name),
                    'shipper_address' => $request->input('shipper_address', $shipper->shipper_address),
                    'shipper_country' => $request->input('shipper_country', $shipper->shipper_country),
                    'shipper_state' => $request->input('shipper_state', $shipper->shipper_state),
                    'shipper_city' => $request->input('shipper_city', $shipper->shipper_city),
                    'shipper_zip' => $request->input('shipper_zip', $shipper->shipper_zip),
                    'shipper_contact_name' => $request->input('shipper_contact_name', $shipper->shipper_contact_name),
                    'shipper_contact_email' => $request->input('shipper_contact_email', $shipper->shipper_contact_email),
                    'shipper_telephone' => $request->input('shipper_telephone', $shipper->shipper_telephone),
                ]);
            }
        }

        $newData = json_encode($consignee);

        $subject = "Broker update the Consignee, consigneeid:-".$id;
        addToLog($customerId ='', $loadId ='', $subject, $oldData, $newData);
   
        return redirect()->back()->with('success', 'Consignee and Shipper updated successfully');
    }

    public function destroy($id)
    {
        // Find the consignee by ID
        $consignee = Consignee::findOrFail($id);

        // Delete the consignee
        $consignee->delete();

        return redirect()->back()->with('success', 'Consignee deleted successfully');
    }

}
