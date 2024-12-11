<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Http\Request;

trait TamuTrait
{
    /**
     * Apply daily date filter to query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $startDate
     * @param string $endDate
     * @param string $dateField default 'waktu_perjanjian'
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyDailyFilter($query, $startDate, $endDate, $dateField = 'waktu_perjanjian')
    {
        return $query->whereBetween($dateField, [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ]);
    }

    /**
     * Apply monthly date filter to query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $month
     * @param int $year
     * @param string $dateField default 'waktu_perjanjian'
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyMonthlyFilter($query, $month, $year, $dateField = 'waktu_perjanjian')
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        return $query->whereBetween($dateField, [$startDate, $endDate]);
    }

    /**
     * Apply yearly date filter to query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $year
     * @param string $dateField default 'waktu_perjanjian'
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyYearlyFilter($query, $year, $dateField = 'waktu_perjanjian')
    {
        $startDate = Carbon::createFromDate($year, 1, 1)->startOfYear();
        $endDate = $startDate->copy()->endOfYear();

        return $query->whereBetween($dateField, [$startDate, $endDate]);
    }

    /**
     * Generate filename based on filter type and parameters
     *
     * @param \Illuminate\Http\Request $request
     * @param string $prefix default 'laporan'
     * @return string
     */
    protected function generateFilteredFilename(Request $request, $prefix = 'laporan')
    {
        $filename = $prefix;

        if ($request->filterType === 'daily' && $request->filled(['startDate', 'endDate'])) {
            $filename .= '-' . $request->startDate . '-sampai-' . $request->endDate;
        } elseif ($request->filterType === 'monthly' && $request->filled(['month', 'monthYear'])) {
            $filename .= '-bulan-' . $request->month . '-' . $request->monthYear;
        } elseif ($request->filterType === 'yearly' && $request->filled('year')) {
            $filename .= '-tahun-' . $request->year;
        }

        return $filename;
    }
    protected function headerDateTamu(Request $request)
    {
        $title = "";

        if ($request->filterType === 'daily' && $request->filled(['startDate', 'endDate'])) {
            $title = $request->startDate . '-sampai-' . $request->endDate;
        } elseif ($request->filterType === 'monthly' && $request->filled(['month', 'monthYear'])) {
            $title = 'Bulan-' . $request->month . '-' . $request->monthYear;
        } elseif ($request->filterType === 'yearly' && $request->filled('year')) {
            $title = 'Tahun-' . $request->year;
        }

        return $title;
    }

    /**
     * Apply date filter based on filter type
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @param string $dateField default 'waktu_perjanjian'
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function applyDateFilterTamu($query, Request $request)
{
    // Check if date range is provided in the request
    if ($request->filled('start_date') && $request->filled('end_date')) {
        // Convert dates to Y-m-d format if necessary
        $startDate = Carbon::parse($request->input('start_date'))->format('Y-m-d');
        $endDate = Carbon::parse($request->input('end_date'))->format('Y-m-d');

        // Apply date filter
        $query->whereBetween('waktu_perjanjian', [$startDate, $endDate]);
    }

    return $query;
}

}
