<?php

namespace App\Exports;

use App\Models\DealList;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DealExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = Carbon::parse($startDate)->startOfDay();
        $this->endDate = Carbon::parse($endDate)->endOfDay();
    }

    public function collection()
    {

        $dealData = DealList::whereBetween('deal_list.created_at', [$this->startDate, $this->endDate])->leftjoin('product_categories as product', 'product.id', '=', 'deal_list.category_id')
            ->leftjoin('ex_laptop_details as exd', 'exd.id', '=', 'deal_list.ref_id')
            ->leftjoin('users as customer', 'customer.id', '=', 'deal_list.created_by')
            ->leftjoin('deal_status', 'deal_status.id', '=', 'deal_list.status')
            ->leftjoin('brands', 'brands.id', '=', 'exd.brand_id')
            ->whereNotIn('deal_list.created_by', [0])
            ->orderBy('deal_list.created_at', 'desc')
            ->get([
                'deal_list.tracking_no',
                'deal_list.created_at',
                'customer.phone as phone',
                'customer.name as customerName',
                'product.name as product',
                'deal_status.status_name',
                'deal_list.estimated_price',
                'brands.name as brandName',
                'exd.details_json',
            ]);

        $downloadData = [];
        foreach ($dealData as $deal) {
            $dealDetails = json_decode($deal->details_json);
            $detailsString = '';
            $productStatus = '';
            if (!empty($dealDetails->model)) {
                $detailsString .= 'Model: ' . $dealDetails->model   ;
            }

            if (!empty($dealDetails->processor)) {
                $detailsString .= ' Processor: ' . explode('@', $dealDetails->processor)[1];
            }
            if (!empty($dealDetails->display)) {
                $detailsString .= ' Display: ' . explode('@', $dealDetails->display)[1];
            }
            if (!empty($dealDetails->ram)) {
                $detailsString .= ' RAM: ' . explode('@', $dealDetails->ram)[1];
            }

            if (!empty($dealDetails->storage)) {
                $detailsString .= ' Storage: ' . explode('@', $dealDetails->storage)[1];
            }
            if (!empty($dealDetails->laptoppower)) {
                $productStatus .= ' Power: ' . $dealDetails->laptoppower;
            }
            if (!empty($dealDetails->storagestatus)) {
                $productStatus .= ' Storage: ' . $dealDetails->storagestatus;
            }
            if (!empty($dealDetails->ramstatus)) {
                $productStatus .= ' Ram: ' . $dealDetails->ramstatus;
            }
            if (!empty($dealDetails->displaystatus)) {
                $productStatus .= ' Display: ' . $dealDetails->displaystatus;
            }
            $deal->product_details = $detailsString;
            $deal->product_status = $productStatus;

            unset($deal->details_json);

        }


        return $dealData;
    }

    public function headings(): array
    {
        return [
            'Tracking NO',
            'Submission Date',
            'Phone',
            'Name',
            'Product',
            'Status',
            'Price Given',
            'Brand',
            'Deal Details',
            'Component Status',
// Add more headings as needed
        ];
    }
}
