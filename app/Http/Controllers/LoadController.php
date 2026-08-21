<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Load;
use App\Models\External;
use App\Models\Customer;
use App\Models\EquipmentType;
use App\Models\ShipmentType;
use \App\Models\Shipper;
use \App\Models\Consignee;
use \App\Models\user;
use \App\Models\Manger;
use \App\Models\TeamLeader;
use \App\Models\ItHardware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Dompdf\Options;
use Dompdf\Dompdf;

class LoadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
		
		$tabs = ['all_loads', 'open', 'delivered', 'complete', 'invoice', 'invoice_paid'];

		foreach ($tabs as $tab) {
			if ($request->has($tab)) {
				Paginator::currentPageResolver(function () use ($request, $tab) {
					return $request->input($tab);
				});
				break; // Stop after finding the matching tab
			}
		}

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
    $userInfos = User::whereIn('id', $allIds)->where('status', 'Active')->orderBy('name', 'asc')->pluck('name', 'id')->toArray();



        
        $role_ids = [1, 2 ,3];
        if(in_array($role_id, $role_ids)){
            $all_load = Load::orderBy("id", "desc")->paginate(50)->setPageName('all_loads');
            $open = Load::where('load_status', 'Open')->paginate(50)->setPageName('open');
            $complete = Load::where('load_status', 'Completed')->where(function($query) {
                    $query->where('invoice_status', '')
                          ->orWhereNull('invoice_status');
                })->orderBy("id", "desc")->paginate(50)->setPageName('complete');
            $delivered = Load::where('load_status', 'Delivered')->paginate(50)->setPageName('delivered');
            $invoice = Load::where('invoice_status', 'Paid')->paginate(50)->setPageName('invoice');
            $invoice_paid = Load::where('invoice_status', 'Paid Record')->paginate(50)->setPageName('invoice_paid');
            $customer = Customer::where('status', 'Approved')->get();

        }else{
            $all_load = Load::where('user_id', Auth::id())->orderBy("id", "desc")->paginate(50)->setPageName('all_loads');
            $open = Load::where('user_id', Auth::id())->orderBy("id", "desc")->where('load_status', 'Open')->paginate(50)->setPageName('open');
            $complete = Load::where('load_status', 'Completed')->where(function($query) {
                    $query->where('invoice_status', '')
                          ->orWhereNull('invoice_status');
                })->where('user_id', Auth::id())->orderBy("id", "desc")->paginate(50)->setPageName('complete');
            $delivered = Load::where('load_status', 'Delivered')->where('user_id', Auth::id())->orderBy("id", "desc")->paginate(50)->setPageName('delivered');
            
            $invoice = Load::where('invoice_status', 'Paid')->where('user_id', Auth::id())->orderBy("id", "desc")->paginate(50)->setPageName('invoice');
            $invoice_paid = Load::where('invoice_status', 'Paid Record')->where('user_id', Auth::id())->orderBy("id", "desc")->paginate(50)->setPageName('invoice_paid');
            $customer = Customer::where('user_id', Auth::id())
                ->where('status', 'Approved')
                ->where(function($q) {
                    $q->where('customer_hold_status', 'unhold')
                    ->orWhereNull('customer_hold_status')
                    ->orWhere('customer_hold_status', '');
                })
                ->get();
        }

       
        $equipmentType = EquipmentType::all();
        $shipmentType = ShipmentType::all();
		
		if ($request->ajax()) {
			
			if($request->input('tab') == '#all'){
				return view('broker.loads.all_loads', compact('userInfos', 'all_load', 'open', 'complete', 'delivered', 'invoice', 'invoice_paid', 'customer', 'equipmentType', 'shipmentType'))->render();
			}else if($request->input('tab') == '#open'){
				return view('broker.loads.open', compact('userInfos', 'all_load', 'open', 'complete', 'delivered', 'invoice', 'invoice_paid', 'customer', 'equipmentType', 'shipmentType'))->render();
			}else if($request->input('tab') == '#delivered'){
				return view('broker.loads.delivered', compact('userInfos', 'all_load', 'open', 'complete', 'delivered', 'invoice', 'invoice_paid', 'customer', 'equipmentType', 'shipmentType'))->render();
			}else if($request->input('tab') == '#complete'){
				return view('broker.loads.complete', compact('userInfos', 'all_load', 'open', 'complete', 'delivered', 'invoice', 'invoice_paid', 'customer', 'equipmentType', 'shipmentType'))->render();
			}else if($request->input('tab') == '#invoice'){
				return view('broker.loads.invoice', compact('userInfos', 'all_load', 'open', 'complete', 'delivered', 'invoice', 'invoice_paid', 'customer', 'equipmentType', 'shipmentType'))->render();
			}else if($request->input('tab') == '#paid'){
				return view('broker.loads.invoice_paid', compact('userInfos', 'all_load', 'open', 'complete', 'delivered', 'invoice', 'invoice_paid', 'customer', 'equipmentType', 'shipmentType'))->render();
			}
				
		}
		
        return view('broker.load', compact('userInfos', 'all_load', 'open', 'complete', 'delivered', 'invoice', 'invoice_paid', 'customer', 'equipmentType', 'shipmentType'));
    }

    public function broker_all_load(Request $request){
        $q = $request->input('query');
		$user_id = $request->input('user_id') ?? Auth::id();
        if (!empty($q)) {
            // Split the query by commas to get multiple terms
            $searchTerms = array_filter(explode(',', $q), function($term) {
                return !empty(trim($term)); // Only keep non-empty terms
            });

            if (count($searchTerms) > 0) {
                // Search for non-empty terms with 'orWhere'
                $all_load = Load::where('user_id', $user_id)->orderBy("id", "desc")
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhere('load_number', 'like', "%$term%");
                            $query->orwhere('load_workorder', 'like', "%$term%");
                            $query->orwhere('customer_refrence_number', 'like', "%$term%");
                            $query->orwhere('load_bill_to', 'like', "%$term%");
                            $query->orwhere('load_carrier', 'like', "%$term%");
                            $query->orwhere('invoice_number', 'like', "%$term%");
                            $query->orwhere('load_status', 'like', "%$term%");
if (!empty($term)) {

    if (strtolower($term) == 'invoiced') {
        $query->orWhere('invoice_status', 'Paid');
    } elseif (strtolower($term) == 'paid') {
        $query->orWhere('invoice_status', 'Paid Record');
    } else {
        $query->orWhere('invoice_status', 'like', "%{$term}%");
    }
}                        }
                    })
                    ->get();
            } else {
                // If no valid terms, return an empty collection or handle accordingly
                $all_load = collect();
            }
        } else {
			
            // If query is empty, return a paginated result without any filter
            $all_load = Load::orderBy("id", "desc")->where('user_id', Auth::id())->paginate(50);
			
        }
        
        return view('broker.loads.all_loads', compact('all_load'))->render();
    }
	
	public function load_search_by_user(Request $request){
		
        $user_id = $request->input('user_id');
			
			$all_load = Load::where('user_id', $user_id)->orderBy("id", "desc")->paginate(500)->setPageName('all_loads');
            
			$open = Load::where('user_id', $user_id)->orderBy("id", "desc")->where('load_status', 'Open')->paginate(500)->setPageName('open');
            
			$complete = Load::where('load_status', 'Completed')->where(function($query) {
                    $query->where('invoice_status', '')
                          ->orWhereNull('invoice_status');
                })->where('user_id', $user_id)->orderBy("id", "desc")->paginate(500)->setPageName('complete');
            
			$delivered = Load::where('load_status', 'Delivered')->where('user_id', $user_id)->orderBy("id", "desc")->paginate(500)->setPageName('delivered');
            
			$invoice = Load::where('invoice_status', 'Paid')->where('user_id', $user_id)->orderBy("id", "desc")->paginate(500)->setPageName('invoice');
            
			$invoice_paid = Load::where('invoice_status', 'Paid Record')->where('user_id', $user_id)->orderBy("id", "desc")->paginate(500)->setPageName('invoice_paid');
            
			$customer = Customer::where('user_id', $user_id)
                ->where('status', 'Approved')
                ->where(function($q) {
                    $q->where('customer_hold_status', 'unhold')
                    ->orWhereNull('customer_hold_status')
                    ->orWhere('customer_hold_status', '');
                })
                ->get();
        

       
        $equipmentType = EquipmentType::all();
        $shipmentType = ShipmentType::all();
		
		if ($request->ajax()) {
			
			if($request->input('activeTab') == '#all'){
				return view('broker.loads.all_loads', compact('all_load', 'open', 'complete', 'delivered', 'invoice', 'invoice_paid', 'customer', 'equipmentType', 'shipmentType'))->render();
			}else if($request->input('activeTab') == '#open'){
				return view('broker.loads.open', compact('all_load', 'open', 'complete', 'delivered', 'invoice', 'invoice_paid', 'customer', 'equipmentType', 'shipmentType'))->render();
			}else if($request->input('activeTab') == '#delivered'){
				return view('broker.loads.delivered', compact('all_load', 'open', 'complete', 'delivered', 'invoice', 'invoice_paid', 'customer', 'equipmentType', 'shipmentType'))->render();
			}else if($request->input('activeTab') == '#complete'){
				return view('broker.loads.complete', compact('all_load', 'open', 'complete', 'delivered', 'invoice', 'invoice_paid', 'customer', 'equipmentType', 'shipmentType'))->render();
			}else if($request->input('activeTab') == '#invoice'){
				return view('broker.loads.invoice', compact('all_load', 'open', 'complete', 'delivered', 'invoice', 'invoice_paid', 'customer', 'equipmentType', 'shipmentType'))->render();
			}else if($request->input('activeTab') == '#paid'){
				return view('broker.loads.invoice_paid', compact('all_load', 'open', 'complete', 'delivered', 'invoice', 'invoice_paid', 'customer', 'equipmentType', 'shipmentType'))->render();
			}
				
		}
    }

    public function editload($id)
    {

        $post = Load::find($id);

        if (!$post) {
            // Record not found, handle the error gracefully
            return redirect()->back()->withErrors(['msg' => 'Load not found.']);
        }
        
        $user_id = Auth::id();
        $shipperData = json_decode($post->load_shipper, true); // Assuming 'load_shipper' is where your JSON data is stored
        $postData = $post->getAttributes();


        $allCustomers = Customer::where('user_id', $user_id)->get();

        $invoicechargestotal = 0;

        $shipperCharges = json_decode($post->shipper_load_other_charge, true);
        if(isset($shipperCharges)){
            foreach ($shipperCharges as $item) {
                        if (isset($item['for_invoice']) && !is_null($item['for_invoice'])) {
                            $invoicechargestotal += (float)$item['amount'];
                        }
                    }
        }
        $customer = Customer::where('status', 'Approved')->get();
        $equipmentType = EquipmentType::all();
        $shipmentType = ShipmentType::all();

        $shipperdata= Shipper::where('user_id', $user_id)->orderBy('shipper_name', 'asc')->get();
        $consigneedata= Consignee::where('user_id', $user_id)->orderBy('consignee_name', 'asc')->get();
        
        //$allCustomers = Customer::where('user_id', $user_id)->get();
        return view('broker.edit_broker_load', compact('shipperdata', 'consigneedata', 'equipmentType', 'customer', 'shipmentType','post', 'shipperData', 'postData', 'allCustomers', 'invoicechargestotal'));
    }

    public function broker_open_load(Request $request){
        $q = $request->input('query');
		$user_id = $request->input('user_id') ?? Auth::id();
        if (!empty($q)) {
            // Split the query by commas to get multiple terms
            $searchTerms = array_filter(explode(',', $q), function($term) {
                return !empty(trim($term)); // Only keep non-empty terms
            });

            if (count($searchTerms) > 0) {
                // Search for non-empty terms with 'orWhere'
                $open = Load::where('user_id', $user_id)->orderBy("id", "desc")
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhere('load_number', 'like', "%$term%");
                            $query->orwhere('load_workorder', 'like', "%$term%");
                            $query->orwhere('customer_refrence_number', 'like', "%$term%");
                            $query->orwhere('load_bill_to', 'like', "%$term%");
                            $query->orwhere('load_carrier', 'like', "%$term%");
                            $query->orwhere('invoice_number', 'like', "%$term%");
                        }
                    })
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                // If no valid terms, return an empty collection or handle accordingly
                $open = collect();
            }
        } else {
            // If query is empty, return a paginated result without any filter
           $open = Load::where('user_id', $user_id)->where('load_status', 'Open')->orderBy("id", "desc")->paginate(50);
        }
        
        return view('broker.loads.open', compact('open'))->render();
    }

    public function broker_delivered_load(Request $request){
        $q = $request->input('query');
		
		$user_id = $request->input('user_id') ?? Auth::id();
		
        if (!empty($q)) {
            // Split the query by commas to get multiple terms
            $searchTerms = array_filter(explode(',', $q), function($term) {
                return !empty(trim($term)); // Only keep non-empty terms
            });

            if (count($searchTerms) > 0) {
                // Search for non-empty terms with 'orWhere'
                $delivered = Load::where('user_id', $user_id)->orderBy("id", "desc")
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhere('load_number', 'like', "%$term%");
                            $query->orwhere('load_workorder', 'like', "%$term%");
                            $query->orwhere('customer_refrence_number', 'like', "%$term%");
                        }
                    })
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                // If no valid terms, return an empty collection or handle accordingly
                $delivered = collect();
            }
        } else {
            
            // If query is empty, return a paginated result without any filter
           $delivered = Load::where('user_id', $user_id)->where('load_status', 'Delivered')->orderBy("id", "desc")->paginate(50);
           //dd($delivered);
  
        }
        
        return view('broker.loads.delivered', compact('delivered'))->render();
    }

    public function broker_complete_load(Request $request){
        $q = $request->input('query');
		$user_id = $request->input('user_id') ?? Auth::id();
        if (!empty($q)) {
            // Split the query by commas to get multiple terms
            $searchTerms = array_filter(explode(',', $q), function($term) {
                return !empty(trim($term)); // Only keep non-empty terms
            });

            if (count($searchTerms) > 0) {
                // Search for non-empty terms with 'orWhere'
                $complete = Load::where('user_id', $user_id)->orderBy("id", "desc")
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhere('load_number', 'like', "%$term%");
                            $query->orwhere('load_workorder', 'like', "%$term%");
                            $query->orwhere('customer_refrence_number', 'like', "%$term%");
                            $query->orwhere('load_bill_to', 'like', "%$term%");
                            $query->orwhere('load_carrier', 'like', "%$term%");
                            $query->orwhere('invoice_number', 'like', "%$term%");
                        }
                    })
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                // If no valid terms, return an empty collection or handle accordingly
                $complete = collect();
            }
        } else {
            // If query is empty, return a paginated result without any filter
            $complete = Load::where('user_id', $user_id)->where('load_status', 'Completed')->where(function($query) {
                    $query->where('invoice_status', '')
                          ->orWhereNull('invoice_status');
                })->orderBy("id", "desc")->paginate(50);
  
        }
        
        return view('broker.loads.complete', compact('complete'))->render();
    }

    public function broker_invoice_load(Request $request){
        $q = $request->input('query');
		$user_id = $request->input('user_id') ?? Auth::id();
        if (!empty($q)) {
            // Split the query by commas to get multiple terms
            $searchTerms = array_filter(explode(',', $q), function($term) {
                return !empty(trim($term)); // Only keep non-empty terms
            });

            if (count($searchTerms) > 0) {
                // Search for non-empty terms with 'orWhere'
                $invoice = Load::where('user_id', $user_id)->orderBy("id", "desc")
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhere('load_number', 'like', "%$term%");
                            $query->orwhere('load_workorder', 'like', "%$term%");
                            $query->orwhere('customer_refrence_number', 'like', "%$term%");
                            $query->orwhere('load_bill_to', 'like', "%$term%");
                            $query->orwhere('load_carrier', 'like', "%$term%");
                            $query->orwhere('invoice_number', 'like', "%$term%");
                        }
                    })
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                // If no valid terms, return an empty collection or handle accordingly
                $invoice = collect();
            }
        } else {
            // If query is empty, return a paginated result without any filter
            $invoice = Load::where('user_id', $user_id)->where('invoice_status', 'Paid')->orderBy("id", "desc")->paginate(50);
  
        }
        
        return view('broker.loads.invoice', compact('invoice'))->render();
    }

    public function broker_paid_load(Request $request){
        $q = $request->input('query');
		$user_id = $request->input('user_id') ?? Auth::id();
        if (!empty($q)) {
            // Split the query by commas to get multiple terms
            $searchTerms = array_filter(explode(',', $q), function($term) {
                return !empty(trim($term)); // Only keep non-empty terms
            });

            if (count($searchTerms) > 0) {
                // Search for non-empty terms with 'orWhere'
                $invoice_paid = Load::where('user_id', $user_id)->orderBy("id", "desc")
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhere('load_number', 'like', "%$term%");
                            $query->orwhere('load_workorder', 'like', "%$term%");
                            $query->orwhere('customer_refrence_number', 'like', "%$term%");
                            $query->orwhere('load_bill_to', 'like', "%$term%");
                            $query->orwhere('load_carrier', 'like', "%$term%");
                            $query->orwhere('invoice_number', 'like', "%$term%");
                        }
                    })
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                // If no valid terms, return an empty collection or handle accordingly
                $invoice_paid = collect();
            }
        } else {
            // If query is empty, return a paginated result without any filter
             $invoice_paid = Load::where('user_id', $user_id)->where('invoice_status', 'Paid Record')->orderBy("id", "desc")->paginate(50);
  
        }
        
        return view('broker.loads.invoice_paid', compact('invoice_paid'))->render();
    }

    public function cloneLoad($id) 
    {       
       
        $originalLoad = Load::findOrFail($id);
        $newLoad = new Load();
        $newLoad->load_dispatcher = Auth::user()->name;
        $newLoad->user_id = Auth::id();
		$newLoad->customer_id = $originalLoad->customer_id ?? '';
        $newLoad->load_carrier = $originalLoad->load_carrier ?? '';
        $newLoad->load_bill_to = $originalLoad->load_bill_to ?? '';
        $newLoad->load_status = 'Open';
        $newLoad->load_workorder = '';
        $newLoad->load_payment_type = $originalLoad->load_payment_type ?? '';
        $newLoad->load_type = $originalLoad->load_type ?? '';
        $newLoad->load_pds = $originalLoad->load_pds ?? '';
        $newLoad->load_telephone = $originalLoad->load_telephone ?? '';
        $newLoad->load_advance_payment = $originalLoad->load_advance_payment ?? '';
            if (empty($originalLoad->load_type_two)) {
                return redirect()->back()->with('error', 'Load Type is required and cannot be blank. Please select the Load Type first and clone.');
            }
        $newLoad->load_type_two = $originalLoad->load_type_two;
        $newLoad->load_billing_type = $originalLoad->load_billing_type ?? '';
        $newLoad->load_mc_no = $originalLoad->load_mc_no ?? '';
        $newLoad->load_equipment_type = $originalLoad->load_equipment_type ?? '';
        $newLoad->load_currency = $originalLoad->load_currency ?? '';
        $newLoad->load_pds_two = $originalLoad->load_pds_two ?? '';
        $newLoad->load_billing_fsc_rate = $originalLoad->load_billing_fsc_rate ?? '';
        $newLoad->load_other_charge = $originalLoad->load_other_charge ?? '';
        //$newLoad->load_consignee_appointment = $originalLoad->load_consignee_appointment ?? '';
        $newLoad->load_consigneer_contact = $originalLoad->load_consigneer_contact ?? '';
        $newLoad->load_consigneer_notes = $originalLoad->load_consigneer_notes ?? '';
        $newLoad->load_shipperr = $originalLoad->load_shipperr ?? '';
        $newLoad->load_shipper_location = $originalLoad->load_shipper_location ?? '';
        $newLoad->load_shipper_discription = $originalLoad->load_shipper_discription ?? '';
        $newLoad->load_shipper_commodity_type = $originalLoad->load_shipper_commodity_type ?? '';
        $newLoad->load_shipper_qty = $originalLoad->load_shipper_qty ?? '';
        $newLoad->load_shipper_weight = $originalLoad->load_shipper_weight ?? '';
        $newLoad->load_shipper_commodity = $originalLoad->load_shipper_commodity ?? '';
        $newLoad->load_shipper_value = $originalLoad->load_shipper_value ?? '';
        $newLoad->load_shipper_shipping_notes = $originalLoad->load_shipper_shipping_notes ?? '';
        $newLoad->load_shipper_po_numbers = $originalLoad->load_shipper_po_numbers ?? '';
        $newLoad->load_shipper_contact = $originalLoad->load_shipper_contact ?? '';
        //$newLoad->load_shipper_appointment = $originalLoad->load_shipper_appointment ?? '';
        $newLoad->load_consignee = $originalLoad->load_consignee ?? '';
        $newLoad->load_consignee_location = $originalLoad->load_consignee_location ?? '';
        //$newLoad->load_consignee_appointment = $originalLoad->load_consignee_appointment ?? ''; 
        $newLoad->load_consignee_discription = $originalLoad->load_consignee_discription ?? '';
        $newLoad->load_consignee_type = $originalLoad->load_consignee_type ?? '';
        $newLoad->load_consignee_commodity = $originalLoad->load_consignee_commodity ?? '';
        $newLoad->load_consignee_qty = $originalLoad->load_consignee_qty ?? '';
        $newLoad->load_consignee_weight = $originalLoad->load_consignee_weight ?? '';
        $newLoad->load_consignee_value = $originalLoad->load_consignee_value ?? '';
        $newLoad->load_consigneer_notes = $originalLoad->load_consigneer_notes ?? '';
        $newLoad->load_consignee_po_numbers = $originalLoad->load_consignee_po_numbers ?? '';
        $newLoad->load_consignee_contact = $originalLoad->load_consignee_contact ?? '';
        $newLoad->load_consignee_delivery_notes = $originalLoad->load_consignee_delivery_notes ?? '';
        $newLoad->load_carrier_phone = $originalLoad->load_carrier_phone ?? '';
        $newLoad->remaining_amount = $originalLoad->remaining_amount ?? '';
        $newLoad->load_final_carrier_fee =  0;
        $newLoad->shipper_load_final_rate = 0;
        $newLoad->load_carrier_fee = 0;
        $newLoad->load_shipper_rate = 0;
        $newLoad->load_fsc_rate = 0;
        $newLoad->load_billing_fsc_rate = 0;
        $newLoad->load_billing_fsc_rate = 0;
        $newLoad->cpr_check = 'Not Approved';
        $newLoad->carrier_dot = $originalLoad->carrier_dot ??  '';
        $newLoad->carrier_id = $originalLoad->carrier_id ?? '';
        $newLoad->customer_refrence_number = '';
        $newLoad->save();
        $insertedId = $newLoad->id;
        $newLoad->load_number = $insertedId;
        $newLoad->customer_id = $originalLoad->customer_id ?? '';
        $carrierCharges = [];
        if (!empty($originalLoad->shipper_type_charge) && !empty($originalLoad->shipper_other_charge)) {
            foreach ($originalLoad->shipper_type_charge as $index => $carrierchargeType) {
                $carrierchargeAmount = $originalLoad->shipper_other_charge[$index] ?? 0; // Default to 0 if not set
                $carrierCharges[] = [
                    'type' => $carrierchargeType,
                    'amount' => $carrierchargeAmount,
                ];
            }
        }
        $newLoad->carrier_load_other_charge = json_encode($carrierCharges);

        $newLoad->save();

        //$newData = json_encode($newLoad);
        $subject = "Broker Clone the Load, loadid:-".$id;
        addToLog($customerId ='', $id, $subject, $oldData ='', $newData ='');
		
		
        // Redirect with success message
        return redirect()->route('load.editload', $insertedId)->with('success', 'Load has been cloned successfully');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       
        
        $request->validate([
            'load_bill_to' => 'required|string',
            'load_delivery_do_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'shipper_load_final_rate' => 'required|numeric|gt:0',
        ]);



            $yourModel = new Load();

            $shipper_name = [];
            $shipper_location = [];
            $shipper_appointment = [];
            $shipper_description = [];
            $shipper_commodity_type = [];
            $shipper_commodity_name = [];
            $shipper_qty = [];
            $shipper_weight = [];
            $shipper_value = [];
            $shipper_note = [];
            $shipper_po_number = [];
            $shipper_contact = [];

            $consignee_name = [];
            $consignee_location = [];
            $load_consignee_appointment = [];
            $consignee_description = [];
            $consignee_commodity_type = [];
            $consignee_commodity_name = [];
            $consignee_qty = [];
            $consignee_weight = [];
            $consignee_value = [];
            $load_consignee_notes = [];
            $consignee_po_number = [];
            $consignee_delivery_note = [];
            $load_consignee_notes = [];
            $load_consignee_contact = [];

            
            $user = Auth::id();
        
            // Process the request data
            foreach ($request->all() as $key => $value) {
                if (preg_match('/^load_shipper(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $shipper_name[] = ['name' => $value];
                } elseif (preg_match('/^load_shipper_location(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $shipper_location[] = ['location' => $value];
                } elseif (preg_match('/^load_shipper_description(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $shipper_description[] = ['description' => $value];
                } elseif (preg_match('/^load_shipper_appointment(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $shipper_appointment[] = ['appointment' => $value];
                } elseif (preg_match('/^load_shipper_commodity_type(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $shipper_commodity_type[] = ['commodity_type' => $value];
                } elseif (preg_match('/^load_shipper_commodity(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $shipper_commodity_name[] = ['commodity_name'=> $value];
                } elseif (preg_match('/^load_shipper_qty(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $shipper_qty[] = ['shipper_qty' => $value];
                } elseif (preg_match('/^load_shipper_weight(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $shipper_weight[] = ['shipper_weight' => $value];
                } elseif (preg_match('/^load_shipper_value(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $shipper_value[] = ['shipper_value' => $value];
                } elseif (preg_match('/^load_shipper_shipping_notes(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $shipper_note[] = ['shipping_notes' => $value];
                } elseif (preg_match('/^load_shipper_po_numbers(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $shipper_po_number[] = ['shipping_po_numbers' => $value];
                } elseif (preg_match('/^load_shipper_contact(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $shipper_contact[] = ['shipping_contact' => $value];
                }
        
                // Continue with other shipper fields...
        
                elseif (preg_match('/^load_consignee(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $consignee_name[] = ['name' => $value];
                } elseif (preg_match('/^load_consignee_location(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $consignee_location[] =['location' => $value];
                } elseif (preg_match('/^load_consignee_description(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $consignee_description[] = ['description' => $value];
                } elseif (preg_match('/^load_consignee_appointment(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $load_consignee_appointment[] = ['appointment' => $value];
                } elseif (preg_match('/^load_consignee_type(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $consignee_commodity_type[] = ['consignee_type' => $value];
                } elseif (preg_match('/^load_consignee_commodity(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $consignee_commodity_name[] = ['consignee_commodity' => $value];
                } elseif (preg_match('/^load_consignee_qty(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $consignee_qty[]= ['consignee_qty' => $value];
                } elseif (preg_match('/^load_consignee_weight(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $consignee_weight[] = ['consignee_weight' => $value];
                } elseif (preg_match('/^load_consignee_value(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $consignee_value[] = ['consignee_value' => $value];
                } elseif (preg_match('/^load_consignee_delivery_notes(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $consignee_delivery_note[] = ['consignee_delivery_notes' => $value];
                } elseif (preg_match('/^load_consignee_po_numbers(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $consignee_po_number[] = ['consignee_po_number' => $value];
                } elseif (preg_match('/^load_consignee_contact(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $load_consignee_contact[] = ['consignee_contact' => $value];
                } elseif (preg_match('/^load_consignee_notes(\d*)$/', $key, $matches)) {
                    $index = $matches[1] ?: 0;
                    $load_consignee_notes[] = ['load_consignee_notes' => $value];
                }
                // } elseif (preg_match('/^load_consignee_notes(\d*)$/', $key, $matches)) {
                //     $index = $matches[1] ?: 0;
                //     $consignee_note[$index]['consignee_notes'] = $value;
                // }
            }

            $yourModel->load_shipperr = json_encode($shipper_name);
            $yourModel->load_shipper_location = json_encode($shipper_location);
            $yourModel->load_shipper_discription = json_encode($shipper_description);
            $yourModel->load_shipper_commodity_type = json_encode($shipper_commodity_type);
            $yourModel->load_shipper_qty = json_encode($shipper_qty);
            $yourModel->load_shipper_weight = json_encode($shipper_weight);
            $yourModel->load_shipper_commodity = json_encode($shipper_commodity_name);
            $yourModel->load_shipper_value = json_encode($shipper_value);
            $yourModel->load_shipper_shipping_notes = json_encode($shipper_note);
            $yourModel->load_shipper_po_numbers = json_encode($shipper_po_number);
            $yourModel->load_shipper_contact = json_encode($shipper_contact);
            $yourModel->load_shipper_appointment = json_encode($shipper_appointment);
        
            $yourModel->load_consignee = json_encode($consignee_name);
            $yourModel->load_consignee_location = json_encode($consignee_location);
            $yourModel->load_consignee_appointment = json_encode($load_consignee_appointment);
            $yourModel->load_consignee_discription = json_encode($consignee_description);
            $yourModel->load_consignee_type = json_encode($consignee_commodity_type);
            $yourModel->load_consignee_commodity = json_encode($consignee_commodity_name);
            $yourModel->load_consignee_qty = json_encode($consignee_qty);
            $yourModel->load_consignee_weight = json_encode($consignee_weight);
            $yourModel->load_consignee_value = json_encode($consignee_value);
            $yourModel->load_consignee_po_numbers = json_encode($consignee_po_number);
            $yourModel->load_consignee_delivery_notes = json_encode($consignee_delivery_note);
            $yourModel->load_consignee_contact = json_encode($load_consignee_contact) ?? '';
            $yourModel->load_consigneer_notes = json_encode($load_consignee_notes);

            $customer_data = Customer::where('id', $request->input('load_bill_to'))->first();

            $yourModel->user_id = Auth::id();
            $yourModel->load_bill_to = $request->input('load_bill_to', null);
            $yourModel->customer_id = $request->input('customer_id', null);
            $yourModel->load_dispatcher = Auth::user()->name;
            $yourModel->load_status = $request->input('load_status') ?? '';
            $yourModel->load_workorder = $request->input('load_workorder') ?? '';
            $yourModel->load_payment_type = $request->input('load_payment_type') ?? '';
            $yourModel->load_type = $request->input('load_type') ?? '';
            $yourModel->load_shipper_rate = $request->input('load_shipper_rate') ?? '';
            $yourModel->load_pds = $request->input('load_pds') ?? '';
            $yourModel->load_fsc_rate = $request->input('load_fsc_rate') ?? '';
            $yourModel->load_telephone = $request->input('load_telephone') ?? '';
            $yourModel->shipper_load_other_charge = $request->input('shipper_load_other_charge') ?? '';

            $finalRate = (float) $request->input('shipper_load_final_rate');

            // ✅ Validate first
            if ($finalRate == 0) {
                return back()->with('error', "Customer load final rate cannot be 0.");
            }

            // ✅ Then assign
            $yourModel->shipper_load_final_rate = $finalRate;
            
            $yourModel->load_carrier = $request->input('load_carrier') ?? '';
            $yourModel->load_carrier_phone = $request->input('load_carrier_phone') ?? '';
            $yourModel->load_advance_payment = $request->input('load_advance_payment') ?? '';
            $yourModel->load_type_two = $request->input('load_type_two') ?? '';
            $yourModel->load_billing_type = $request->input('load_billing_type') ?? '';
            $yourModel->load_mc_no = $request->input('load_mc_no') ?? '';
            $yourModel->load_equipment_type = $request->input('load_equipment_type') ?? '';
            $yourModel->load_carrier_fee = $request->input('load_carrier_fee') ?? '';
            $yourModel->load_currency = $request->input('load_currency') ?? '';
            $yourModel->load_pds_two = $request->input('load_pds_two') ?? '';
            $yourModel->load_billing_fsc_rate = $request->input('load_billing_fsc_rate') ?? '';
            $yourModel->load_final_carrier_fee = $request->input('load_final_carrier_fee') ?? 0;
            $yourModel->load_other_charge = $request->input('load_other_charge') ?? '';
            $yourModel->comment = $request->input('comment') ?? '';
            $yourModel->invoice_number = '';
            $yourModel->invoice_date = '0000-00-00';
            $yourModel->load_carrier_due_date = '';
            $yourModel->carrier_mark_as_paid = '';
            $yourModel->receiving_amount = '';
            $yourModel->remaining_amount = '';
            $yourModel->carrierDoc = '';
            $yourModel->quick_pay = '';
            $yourModel->payment_method = '';
            $yourModel->ready_to_pay	 = '';
            $yourModel->cpr_check = 'Not Approved';
            $yourModel->customer_refrence_number = $request->input('customer_refrence_number') ?? '';
            $yourModel->carrier_dot = $request->input('carrier_dot') ?? '';
            $yourModel->carrier_id = $request->input('carrier_id') ?? '';
            $yourModel->cmt_agent = $request->input('cmt_agent') ?? '';
            
            // $yourModel->remaining_credit =  '';

            if ($request->hasFile('load_delivery_do_file')) {
                $file = $request->file('load_delivery_do_file');
                if ($file->isValid()) {
                    $filename = $request->input('load_bill_to') . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('public/upload/delivery-order', $filename);
                    $yourModel->load_delivery_do_file = 'upload/delivery-order/' . $filename; // Save the relative path
                } else {
                    return back()->withErrors(['load_delivery_do_file' => 'Uploaded file is not valid.']);
                }
            }

            $shipperCharges = [];
            foreach ($request->shipperchargeType as $index => $chargeType) {
                $chargeAmount = $request->shipperchargeAmount[$index];
                $shipperCharges[] = [
                    'type' => $chargeType,
                    'amount' => $chargeAmount,
                ];
            }

            $carrierCharges = [];
            foreach ($request->shipper_type_charge as $index => $carrierchargeType) {
                $carrierchargeAmount = $request->shipper_other_charge[$index];
                $carrierCharges[] = [
                    'type' => $carrierchargeType,
                    'amount' => $carrierchargeAmount,
                ];
            }
            $yourModel->carrier_load_other_charge = json_encode($carrierCharges);

            $yourModel->shipper_load_other_charge = json_encode($shipperCharges);
            
            // echo "<pre>"; print_r   ($yourModel); die();  

            $yourModel->save();
            
            $insertedId = $yourModel->id;
            $yourModel->load_number = $insertedId;

            $yourModel->save();

            $customer = Customer::find($yourModel->customer_id);
            if ($customer) {
                $customer->remaining_credit -= $yourModel->shipper_load_final_rate;
                $customer->remaining_credit_amount = $customer->adv_customer_credit_limit; // Update remaining credit
                $customer->save();
            }


            $subject = "Broker Create the Load, loadid:-".$insertedId;
            $id = $customer->id ?? $request->input('id') ?? null;
            addToLog($customerId ='', $id, $subject, $oldData ='', $newData ='');

        
            return redirect()->back()->with('success', 'Load has been created successfully!');
    }

    public function BrokerLoadUpdate(Request $request, $id)
    {


for ($i = 1; $i <= 15; $i++) {

    $shipper = $request->input("load_shipper_appointment_{$i}");
    $consignee = $request->input("load_consignee_appointment_{$i}");

    if ($shipper) {
        $shipperDate = Carbon::parse($shipper);

        $shipper_appointment[] = [
            'appointment' => $shipper
        ];
    }

    if ($consignee) {

        $consigneeDate = Carbon::parse($consignee);

        if (isset($shipperDate) && $consigneeDate->lt($shipperDate)) {

            return redirect()->back()
                ->with('error', "Delivery date cannot be earlier than Pickup date (Row {$i}).")
                ->withInput();
        }

        $load_consignee_appointment[] = [
            'appointment' => $consignee
        ];
    }
}
      
        $load = Load::findOrFail($id);

        $oldData = json_encode($load);

        $exsistcarrier = External::where('carrier_name', $request->input('load_carrier'))
            ->where('carrier_mc_ff_input', $request->input('load_mc_no'))
            ->first();
        if (empty($exsistcarrier)) {
            return redirect()->back()->with('error', 'Carrier Not Found');
        }

        if ($request->input('load_final_carrier_fee') > $request->input('shipper_load_final_rate')) {
            return redirect()->back()->with('error', 'Carrier rate cannot exceed the Customer Final Rate');
        }

        $shipper_name = [];
        $shipper_location = [];
        $shipper_description = [];
        $shipper_appointment = [];
        $shipper_type = [];
        $shipper_commodity_name = [];
        $shipper_qty = [];
        $shipper_weight = [];
        $shipper_value = [];
        $shipper_note = [];
        $shipper_po_number = [];
        $shipper_contact = [];
        $shipper_delivery_note = [];

        for ($i = 1; $i <= 15; $i++) { // Assuming a maximum of 15 shippers
            if ($request->has("load_shipper_{$i}")) {
                
				$name = $request->input("load_shipper_{$i}") ?? ' ';
				
				$shipper_name[] = [
					'name' => $name
				];
            }

            if ($request->has("load_shipper_location_{$i}")) {
                
				$location = $request->input("load_shipper_location_{$i}") ?? ' ';
				
				$shipper_location[] = [
					'location' => $location
				];
            }

            if ($request->has("load_shipper_appointment_{$i}")) {
               
				$appointment = $request->input("load_shipper_appointment_{$i}") ?? null;
				
				$shipper_appointment[] = [
					'appointment' => $appointment
				];
            }
            if ($request->has("load_shipper_commodity_type_{$i}")) {
                
				$commodity_type = $request->input("load_shipper_commodity_type_{$i}") ?? ' ';
				
				$shipper_type[] = [
					'commodity_type' => $commodity_type
				];
            }

            if ($request->has("load_shipper_description_{$i}")) {
                
				$description = $request->input("load_shipper_description_{$i}") ?? ' ';
				
				$shipper_description[] = [
					'description' => $description
				];
            }

            if ($request->has("load_shipper_commodity_{$i}")) {
                
				$commodity = $request->input("load_shipper_commodity_{$i}") ?? ' ';
				
				$shipper_commodity_name[] = [
					'commodity' => $commodity
				];
            }

            if ($request->has("load_shipper_qty_{$i}")) {
                
				$qty = $request->input("load_shipper_qty_{$i}") ?? ' ';
				
				$shipper_qty[] = [
					'qty' => $qty
				];
            }

            if ($request->has("load_shipper_weight_{$i}")) {
                
				$weight = $request->input("load_shipper_weight_{$i}") ?? ' ';
				
				$shipper_weight[] = [
					'weight' => $weight
				];
            }

            if ($request->has("load_shipper_value_{$i}")) {
                
				
				$value = $request->input("load_shipper_value_{$i}") ?? ' ';
				
				$shipper_value[] = [
					'value' => $value
				];
            }

            if ($request->has("load_shipper_delivery_notes_{$i}")) {
                
				$delivery_notes = $request->input("load_shipper_delivery_notes_{$i}") ?? ' ';
				
				$shipper_delivery_note[] = [
					'delivery_notes' => $delivery_notes
				];
            }

            if ($request->has("load_shipper_po_numbers_{$i}")) {
                
				$po_number = $request->input("load_shipper_po_numbers_{$i}") ?? ' ';
				
				$shipper_po_number[] = [
					'po_number' => $po_number
				];
            }

            if ($request->has("load_shipper_contact_{$i}")) {
                				
				$contact = $request->input("load_shipper_contact_{$i}") ?? ' ';
				
				$shipper_contact[] = [
					'contact' => $contact
				];
            }

			if ($request->has("load_shipper_shipping_notes_{$i}")) {
				$note = $request->input("load_shipper_shipping_notes_{$i}") ?? ' ';
				
				$shipper_note[] = [
					'shipping_notes' => $note
				];
			}
        }
		

        // Loop through the request to extract shipper data
        foreach ($request->all() as $key => $value) {
            // Assuming shipper fields are structured similarly to consignee fields
            if (preg_match('/^load_shipper(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $shipper_name[$index]['name'] = $value;
            } elseif (preg_match('/^load_shipper_location(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $shipper_location[$index]['location'] = $value;
            } elseif (preg_match('/^load_shipper_description(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $shipper_description[$index]['description'] = $value;
            } elseif (preg_match('/^load_shipper_appointment(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $shipper_appointment[$index]['appointment'] = $value;
            } elseif (preg_match('/^load_shipper_commodity_type(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $shipper_type[$index]['commodity_type'] = $value;
            } elseif (preg_match('/^load_shipper_commodity(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $shipper_commodity_name[$index]['shipper_commodity'] = $value;
            } elseif (preg_match('/^load_shipper_qty(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $shipper_qty[$index]['shipper_qty'] = $value;
            } elseif (preg_match('/^load_shipper_weight(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $shipper_weight[$index]['shipper_weight'] = $value;
            } elseif (preg_match('/^load_shipper_value(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $shipper_value[$index]['shipper_value'] = $value;
            } elseif (preg_match('/^load_shipper_delivery_notes(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $shipper_delivery_note[$index]['shipper_delivery_notes'] = $value;
            } elseif (preg_match('/^load_shipper_po_numbers(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $shipper_po_number[$index]['shipper_po_number'] = $value;
            } elseif (preg_match('/^load_shipper_contact(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $shipper_contact[$index]['shipper_contact'] = $value;
            } elseif (preg_match('/^load_shipper_notes(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $shipper_note[$index]['shipper_notes'] = $value;
            }


            elseif (preg_match('/^load_consignee(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_name[$index]['name'] = $value;
            } elseif (preg_match('/^load_consignee_location(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_location[$index]['location'] = $value;
            } elseif (preg_match('/^load_consignee_description(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_description[$index]['description'] = $value;
            } elseif (preg_match('/^load_consignee_appointment(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $load_consignee_appointment[$index]['appointment'] = $value;
            } elseif (preg_match('/^load_consignee_type(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_commodity_type[$index]['consignee_type'] = $value;
            } elseif (preg_match('/^load_consignee_commodity(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_commodity_name[$index]['consignee_commodity'] = $value;
            } elseif (preg_match('/^load_consignee_qty(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_qty[$index]['consignee_qty'] = $value;
            } elseif (preg_match('/^load_consignee_weight(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_weight[$index]['consignee_weight'] = $value;
            } elseif (preg_match('/^load_consignee_value(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_value[$index]['consignee_value'] = $value;
            } elseif (preg_match('/^load_consignee_delivery_notes(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_delivery_note[$index]['consignee_delivery_notes'] = $value;
            } elseif (preg_match('/^load_consignee_po_numbers(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $consignee_po_number[$index]['consignee_po_number'] = $value;
            } elseif (preg_match('/^load_consignee_contact(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $load_consigneer_contact[$index]['consignee_contact'] = $value;
            } elseif (preg_match('/^load_consignee_notes(\d*)$/', $key, $matches)) {
                $index = $matches[1] ?: 0;
                $load_consignee_notes[$index]['load_consignee_notes'] = $value;
            }
      
        }


        // Handle consignee data
        $consignee_name = [];
        $consignee_location = [];
        $load_consignee_appointment = [];
        $consignee_description = [];
        $load_consignee_type = [];
        $consignee_commodity_name = [];
        $consignee_qty = [];
        $consignee_weight = [];
        $consignee_value = [];
        $consignee_note = [];
        $consignee_po_number = [];
        $consignee_contact = [];
        $consignee_delivery_note = [];
        $load_consignee_commodity = [];
        $load_consigneer_contact = [];


        for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
            if ($request->has("load_consignee_{$i}")) {
               
				$name = $request->input("load_consignee_{$i}") ?? ' ';
				
				$consignee_name[] = [
					'name' => $name
				];
            }
        }

        for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
            if ($request->has("load_consignee_location_{$i}")) {
                
				$location = $request->input("load_consignee_location_{$i}") ?? ' ';
				
				$consignee_location[] = [
					'location' => $location
				];
            }
        }

        for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
            if ($request->has("load_consignee_appointment_{$i}")) {
                
				$appointment = $request->input("load_consignee_appointment_{$i}") ?? null;
				
				$load_consignee_appointment[] = [
					'appointment' => $appointment
				];
            }
        }

        for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
            if ($request->has("load_consignee_description_{$i}")) {
                
				$description = $request->input("load_consignee_description_{$i}") ?? ' ';
				
				$consignee_description[] = [
					'description' => $description
				];
            }
        }

        for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
            if ($request->has("load_consignee_commodity_{$i}")) {
                
				$consignee_commodity = $request->input("load_consignee_commodity_{$i}") ?? ' ';
				
				$load_consignee_commodity[] = [
					'consignee_commodity' => $consignee_commodity
				];
            }
        }

        for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
            if ($request->has("load_consignee_type_{$i}")) {
               				
				$consignee_type = $request->input("load_consignee_type_{$i}") ?? ' ';
				
				$load_consignee_type[] = [
					'consignee_type' => $consignee_type
				];
            }
        }


        for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
            if ($request->has("load_consignee_qty_{$i}")) {
                				
				$consignee_qtys = $request->input("load_consignee_qty_{$i}") ?? ' ';
				
				$consignee_qty[] = [
					'consignee_qty' => $consignee_qtys
				];
            }
        }


        for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
            if ($request->has("load_consignee_weight_{$i}")) {
                
				$consignee_weights = $request->input("load_consignee_weight_{$i}") ?? ' ';
				
				$consignee_weight[] = [
					'consignee_weight' => $consignee_weights
				];
            }
        }

        for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
            if ($request->has("load_consignee_value_{$i}")) {
                
				$consignee_values = $request->input("load_consignee_value_{$i}") ?? ' ';
				
				$consignee_value[] = [
					'consignee_value' => $consignee_values
				];
            }
        }

        
        for ($i = 1; $i <= 15; $i++) {
			if ($request->has("load_consignee_notes_{$i}")) {
				$note = $request->input("load_consignee_notes_{$i}") ?? ' ';
				
				$consignee_note[] = [
					'load_consignee_notes' => $note
				];
			}
		}

        for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
            if ($request->has("load_consignee_po_numbers_{$i}")) {
                
				$consignee_po_numbers = $request->input("load_consignee_po_numbers_{$i}") ?? ' ';
				
				$consignee_po_number[] = [
					'consignee_po_number' => $consignee_po_numbers
				];
            }
        }

        for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
            if ($request->has("load_consignee_contact_{$i}")) {
                
				$consignee_contact = $request->input("load_consignee_contact_{$i}") ?? ' ';
				
				$load_consigneer_contact[] = [
					'consignee_contact' => $consignee_contact
				];
            }
        }

        for ($i = 1; $i <= 15; $i++) { // Assuming there are up to 2 consignees based on your form
            if ($request->has("load_consignee_delivery_notes_{$i}")) {
                
				$consignee_delivery_note = $request->input("load_consignee_delivery_notes_{$i}") ?? ' ';
				
				$load_consigneer_contact[] = [
					'consignee_delivery_notes' => $consignee_delivery_note
				];
            }
        }

        $load->load_shipperr = json_encode($shipper_name);
        $load->load_shipper_location = json_encode($shipper_location);
        $load->load_shipper_appointment = json_encode($shipper_appointment);
        $load->load_shipper_discription = json_encode($shipper_description);
        $load->load_shipper_commodity_type = json_encode($shipper_type);
        $load->load_shipper_commodity = json_encode($shipper_commodity_name);
        $load->load_shipper_qty = json_encode($shipper_qty);
        $load->load_shipper_weight = json_encode($shipper_weight);
        $load->load_shipper_value = json_encode($shipper_value);
        // $load->load_shipper_shipping_notes = json_encode($shipper_delivery_note);
        $load->load_shipper_po_numbers = json_encode($shipper_po_number);
        $load->load_shipper_contact = json_encode($shipper_contact);
        $load->load_shipper_shipping_notes = json_encode($shipper_note);

        $load->load_consignee = json_encode($consignee_name);
        $load->load_consignee_location = json_encode($consignee_location);
        $load->load_consignee_appointment = json_encode($load_consignee_appointment);
        $load->load_consignee_discription = json_encode($consignee_description);
        $load->load_consignee_type = json_encode($load_consignee_type);
        $load->load_consignee_commodity = json_encode($load_consignee_commodity);
        $load->load_consignee_qty = $consignee_qty ? json_encode($consignee_qty) : '0';
        $load->load_consignee_weight = json_encode($consignee_weight);
        $load->load_consignee_value = json_encode($consignee_value);
        $load->load_consigneer_notes = json_encode($consignee_note);
        $load->load_consignee_po_numbers = json_encode($consignee_po_number);
        $load->load_consignee_contact = json_encode($load_consigneer_contact);
        $load->load_consignee_delivery_notes = json_encode($consignee_delivery_note);
        $load->load_consignee_appointment = json_encode($load_consignee_appointment);


        $load->load_bill_to = $request->input('load_bill_to') ?? '';
        $load->load_dispatcher = $request->input('load_dispatcher') ?? '';
        $load->load_status = $request->input('load_status') ?? '';
        $load->load_workorder = $request->input('load_workorder') ?? '';
        $load->load_payment_type = $request->input('load_payment_type') ?? '';
        $load->load_type = $request->input('load_type') ?? '';
        $load->load_shipper_rate = $request->input('load_shipper_rate') ?? '';
        $load->load_pds = $request->input('load_pds') ?? '';
        $load->load_telephone = $request->input('load_telephone') ?? '';
        $load->load_carrier = $request->input('load_carrier') ?? '';
        $load->load_carrier_phone = $request->input('load_carrier_phone') ?? '';
        $load->load_advance_payment = $request->input('load_advance_payment') ?? '';
		
        $load->load_type_two = $request->input('load_type_two') ?? '';
        $load->load_billing_type = $request->input('load_billing_type') ?? '';
        $load->load_mc_no = $request->input('load_mc_no') ?? '';
        $load->load_equipment_type = $request->input('load_equipment_type') ?? '';
        $load->load_carrier_fee = $request->input('load_carrier_fee') ?? '';
        $load->load_currency = $request->input('load_currency') ?? '';
        $load->load_pds_two = $request->input('load_pds_two') ?? '';
        $load->load_billing_fsc_rate = $request->input('load_billing_fsc_rate') ?? '';
        $load->load_final_carrier_fee = $request->input('load_final_carrier_fee') ?? 0;
        $load->load_final_rate = $request->input('shipper_load_final_rate') ?? 0;
        $load->load_other_charge = $request->input('load_other_charge') ?? '';
        $load->shipper_load_final_rate = $request->input('shipper_load_final_rate') ?? 0;
        $load->load_fsc_rate = $request->input('load_fsc_rate') ?? '';
        $load->customer_id = $request->input('customer_id') ?? '';
        $load->comment = $request->input('comment') ?? '';

        $load->customer_refrence_number = $request->input('customer_refrence_number') ?? '';
        $load->carrier_dot = $request->input('carrier_dot') ?? '';
        $load->carrier_id = $request->input('carrier_id') ?? '';
        $load->cmt_agent = $request->input('cmt_agent') ?? '';

        // Initialize shipperCharges array
       $shipperCharges = [];

        if ($request->has('shipperchargeType') && $request->has('shipperchargeAmount')) {
            foreach ($request->shipperchargeType as $index => $chargeType) {

                $chargeAmount = $request->shipperchargeAmount[$index] ?? null;

                // Instead of using for_invoice[$index], check if checkbox is set
				
					$forInvoice = isset($request->for_invoice) && in_array($index, array_keys($request->for_invoice)) ? 'on' : 'off';
                

                if ($chargeAmount !== null) {
                    $shipperCharges[] = [
                        'type' => $chargeType,
                        'for_invoice' => $forInvoice,
                        'amount' => $chargeAmount,
                    ];
                }
            }
        }

      

        // Initialize carrierCharges array
        $carrierCharges = [];
        if ($request->has('shipper_type_charge') && $request->has('shipper_other_charge')) {
            foreach ($request->shipper_type_charge as $index => $carrierchargeType) {
                $carrierchargeAmount = $request->shipper_other_charge[$index] ?? null;
                if ($carrierchargeAmount !== null) {
                    $carrierCharges[] = [
                        'type' => $carrierchargeType,
                        'amount' => $carrierchargeAmount,
                    ];
                }
            }
        }



        $load->carrier_load_other_charge = json_encode($carrierCharges);
        $load->shipper_load_other_charge = json_encode($shipperCharges);


        if ($request->hasFile('load_delivery_do_file')) {
            $file = $request->file('load_delivery_do_file');
            if ($file->isValid()) {
                $filename = $request->input('load_bill_to') . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/upload/delivery-order', $filename);
                $load->load_delivery_do_file = 'upload/delivery-order/' . $filename; // Save the relative path
                $load->save();
            } else {
                return back()->withErrors(['load_delivery_do_file' => 'Uploaded file is not valid.']);
            }
        }

        $invoicechargestotal = 0;

        foreach ($shipperCharges as $item) {
            if (!is_null($item['for_invoice']) && isset($item['for_invoice']) && $item['for_invoice'] == "on") {
                $invoicechargestotal += (float)$item['amount'];
            }
        }


        $invoicechargestotaloff = 0;

        foreach ($shipperCharges as $item) {
            if (!is_null($item['for_invoice']) && isset($item['for_invoice']) && $item['for_invoice'] == "off") {
                $invoicechargestotaloff += (float)$item['amount'];
            }
        }

         
     
        $customerId = $request->customer_id;

        $customerdata = customer::where('id', $customerId)->first();

        $loaddata = Load::findOrFail($id);

        $old_shipper_load_other_charge = json_decode($loaddata->shipper_load_other_charge, true);
        
        $oldinvoicechargestotal = 0;
        if(isset($old_shipper_load_other_charge)){
            foreach ($old_shipper_load_other_charge as $item) {
                if (isset($item['for_invoice']) && !is_null($item['for_invoice']) && $item['for_invoice'] == "on") {
                    $oldinvoicechargestotal += (float)$item['amount'];
                }
            }
        }


        $oldinvoicechargestotaloff = 0;
        if(isset($old_shipper_load_other_charge)){
            foreach ($old_shipper_load_other_charge as $item) {
                if (isset($item['for_invoice']) && !is_null($item['for_invoice']) && $item['for_invoice'] == "off") {
                    $oldinvoicechargestotaloff += (float)$item['amount'];
                }
            }
        }

        $checkinvoice_credit = $invoicechargestotal - $oldinvoicechargestotal;

        $invoice_credit = $oldinvoicechargestotal - $invoicechargestotal;

        $newShipperLoadFinalRate = $request->load_shipper_rate + $invoicechargestotaloff ?? 0;
        $oldShipperLoadFinalRate = $request->old_shipper_load_final_rate ?? 0;
	
        $checkrate = $newShipperLoadFinalRate - $oldShipperLoadFinalRate;
		

        $checkfinalrate = $invoicechargestotaloff - $oldinvoicechargestotaloff;
		
        $rateDifference = $request->shipper_load_final_rate - $oldShipperLoadFinalRate;
        $finalcredit = $checkinvoice_credit - $rateDifference;

        $finalcreditdiff = $rateDifference - $checkinvoice_credit;
      
      
        if ($customerdata && (int) $customerdata->remaining_credit < $finalcreditdiff) {
              
            return redirect()->back()->with('error', 'Customer Final Rate Exceeded the Remaing credit Limit, your credit limit is ' . $customerdata->remaining_credit);
        } else if ($customerdata && (int) $customerdata->invoice_credit_limit < $checkinvoice_credit) {
            return redirect()->back()->with('error', 'Customer Final Rate Exceeded the Invoice credit Limit, your invoice credit limit is ' . $customerdata->invoice_credit_limit);
        } else {
  
       
            // Calculate the difference between old and new rates
            $rateDifference = $oldShipperLoadFinalRate - $request->shipper_load_final_rate;
           
            $finalrate = $rateDifference;

           // $finalremaing = $checkrate - $invoice_credit;


            $customerId = $request->customer_id;
          
            
            if($finalcredit != 0){
                Customer::where('id', $customerId)->update([
                    'remaining_credit' => \DB::raw("remaining_credit + " . (float) $finalcredit),
                ]);
            }

            if ($invoice_credit !== 0) {
                Customer::where('id', $customerId)->update([
                    'invoice_credit_limit' => \DB::raw("invoice_credit_limit + " . (float) $invoice_credit),
                ]);
            }

            if($finalrate !== 0){
                Customer::where('id', $customerId)->update([
                    'remaining_credit_amount' => \DB::raw("remaining_credit_amount + $finalrate"),
                ]);
            }            
            
        }
        
        $load->save();

        $newData = json_encode($load);

        $subject = "Broker Update the Load, loadid:-".$id;
        addToLog($customerId ='', $id, $subject, $oldData, $newData);

        return redirect('broker/load')->with('success', 'Load has been updated successfully!');
    }

    public function fetchCarrierSuggestions(Request $request)
    {
        $field = $request->input('field'); // 'carrier_name', 'mcNumber', 'dotNumber'
        $inputValue = $request->input('inputValue'); 

    $query = External::query()
        ->where('mc_check', 'Approved')
        ->where(function($q) {
            $q->where('carrier_block', 'Unblocked')
            ->orWhereNull('carrier_block');
        });

        ;
        

        if ($field === 'load_carrier') {
            $query->where('carrier_name', 'LIKE', '%' . $inputValue . '%');
        } elseif ($field === 'carrier_mc_ff_input') {
            $query->where('carrier_mc_ff_input', 'LIKE', '%' . $inputValue . '%');
        } elseif ($field === 'carrier_dot') {
            $query->where('carrier_dot', 'LIKE', '%' . $inputValue . '%');
        }

        $carriers = $query->select('id', 'carrier_name', 'carrier_mc_ff_input as mcNumber', 'carrier_dot as dotNumber')
                        ->limit(10)
                        ->get();
        
        return response()->json($carriers);
    }

    public function fetchCarrierDetails(Request $request)
    {
        // Retrieve the carrier ID
        $carrierId = $request->input('carrierId');
    
        // Fetch the carrier based on the ID and ensure it's approved
        $carrier = External::where('id', $carrierId)
                            ->where('mc_check', 'Approved') // Ensure it's an approved carrier
                            ->select('id', 'carrier_name', 'carrier_mc_ff_input as mcNumber', 'carrier_dot as dotNumber', 'carrier_telephone as phone')
                            ->first();
    
        // Return the carrier details as a JSON response
        return response()->json($carrier);
    }

     public function fetchShipperDetailsEdit(Request $request) {
        // Get the 'id' from the input request
        $id = $request->input('id');
        
      
        // Get the user ID from the session data
        $user = Auth::id();
        
        // Fetch the shipper details based on 'id' and 'user_id'
        $shipper = Shipper::select('id', 'shipper_name', 'shipper_address', 'shipper_city', 'shipper_state', 'shipper_country', 'shipper_zip')
                          ->where('id', $id)
                          ->where('user_id', $user)
                          ->first();
        
        // Check if the shipper was found
        if ($shipper) {
            return response()->json($shipper);
        } else {
            return response()->json(['error' => 'Shipper not found'], 404);
        }
    }

     public function fetchShipperDetails(Request $request) {
        $query = $request->input('query');
        $userId = Auth::id();


$shippers = Shipper::where('shipper_name', 'like', '%' . $query . '%')
    ->where('user_id', $userId)
    ->select('shipper_name', 'shipper_address', 'shipper_city', 'shipper_state', 'shipper_country', 'shipper_zip')
    ->orderBy('shipper_name', 'asc') // Sort A to Z
    ->get();


        $datashipper = Shipper::get();                       
        return response()->json($shippers);
    }

    public function fetchConsigneeDetails(Request $request) {
        $query = $request->input('query');
        $userId = Auth::id();

        $query = $request->input('query');
        $consignees = Consignee::where('consignee_name', 'like', '%' . $query . '%')
                                ->where('user_id', $userId)
                                ->select('consignee_name', 'consignee_address', 'consignee_city', 'consignee_state', 'consignee_country', 'consignee_zip')
                                ->get();
        return response()->json($consignees);
    }
    

    public function checkRemaingLimit(Request $request){
       
        $customer_id = $request->input('customer_id');
        $final_rate = $request->input('finalrate');

        $customerdata = Customer::where('id', $customer_id)->first();
        $remaining_limit = $customerdata->remaining_credit;
        if($final_rate > $remaining_limit){
            return response()->json([
                'success' => true,
                'message' => 'You do not have sufficient remaining credit to create the load. Your remaining credit is ' . $remaining_limit
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => '',
            ]);
        }

    }
     public function checkRemaingLimiteditload(Request $request){
       
        $customer_id = $request->input('customer_id');
        $final_rate = $request->input('finalrate');

        $customerdata = Customer::where('id', $customer_id)->first();
        $remaining_limit = $customerdata->remaining_credit;
        if($final_rate > $remaining_limit){
            return response()->json([
                'success' => true,
                'message' => 'You do not have sufficient remaining credit to create the load. Your remaining credit is ' . $remaining_limit
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => '',
            ]);
        }

    }

    public function load_status_update(Request $request)
    {
        $load = Load::find($request->input('load_id'));
        $loadid = $request->input('load_id');
        $load->load_status = $request->input('load_status');
        if ($load->load_status == 'Delivered') {
        $load->load_actual_delivery_date = now();
        }
        $load->save();
        $subject = "Broker change the Load ".$request->input('load_status').", loadid:-".$request->input('load_id');
        addToLog($customerId ='', $loadid, $subject, $oldData ='', $newData ='');
     	return response()->json([
                'success' => true,
                'message' => 'Load status updated successfully'
            ]);
    }
    

    
    /**
     * Store a newly created resource in storage.
     */
public function raiseTickets()
{
    $userId = Auth::id();

    $tickets_open = ItHardware::where('user_id', $userId)
        ->where('status', 'Open')
        ->orderBy('created_at', 'desc')
        ->get();

    $tickets_hold = ItHardware::where('user_id', $userId)
        ->where('status', 'Hold')
        ->orderBy('created_at', 'desc')
        ->get();

    $tickets_completed = ItHardware::where('user_id', $userId)
        ->where('status', 'Completed')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('broker.raise_tickets', compact('tickets_open', 'tickets_hold', 'tickets_completed'));
}

    /**
     * Display the specified resource.
     */
public function raiseTicketStore(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'issues' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|string'
    ]);

    $ticket = new ItHardware();
    $ticket->user_id = Auth::id();
    $ticket->name = $request->name;
    $ticket->email = $request->email;
    $ticket->issues = $request->issues;
    $ticket->description = $request->description;
    $ticket->status = $request->status;
    $ticket->save();

    return back()->with('success', 'Ticket raised successfully!');
}

    public function generateBolPdf($id)
    {
        $load = Load::findOrFail($id);

        $options = new Options();
        $options->set('defaultFont', 'Arial'); // Use a common font
        $options->set('isRemoteEnabled', true); // Enable remote image loading for logo
        $dompdf = new Dompdf($options);

        $html = view('broker.bol_pdf', compact('load'))->render();
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('letter', 'portrait');

        $dompdf->render();

        // Stream the file for download
        return $dompdf->stream("BOL-{$load->load_number}.pdf", ["Attachment" => true]);
    }

    public function generateBolPdfWithEditedData(Request $request, $id)
    {
        $load = Load::findOrFail($id);

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $html = view('broker.bol_pdf', compact('load'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();

        return $dompdf->stream("BOL-{$load->load_number}.pdf", ["Attachment" => true]);
    }

    public function saveBolEditData(Request $request, $id)
    {
        $load = Load::findOrFail($id);
        $load->bol_edit_data = json_encode($request->input('bol_data', []));
        $load->save();

        return response()->json(['success' => true, 'message' => 'BOL data saved.']);
    }

    public function downloadBolPdf(Request $request, $id)
    {
        return $this->generateBolPdf($id);
    }


}
