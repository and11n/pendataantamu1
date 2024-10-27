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
    protected function applyDateFilterTamu($query, Request $request, $dateField = 'waktu_perjanjian')
    {
        if (!$request->filled('filterType')) {
            return $query;
        }

        switch ($request->filterType) {
            case 'daily':
                if ($request->filled(['startDate', 'endDate'])) {
                    $query = $this->applyDailyFilter($query, $request->startDate, $request->endDate, $dateField);
                }
                break;

            case 'monthly':
                if ($request->filled(['month', 'monthYear'])) {
                    $query = $this->applyMonthlyFilter($query, $request->month, $request->monthYear, $dateField);
                }
                break;

            case 'yearly':
                if ($request->filled('year')) {
                    $query = $this->applyYearlyFilter($query, $request->year, $dateField);
                }
                break;
        }

        return $query;
    }
}