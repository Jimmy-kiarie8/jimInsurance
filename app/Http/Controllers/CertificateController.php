<?php

namespace App\Http\Controllers;

use App\Certificate;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Carbon;
use App\User;
use PdfReport;
// use ExcelReport;
use Auth;

class CertificateController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $cert = new Certificate;
        $cert->serial_from = $request->serial_from;
        $cert->serial_to = $request->serial_to;
        $cert->total = $request->serial_to - $request->serial_from;
        $cert->user_id = Auth::id();
        $cert->underwriter = Auth::user()->name;
        $cert->branch_id = Auth::user()->branch_id;
        $cert->save();
        return $cert;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certificate $certificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $certificate)
    {
        //
    }

    public function getCertificates()
    {
        return Certificate::all();
    }

    public function cer()
    {
            // Do some querying..
        $queryBuilder = User::get(); // You should sort groupBy column to use groupBy() Method
        
        $title = 'Registered User Report';

        // For displaying filters description on header
        $meta = [
            'Registered on' => '2018-03-05' . ' To ' . '2018-03-05',
        ];
        // Set Column to be displayed
        $columns = [
        'Name' => 'name',
        'Email' => 'name',
        ];
        return PdfReport::of($title, $meta, $queryBuilder, $columns)
        ->setCss([
            '.head-content' => 'border-width: 1px',
        ])
        ->setOrientation('Portrait')
        // ->setPaper('a6')
        // ->showMeta(false)
        // ->showHeader(false)
        ->stream();
    }

    public function certs(Request $request) {
        // Retrieve any filters
        // $fromDate = $request->input('from_date');
        // $toDate = $request->input('to_date');
        // $sortBy = $request->input('sort_by');
    
        // Report title
        $title = '';
    
        // For displaying filters description on header
        $meta = [
            'Registered on' => '2018-03-05' . ' To ' . '2018-03-05',
            // 'Registered on' => $fromDate . ' To ' . $toDate,
        ];
    
        // Do some querying..
        $queryBuilder = User::whereBetween('created_at', ['2018-03-05', '2018-10-10'])
                            ->orderBy('id');
    
        // Set Column to be displayed
        $columns = [
            'Name' => 'name',
            'Registered At', // if no column_name specified, this will automatically seach for snake_case of column name (will be created_at) column from query result
            'Total Balance' => 'phone',
        ];
    
        /*
            Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
    
            - of()         : Init the title, meta (filters description to show), query, column (to be shown)
            - editColumn() : To Change column class or manipulate its data for displaying to report
            - editColumns(): Mass edit column
            - showTotal()  : Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
            - groupBy()    : Show total of value on specific group. Used with showTotal() enabled.
            - limit()      : Limit record to be showed
            - make()       : Will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
        */
        return PdfReport::of($title, $meta, $queryBuilder, $columns)
                       
                        ->setCss([
                            '.head-content' => 'border-width: 0px',
                        ])
                        ->limit(20)
                        ->setOrientation('landscape')
                        // ->setPaper('a6')
                        ->showMeta(false)
                        ->showHeader(false)
                        ->stream(); // or download('filename here..') to download pdf
    }
}
