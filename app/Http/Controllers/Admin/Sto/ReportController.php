<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Sto;

use App\Http\Controllers\Controller;
use App\Services\Sto\StoReportService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(
        private readonly StoReportService $reportService,
    ) {
    }

    public function index(Request $request): View
    {
        $report = $this->reportService->buildReport(
            $request->input('date_from'),
            $request->input('date_to'),
        );

        return view('admin.sto.reports.index', $report);
    }
}
