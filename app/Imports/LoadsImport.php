<?php
namespace App\Imports;

use App\Models\Load;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
class LoadsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
      
      if (empty($row['invoice_date'])) {
            return null;
        }

        // Excel serial date → Carbon
        $timestamp = ($row['invoice_date'] - 25569) * 86400;
        $paymentDate = Carbon::createFromTimestamp($timestamp);

        // ✅ Convert to m-d-Y
        $formattedDate = $paymentDate->format('Y-m-d');

        //Update existing load
        //$load = Load::where('load_number', $row['load_id'])->first();

        //if ($load) {
          //  $load->update([
            //    'invoice_date' => $formattedDate,
            //]);
       // }

        // Prevent creating new records
        return null;
    }
}
