<?php

namespace App\Http\Controllers;

use App\Factories\SaleFactory;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|mimetypes:text/plain'
        ]);
        $rows = FileHelper::splitByRow($request->file);
        $sales = [];
        foreach ($rows as $row) {
            if (!empty($row)) {
                $array = FileHelper::splitBySizes($row);
                list($id, $date, $amount, $totalInstallments, $customerName, $customerCep) = $array;
                $sale = SaleFactory::create($id, $date, $amount, $totalInstallments, $customerName, $customerCep);
                array_push($sales, $sale);
            }
        }

       return response()->json(['sales' => $sales]);
    }
}
