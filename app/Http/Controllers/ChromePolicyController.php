<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Consignee;
use App\Models\Shipper;
use App\Models\External;
use App\Models\Load;
use App\Models\User;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ChromePolicyController extends Controller
{
    public function showToken()
    {
        $path = '/etc/opt/chrome/policies/enrollment/enrollment_token';

        if (File::exists($path)) {
            $token = trim(File::get($path));
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'Token file not found.'], 404);
        }
    }
	
	public function carrierdata(Request $request){
		$loads = Load::select([
				'load_carrier_fee',
				'load_billing_fsc_rate',
				'carrier_load_other_charge',
				'load_final_carrier_fee',
				'load_number'
			])
			->orderBy('load_number', 'asc') // ensure consistent ordering
			->skip(0) // skip the first 5000
			->take(1000)  // take the next 500
			->get();
		
		// ->whereBetween('updated_at', [
			// Carbon::create(2025, 9, 1)->startOfDay(),
			// Carbon::create(2025, 11, 30)->endOfDay() // ✅ fixed invalid Nov 31
		// ])
		//->get();
		
		$count = count($loads);
		echo $count;
		foreach($loads as $key => $load) {
				
				$fsc_amount = 0;

				// Check if both values are numeric
				if (is_numeric($load->load_carrier_fee) && is_numeric($load->load_billing_fsc_rate)) {
					$fsc_amount = ((int) ($load->load_carrier_fee ?? 0) * (int) ($load->load_billing_fsc_rate ?? 0)) / 100;
				}
				
				$assessorials = json_decode($load->carrier_load_other_charge ?? '[]', true); // decode to array

				$total_amount = 0;

				if (!empty($assessorials) && is_array($assessorials)) {
					foreach ($assessorials as $item) {
						
						if (isset($item['amount']) && is_numeric((int)$item['amount'])) {
							$cleanString = str_replace(',', '', $item['amount']);

							$number = (float) $cleanString;
							
							$total_amount += (float)$number;
						}
					}
				}
				//print_r($total_amount);
				

				$final_amount = 0;

				if (is_numeric($load->load_carrier_fee) && is_numeric($fsc_amount) && is_numeric($total_amount)) {
					$final_amount = $load->load_carrier_fee + $fsc_amount + $total_amount;
				}
				$data = array(
					'load_number'               => $load->load_number,
					'load_carrier_fee'          => $load->load_carrier_fee,
					'load_billing_fsc_rate'     => $load->load_billing_fsc_rate,
					'other_charges' => $total_amount,
					'new_final_amount' => $final_amount,
					'final_amount' => $load->load_final_carrier_fee,
				);
				//$amount = rtrim(rtrim($load->load_final_carrier_fee, '0'), '.');
				
				
				//if($final_amount !== (int)$amount){
					echo "<pre>";
					print_r($data);
					echo "</pre>";
				
					 //Load::where('load_number', $load->load_number)->update(['load_final_carrier_fee' => $final_amount]);

					// echo $load->load_number.'<br>';
				//}
			
		}
	
	}
}


?>