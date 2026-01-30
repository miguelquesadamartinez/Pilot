<?php

namespace App\Http\Controllers;

use App\Helpers\SearchHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Ecommerce\Order;
use App\Models\Ecommerce\OrderDetail;
use Illuminate\Support\Facades\App;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class LaphalController extends Controller
{
    public function main(){ 
        SearchHelper::UsersActions();        
        return view('admin.laphal.main'); 
    }
    public function sendFile(Request $request) {
        SearchHelper::UsersActions();
        $request->validate([
            'laphal_file' => 'required',
            'search_date_init' => 'required',
            'search_date_end' => 'required',
        ]);
        $fileOrderNums = Array();
        if ($request->hasFile('laphal_file')) {
            $file = $request->file('laphal_file');
            if (!$file->isValid() || !in_array($file->getClientOriginalExtension(), ['xls', 'xlsx'])) {
                return response()->json(['error' => 'El archivo debe ser de tipo XLS o XLSX.'], 400);
            }
            $spreadsheet = IOFactory::load($file->getPathName());
            $writer = IOFactory::createWriter($spreadsheet, 'Csv');
            $writer->setDelimiter(';');
            $csvFileName = storage_path('app/converts/'.$file->getClientOriginalName().'.csv');
            $writer->save($csvFileName);
            //if (($handle = fopen($file->getPathName(), "r")) !== FALSE) {
            if (($handle = fopen(storage_path('app/converts/'.$file->getClientOriginalName().'.csv'), "r")) !== FALSE) {
                while (($line = fgetcsv($handle, null, ";")) !== FALSE) {
                    //if (preg_match('/^00000000/', $line[15])) {
                    if (strpos($line[15], "00000000") === 0) {
                        $orderNum = intval(preg_replace('/^0+/', '', $line[15]));
                        $fileOrderNums[$orderNum] = $orderNum;
                    }
                }
            }
        }
        //$dateFrom = date(app('global_format_date'), strtotime($request->search_date_init)) . ' 00:00:00';
        //$dateTo = date(app('global_format_date'), strtotime($request->search_date_end)) . ' 23:59:59';
        //$dateFrom = date('Y-d-m', strtotime($request->search_date_init)) . ' 00:00:00';
        //$dateTo = date('Y-d-m', strtotime($request->search_date_end)) . ' 23:59:59';
        $dateFrom = date('Y-m-d', strtotime($request->search_date_init));
        $dateTo = date('Y-m-d', strtotime($request->search_date_end));
        if (count($fileOrderNums) >= 2000 && count($fileOrderNums) <= 4000) {
            $chunks = array_chunk($fileOrderNums, 2000);
            $dsmOrdersNotInFile_one = Order::where('laboratory_name', '=', 'DSM')
                                    ->where('status', '=', 'confirmed')
                                    ->whereNotIn('reference', $chunks[0])
                                    ->whereBetween('desired_delivery_date', [$dateFrom, $dateTo])
                                    ->whereNotNull('treatment_date')
                                    ->get();
            $dsmOrdersNotInFile_two = Order::where('laboratory_name', '=', 'DSM')
                                    ->where('status', '=', 'confirmed')
                                    ->whereNotIn('reference', $chunks[1])
                                    ->whereBetween('desired_delivery_date', [$dateFrom, $dateTo])
                                    ->whereNotNull('treatment_date')
                                    ->get();
            $dsmOrdersNotInFile = $dsmOrdersNotInFile_one->intersect($dsmOrdersNotInFile_two);
        } else if (count($fileOrderNums) > 4000 && count($fileOrderNums) <= 6000) {
            $chunks = array_chunk($fileOrderNums, 2000);
            $dsmOrdersNotInFile_one = Order::where('laboratory_name', '=', 'DSM')
                                    ->where('status', '=', 'confirmed')
                                    ->whereNotIn('reference', $chunks[0])
                                    ->whereBetween('desired_delivery_date', [$dateFrom, $dateTo])
                                    ->whereNotNull('treatment_date')
                                    ->get();
            $dsmOrdersNotInFile_two = Order::where('laboratory_name', '=', 'DSM')
                                    ->where('status', '=', 'confirmed')
                                    ->whereNotIn('reference', $chunks[1])
                                    ->whereBetween('desired_delivery_date', [$dateFrom, $dateTo])
                                    ->whereNotNull('treatment_date')
                                    ->get();
            $dsmOrdersNotInFile_three = Order::where('laboratory_name', '=', 'DSM')
                                    ->where('status', '=', 'confirmed')
                                    ->whereNotIn('reference', $chunks[2])
                                    ->whereBetween('desired_delivery_date', [$dateFrom, $dateTo])
                                    ->whereNotNull('treatment_date')
                                    ->get();
            $dsmOrdersNotInFile = $dsmOrdersNotInFile_one->intersect($dsmOrdersNotInFile_two)->intersect($dsmOrdersNotInFile_three);             
        } else if (count($fileOrderNums) > 6000 && count($fileOrderNums) <= 8000) {
            $chunks = array_chunk($fileOrderNums, 2000);
            $dsmOrdersNotInFile_one = Order::where('laboratory_name', '=', 'DSM')
                                    ->where('status', '=', 'confirmed')
                                    ->whereNotIn('reference', $chunks[0])
                                    ->whereBetween('desired_delivery_date', [$dateFrom, $dateTo])
                                    ->whereNotNull('treatment_date')
                                    ->get();
            $dsmOrdersNotInFile_two = Order::where('laboratory_name', '=', 'DSM')
                                    ->where('status', '=', 'confirmed')
                                    ->whereNotIn('reference', $chunks[1])
                                    ->whereBetween('desired_delivery_date', [$dateFrom, $dateTo])
                                    ->whereNotNull('treatment_date')
                                    ->get();
            $dsmOrdersNotInFile_three = Order::where('laboratory_name', '=', 'DSM')
                                    ->where('status', '=', 'confirmed')
                                    ->whereNotIn('reference', $chunks[2])
                                    ->whereBetween('desired_delivery_date', [$dateFrom, $dateTo])
                                    ->whereNotNull('treatment_date')
                                    ->get();
            $dsmOrdersNotInFile_four = Order::where('laboratory_name', '=', 'DSM')
                                    ->where('status', '=', 'confirmed')
                                    ->whereNotIn('reference', $chunks[3])
                                    ->whereBetween('desired_delivery_date', [$dateFrom, $dateTo])
                                    ->whereNotNull('treatment_date')
                                    ->get();
            $dsmOrdersNotInFile = $dsmOrdersNotInFile_one->intersect($dsmOrdersNotInFile_two)->intersect($dsmOrdersNotInFile_three)->intersect($dsmOrdersNotInFile_four);             
        } else {
            $dsmOrdersNotInFile = Order::where('laboratory_name', '=', 'DSM')
                                    ->where('status', '=', 'confirmed')
                                    ->whereNotIn('reference', $fileOrderNums)
                                    ->whereBetween('desired_delivery_date', [$dateFrom, $dateTo])
                                    ->whereNotNull('treatment_date')
                                    ->get();
        }
        unlink(App::basePath() . "\\storage\\app\\converts\\" .$file->getClientOriginalName().'.csv');
        $dsmOrdersNotInFileArray = Array();
        foreach($dsmOrdersNotInFile as $order){
            $total = 0;
            $subtotal = 0;
            $dsmOrdersNotInFileArray[$order->reference]['reference'] = $order->reference ;
            $dsmOrdersNotInFileArray[$order->reference]['pharmacy name'] = $order->pharmacy->name ;
            $dsmOrdersNotInFileArray[$order->reference]['pharmacy cip'] = $order->pharmacy->cip ;
            $dsmOrdersNotInFileArray[$order->reference]['date'] = Carbon::parse($order->updated_at)->format('d/m/Y') ;
            $items = OrderDetail::where('order_id', '=', $order->id)->get();
            foreach($items as $item){
                $subtotal = $item->price * $item->quantity - (($item->price * $item->quantity) * ($item->discount / 100));
                $total += $subtotal;
            }
            $dsmOrdersNotInFileArray[$order->reference]['amount'] = number_format($total, 2) ;
            $dsmOrdersNotInFileArray[$order->reference]['delivery date'] = Carbon::parse($order->desired_delivery_date)->format('d/m/Y') ;
            $dsmOrdersNotInFileArray[$order->reference]['treatment date'] = Carbon::parse($order->treatment_date)->format('d/m/Y') ;
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('DSM ecommerce orders');
        $headers = ['Order reference', 'Pharmacy name', 'Pharmacy cip', 'Date', 'Amount', 'Delivery date', 'Treatment date'];
        $sheet->fromArray($headers, NULL, 'A1');
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->fromArray($dsmOrdersNotInFileArray, NULL, 'A2');
        $fileName = 'DSM ecommerce orders not in Laphal file from '.$request->search_date_init.' to '.$request->search_date_end.'.xls';
        $writer = new Xls($spreadsheet);
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Cache-Control' => 'max-age=0',
        ]);
        //if(count($dsmOrdersNotInFile)) { $noResults = false; } else { $noResults = true; }
        //return Excel::download(new DsmOrdersExportArray($dsmOrdersNotInFileArray), 'Orders not in DSM file from '.$dateFrom.' to '.$dateTo.'.xls');
        //return Excel::download(new DsmOrdersExport($dsmOrdersNotInFile), 'Orders not in DSM file from '.$dateFrom.' to '.$dateTo.'.xls');
        //$fileName = $file->getClientOriginalName();
        //return view('admin.laphal.main', compact('dsmOrdersNotInFile', 'noResults', 'dateFrom', 'dateTo', 'fileName'));
    }
}
