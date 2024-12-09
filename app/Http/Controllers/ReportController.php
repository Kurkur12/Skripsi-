<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Register;
use App\Models\Record;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function generateReport(Request $request)
    {
        $filterType = $request->input('filter_type');
        $reportType = $request->input('report_type');

        if (!$reportType) {
            return response()->json(['error' => 'Jenis laporan diperlukan'], 400);
        }

        // Handle filter type logic
        if ($filterType === 'quarter') {
            $quarter = $request->input('quarter');
            $year = date('Y');

            switch ($quarter) {
                case 'Q1':
                    $startDate = Carbon::create($year, 1, 1)->startOfDay();
                    $endDate = Carbon::create($year, 3, 31)->endOfDay();
                    break;
                case 'Q2':
                    $startDate = Carbon::create($year, 4, 1)->startOfDay();
                    $endDate = Carbon::create($year, 6, 30)->endOfDay();
                    break;
                case 'Q3':
                    $startDate = Carbon::create($year, 7, 1)->startOfDay();
                    $endDate = Carbon::create($year, 9, 30)->endOfDay();
                    break;
                case 'Q4':
                    $startDate = Carbon::create($year, 10, 1)->startOfDay();
                    $endDate = Carbon::create($year, 12, 31)->endOfDay();
                    break;
                default:
                    return response()->json(['error' => 'Quarter tidak valid'], 400);
            }
        } elseif ($filterType === 'date_range') {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        } else {
            return response()->json(['error' => 'Jenis filter tidak valid'], 400);
        }

        // Initialize variables
        $data = [];
        $title = '';

        try {
            switch ($reportType) {
                case 'register_barang':
                    $data = Register::query()
                        ->whereBetween('date_of_entry', [$startDate, $endDate])
                        ->get()
                        ->map(function ($item) {
                            return [
                                'kode' => $item->code,
                                'nama_barang' => $item->name,
                                'kondisi' => $item->condition,
                                'jumlah' => $item->quantity,
                                'tanggal' => $item->date_of_entry,
                            ];
                        });
                    $title = 'Laporan Register Barang';
                    break;

                case 'record_barang':
                    $data = Record::query()
                        ->whereBetween('date_of_entry', [$startDate, $endDate])
                        ->get()
                        ->map(function ($item) {
                            return [
                                'kode' => $item->code,
                                'nama_barang' => $item->name,
                                'kondisi' => $item->condition,
                                'jumlah' => $item->quantity,
                                'tanggal' => $item->date_of_entry,
                            ];
                        });
                    $title = 'Laporan Record Barang';
                    break;

                case 'maintenance':
                    $data = Maintenance::query()
                        ->whereBetween('tanggal_maintenance', [$startDate, $endDate])
                        ->get()
                        ->map(function ($item) {
                            return [
                                'kode' => $item->kode_barang,
                                'nama_barang' => $item->nama_barang,
                                'kondisi' => $item->kondisi,
                                'jumlah' => $item->jumlah,
                                'tanggal' => $item->tanggal_maintenance,
                                'tanggal_next' => $item->tanggal_maintenance_selanjutnya,
                            ];
                        });
                    $title = 'Laporan Maintenance';
                    break;

                default:
                    return response()->json(['error' => 'Jenis laporan tidak valid'], 400);
            }

            // Save report to database
            $report = new Report();
            $report->filter_type = $filterType;
            $report->start_date = $filterType === 'quarter' ? null : $startDate;
            $report->end_date = $filterType === 'quarter' ? null : $endDate;
            $report->quarter = $filterType === 'quarter' ? $quarter : null;
            $report->report_type = $reportType;
            $report->save();

            // Generate PDF
            $pdf = Pdf::loadView('reports.pdf', [
                'data' => $data,
                'title' => $title,
                'startDate' => $startDate->format('d/m/Y'),
                'endDate' => $endDate->format('d/m/Y'),
                'filterType' => $filterType,
                'reportType' => $reportType,
                'quarter' => $request->input('quarter'),
            ]);

            // Generate filename
            $filename = sprintf(
                'report_%s_%s_%s_%s.pdf',
                $reportType,
                $filterType === 'quarter' ? $request->input('quarter') : '',
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d')
            );

            return $pdf->download($filename);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal menghasilkan laporan',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
