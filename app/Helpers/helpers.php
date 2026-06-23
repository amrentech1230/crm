<?php

use Illuminate\Support\Facades\Request;
use App\Models\Log;
use Symfony\Component\Process\Process;


if (!function_exists('getmacaddress')) {
		
	function getmacaddress()
	{
		$os = PHP_OS_FAMILY;

		if ($os === 'Windows') {
			$command = ['getmac'];
		} elseif ($os === 'Linux' || $os === 'Darwin') {
			// Use 'ip link' for Linux/macOS
			$command = ['sh', '-c', "ip link show | grep ether | awk '{print \$2}'"];
		} else {
			return 'Unsupported OS';
		}  

		$process = new Process($command);
		$process->run();

		if ($process->isSuccessful()) {
			return trim($process->getOutput());
		}

		return 'MAC address not found';
	}
}

function addToLog($customer_id = '', $load_id = '', $subject = '', $old_data = '', $new_data = '')
    {
        // Get the authenticated user
        $user = auth()->user();

        $log = [
            'load_id'     => $load_id,
            'customer_id' => $customer_id,
            'message'     => $subject,
            'user_name'   => $user ? $user->name : null,
            'user_id'     => $user ? $user->id : null,
            'user_email'  => $user ? $user->email : null,
            'old_json'    => $old_data,
            'new_json'    => $new_data,
            'ip'          => Request::ip(),
            'url'         => Request::fullUrl(),
        ];

        Log::create($log);
    }

    function getdiffrance($old_data, $new_data){
		$array1 = json_decode($old_data, true);
		$array2 = json_decode($new_data, true);

		$diff = [];

		if(!empty($array1) && !empty($array2)){
			$allKeys = array_unique(array_merge(array_keys($array1), array_keys($array2)));

			foreach ($allKeys as $key) {
				$val1 = $array1[$key] ?? null;
				$val2 = $array2[$key] ?? null;

				if (!array_key_exists($key, $array1)) {
					$diff[$key] = ['olddata' => null, 'newdata' => $val2];
				} elseif (!array_key_exists($key, $array2)) {
					$diff[$key] = ['olddata' => $val1, 'newdata' => null];
				} elseif ($val1 !== $val2) {
					$diff[$key] = ['olddata' => $val1, 'newdata' => $val2];
				}
			}
		}

		$output = '';
		// $output .= '<div>
			// <span style="border: 1px solid black !important;">Field</span>
			// <span style="border: 1px solid black !important;">Old Value</span>
			// <span style="border: 1px solid black !important;">New Value</span>
		// </div>';

		foreach ($diff as $key => $diffdata) {
			$rawOld = $diffdata['olddata'];
			$rawNew = $diffdata['newdata'];

			if (in_array($key, ['_token', '_method'])) {
				continue;
			}

			$oldNormalized = is_array($rawOld) ? json_encode($rawOld) : (string) $rawOld;
			$newNormalized = is_array($rawNew) ? json_encode($rawNew) : (string) $rawNew;

			if ($oldNormalized !== $newNormalized && !empty($newNormalized)) {
				
				if($newNormalized != '[]'){
					
					if($newNormalized != '[null]'){
					
						$oldDisplay = is_array($rawOld) ? json_encode($rawOld, JSON_PRETTY_PRINT) : $rawOld;
						$newDisplay = is_array($rawNew) ? json_encode($rawNew, JSON_PRETTY_PRINT) : $rawNew;

						
						$output .= '<span><strong>' . $key . ' :- </strong></span>';
						$output .= '<span>' . $oldDisplay . '</span> To ';
						$output .= '<span>' . $newDisplay . '</span><br>';
					}
					
				}
				
			}
		}
		

		return $output;
	}


