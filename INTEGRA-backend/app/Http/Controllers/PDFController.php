<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\marketing\Campaign;
use App\Models\Repository\Export;
use App\Models\Repository\ExportProductDetail;
use App\Models\Repository\ImportProductDetail;
use App\Models\Repository\Import;
use App\Models\HR\Employee;
use App\Models\PDFFile;
use PDF;
use App\Http\Resources\PDFCollection;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class PDFController extends Controller
{

    public function index() {

        $allowedTypes = [];

        $user = JWTAuth::toUser(JWTAuth::getToken());

        if ($user->hasPermissionTo("Marketing")) {
            $allowedTypes[] = Campaign::class;
        }

        if ($user->hasPermissionTo("HR")) {
            $allowedTypes[] = Employee::class;
        }

        if ($user->hasPermissionTo("Repository")) {
            $allowedTypes[] = Export::class;
            $allowedTypes[] = Import::class;
        }

        $results = PDFFile::whereIn('pdfable_type', $allowedTypes)->get();
        return new PDFCollection($results);
    }

    public function storeCampaign($id){
        $campaign = Campaign::find($id);
        $data = [
            'title' => $campaign->name,
            'date' => date('m/d/Y'),
            'campaign' => $campaign,
            'SM' => $campaign->socialmedia,
            'TV' => $campaign->tvs,
            'EV' => $campaign->events,
            'LE' => $campaign->leads,
        ];

        $pdf = PDF::loadView('MarketingPDF', $data);
        $content = $pdf->download('CampaignPDF' . '.pdf');

        PDFFile::create([
            'name' => $campaign->name,
            'content' => $content,
            'pdfable_id' => $campaign->id,
            'pdfable_type' => Campaign::class,
        ]);

        return response($content)
               ->header('Content-Type', 'application/pdf')
               ->header('Content-Disposition', 'attachment; filename="' . 'CampaignPDF' . '.pdf"');
    }

    public function storeExport($id){

        $export = Export::find($id)->join('employees'  , 'exports.employee_id', '=', 'employees.id')
                                   ->join('customers', 'exports.customer_id', '=', 'customers.id')
                                   ->select( 'employees.firstName  as employee_name'
                                            ,'customers.name as customer_name'
                                            ,'exports.name as export_name' ,'exports.date' ,'exports.total_amount' ,'exports.id')
                                   ->where('exports.id', $id)->first();

       $export_product = ExportProductDetail::query();
       $export_product = $export_product->where('export_id', $id);
       $export_product = $export_product->join('product_details', 'product_details.id', '=', 'export_product.product_details_id')
                                        ->join('products', 'products.id', '=', 'product_details.product_id')
                                        ->select('export_product.quantity', 'export_product.total_amount',
                                                 'products.name as product_name', 'products.price',
                                                 'product_details.details')
                                        ->get();


        $data    = [
            'title'    => $export->export_name,
            'date'     => date('m/d/Y'),
            'export'   => $export,
            'export_product'  => $export_product

                           ];

        $pdf = PDF::loadView('ExportPDF', $data);
        $content = $pdf->download('ExportPDF' .'.pdf');



        PDFFile::create ([

            'name'          => $export->export_name ,
            'content'       => $content ,
            'pdfable_id'    => $export->id,
            'pdfable_type'  => Export::class,

        ]);

        return response($content)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'attachment; filename="' . 'ExportPDF' . '.pdf"');
    }

    public function storeImport($id){

        $import = Import::join('employees', 'imports.employee_id', '=', 'employees.id')
        ->join('suppliers', 'imports.supplier_id', '=', 'suppliers.id')
        ->select(
            'employees.firstName as employee_name',
            'suppliers.name as supplier_name',
            'imports.name as import_name',
            'imports.date',
            'imports.total_amount',
            'imports.id'
        )
        ->where('imports.id', $id)
        ->first();

        $import_product = ImportProductDetail::query();
        $import_product = $import_product->where('import_id', $id);
        $import_product = $import_product->join('product_details', 'product_details.id', '=', 'import_product.product_details_id')
                                         ->join('products', 'products.id', '=', 'product_details.product_id')
                                         ->select('import_product.quantity', 'import_product.total_amount',
                                                 'products.name as product_name', 'products.price',
                                                 'product_details.details as details')
                                         ->get();


        $data = [
            'title' => $import->name,
            'date' => $import->date,
            'import' => $import,
            'import_product' => $import_product,
        ];

            $pdf = PDF::loadView('ImportPDF', $data);
            $content = $pdf->download('ImportPDF' .'.pdf');

            PDFFile::create ([

                'name'          => $import->import_name,
                'content'       => $content ,
                'pdfable_id'    => $import->id,
                'pdfable_type'  => Import::class,

            ]);

            return response($content)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . 'ImportPDF' . '.pdf"');
    }

    public function storeEmployeeVacation($id){

            $employee = Employee::find($id);
            $name = $employee-> firstName;

            $data = [
                'title' => $name,
                'date' => date('m/d/Y'),
                'employee' => $employee,
                'EP'   =>  $employee->employeeVacations,

            ];

            $pdf = PDF::loadView('employeeVacationPDF', $data);
            $content = $pdf->download('EmployeeVacationPDF'.'.pdf');


            PDFFile::create ([

                'name'          => "Employee Vacation",
                'content'       => $content ,
                'pdfable_id'    => $employee->id,
                'pdfable_type'  => Employee::class,

            ]);

            return response($content)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . 'EmployeeVacationPDF' . '.pdf"');

    }

    public function show($id){
        $pdf_file = PDFFile::find($id);

        if (!$pdf_file) {
            abort(404);
        }

        $response = new Response($pdf_file->content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $pdf_file->name . '"',
        ]);
        return $response;

    }

    public function destroy($id){
        if( $pdf = PDFFile::findOrFail($id)) {
            $pdf->delete();
            return $this->success();
        }
        else
            return $this->failure();
    }
}
