<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Prodi;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->query('periode', '7 Hari');
        $from_date = $request->query('from_date');
        $to_date = $request->query('to_date');
        $prodiId = $request->query('prodi_id');

        // Menentukan Rentang Tanggal (Current vs Previous untuk chart growth rate)
        if ($from_date && $to_date) {
            $currentStart = Carbon::parse($from_date)->startOfDay();
            $currentEnd = Carbon::parse($to_date)->endOfDay();
            $diffInDays = $currentStart->diffInDays($currentEnd) + 1;

            $previousStart = (clone $currentStart)->subDays($diffInDays)->startOfDay();
            $previousEnd = (clone $currentStart)->subDay()->endOfDay();
        } else {
            switch ($periode) {
                case '30 Hari':
                    $currentStart = now()->subDays(29)->startOfDay();
                    $currentEnd = now()->endOfDay();
                    $previousStart = now()->subDays(59)->startOfDay();
                    $previousEnd = now()->subDays(30)->endOfDay();
                    break;
                case '3 Bulan':
                    $currentStart = now()->subMonths(3)->startOfDay();
                    $currentEnd = now()->endOfDay();
                    $previousStart = now()->subMonths(6)->startOfDay();
                    $previousEnd = now()->subMonths(3)->subDay()->endOfDay();
                    break;
                case '1 Tahun':
                    $currentStart = now()->subYears(1)->startOfDay();
                    $currentEnd = now()->endOfDay();
                    $previousStart = now()->subYears(2)->startOfDay();
                    $previousEnd = now()->subYears(1)->subDay()->endOfDay();
                    break;
                case '7 Hari':
                default:
                    $periode = '7 Hari';
                    $currentStart = now()->subDays(6)->startOfDay();
                    $currentEnd = now()->endOfDay();
                    $previousStart = now()->subDays(13)->startOfDay();
                    $previousEnd = now()->subDays(7)->endOfDay();
                    break;
            }
        }


        $queryCurrent = Pengajuan::query();
        $queryPrevious = Pengajuan::query();

        if ($prodiId && $prodiId !== 'Semua Prodi') {
            $queryCurrent->whereHas('mahasiswa', function ($q) use ($prodiId) {
                $q->where('prodi_id', $prodiId);
            });
            $queryPrevious->whereHas('mahasiswa', function ($q) use ($prodiId) {
                $q->where('prodi_id', $prodiId);
            });
        }

        // Ambil data untuk periode yang dipilih dan sebelumnya
        $currentSubmissions = (clone $queryCurrent)->whereBetween('tgl_ajuan', [$currentStart, $currentEnd])->get();
        $previousSubmissions = (clone $queryPrevious)->whereBetween('tgl_ajuan', [$previousStart, $previousEnd])->get();

        // Hitung Key Performance Indicator dan Growth Rate untuk 3 card yang ada di halaman 
        $totalCurrent = $currentSubmissions->count();
        $totalPrevious = $previousSubmissions->count();
        $totalGrowth = $totalPrevious > 0 ? round((($totalCurrent - $totalPrevious) / $totalPrevious) * 100) : 0;

        $selesaiCurrent = $currentSubmissions->where('status', 'selesai')->count();
        $selesaiPrevious = $previousSubmissions->where('status', 'selesai')->count();
        $selesaiGrowth = $selesaiPrevious > 0 ? round((($selesaiCurrent - $selesaiPrevious) / $selesaiPrevious) * 100) : 0;

        $menungguCurrent = $currentSubmissions->where('status', 'menunggu')->count();
        $menungguPrevious = $previousSubmissions->where('status', 'menunggu')->count();
        $menungguGrowth = $menungguPrevious > 0 ? round((($menungguCurrent - $menungguPrevious) / $menungguPrevious) * 100) : 0;

        $diprosesCurrent = $currentSubmissions->where('status', 'diproses')->count();
        $ditolakCurrent = $currentSubmissions->where('status', 'ditolak')->count();

        // Helper format pertumbuhan
        $formatGrowth = function ($val) {
            return ($val >= 0 ? '+' : '') . $val . '%';
        };

        $totalGrowthStr = $formatGrowth($totalGrowth);
        $selesaiGrowthStr = $formatGrowth($selesaiGrowth);
        $menungguGrowthStr = $formatGrowth($menungguGrowth);

        // Progress bar percentages (relative to total)
        $selesaiBar = $totalCurrent > 0 ? round(($selesaiCurrent / $totalCurrent) * 100) : 0;
        $menungguBar = $totalCurrent > 0 ? round(($menungguCurrent / $totalCurrent) * 100) : 0;
        // Total progress bar bisa di-set 100% atau completion rate
        $totalBar = $totalCurrent > 0 ? round((($selesaiCurrent + $diprosesCurrent) / $totalCurrent) * 100) : 0;

        // Chart Data Tren Pengajuan 
        // Bulanan (6 bulan terakhir)
        $chartDataBulanan = [];
        $bgClasses = ['bg-blue-100', 'bg-blue-200', 'bg-blue-300', 'bg-blue-500', 'bg-blue-400', 'bg-blue-300'];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $startOfMonth = (clone $month)->startOfMonth();
            $endOfMonth = (clone $month)->endOfMonth();

            $count = (clone $queryCurrent)->whereBetween('tgl_ajuan', [$startOfMonth, $endOfMonth])->count();
            $chartDataBulanan[] = [
                'label' => $month->translatedFormat('M'),
                'count' => $count,
            ];
        }
        $maxMonthCount = max(array_column($chartDataBulanan, 'count')) ?: 1;
        foreach ($chartDataBulanan as $key => $data) {
            $pct = round(($data['count'] / $maxMonthCount) * 100);
            $chartDataBulanan[$key]['percentage'] = max($pct, 15); 
            $chartDataBulanan[$key]['class'] = 'w-full rounded-t-xl transition-all hover:brightness-110 ' . ($bgClasses[$key] ?? 'bg-blue-500');
        }

        // Mingguan (6 minggu terakhir)
        $chartDataMingguan = [];
        for ($i = 5; $i >= 0; $i--) {
            $weekStart = now()->subWeeks($i)->startOfWeek();
            $weekEnd = now()->subWeeks($i)->endOfWeek();

            $count = (clone $queryCurrent)->whereBetween('tgl_ajuan', [$weekStart, $weekEnd])->count();
            $chartDataMingguan[] = [
                'label' => $weekStart->format('d/m'),
                'count' => $count,
            ];
        }
        $maxWeekCount = max(array_column($chartDataMingguan, 'count')) ?: 1;
        foreach ($chartDataMingguan as $key => $data) {
            $pct = round(($data['count'] / $maxWeekCount) * 100);
            $chartDataMingguan[$key]['percentage'] = max($pct, 15);
            $chartDataMingguan[$key]['class'] = 'w-full rounded-t-xl transition-all hover:brightness-110 ' . ($bgClasses[$key] ?? 'bg-blue-500');
        }

        // Donut Chart Data Distribusi Status
        if ($totalCurrent > 0) {
            $selesaiPct = round(($selesaiCurrent / $totalCurrent) * 100);
            $diprosesPct = round((($diprosesCurrent + $menungguCurrent) / $totalCurrent) * 100);
            $ditolakPct = max(0, 100 - $selesaiPct - $diprosesPct);
        } else {
            $selesaiPct = 0;
            $diprosesPct = 0;
            $ditolakPct = 0;
        }

        // Rekap per Prodi
        $allProdis = Prodi::orderBy('nama_prodi')->get();
        $rekapProdi = [];
        foreach ($allProdis as $prodi) {
            $queryProdi = Pengajuan::whereHas('mahasiswa', function ($q) use ($prodi) {
                $q->where('prodi_id', $prodi->id);
            })->whereBetween('tgl_ajuan', [$currentStart, $currentEnd]);

            $tProdi = $queryProdi->count();
            $sProdi = (clone $queryProdi)->where('status', 'selesai')->count();
            $dProdi = (clone $queryProdi)->where('status', 'diproses')->count();
            $mProdi = (clone $queryProdi)->where('status', 'menunggu')->count();

            $compRate = $tProdi > 0 ? round(($sProdi / $tProdi) * 100) : 0;

            $rekapProdi[] = [
                'nama_prodi' => $prodi->jenjang . ' ' . $prodi->nama_prodi,
                'total' => $tProdi,
                'selesai' => $sProdi,
                'diproses' => $dProdi,
                'menunggu' => $mProdi,
                'completion_rate' => $compRate,
            ];
        }

        // Sort prodi berdasarkan total terbanyak
        usort($rekapProdi, function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        // Data CSV
        $csvHeader = "Program Studi,Total,Selesai,Diproses,Menunggu\n";
        $csvLines = [];
        foreach ($rekapProdi as $rekap) {
            $csvLines[] = sprintf(
                '"%s",%d,%d,%d,%d',
                str_replace('"', '""', $rekap['nama_prodi']),
                $rekap['total'],
                $rekap['selesai'],
                $rekap['diproses'],
                $rekap['menunggu']
            );
        }
        $csvContent = $csvHeader . implode("\n", $csvLines);

        return view('admin.laporan.index', compact(
            'periode',
            'from_date',
            'to_date',
            'prodiId',
            'allProdis',
            'totalCurrent',
            'selesaiCurrent',
            'menungguCurrent',
            'totalGrowthStr',
            'selesaiGrowthStr',
            'menungguGrowthStr',
            'totalBar',
            'selesaiBar',
            'menungguBar',
            'chartDataBulanan',
            'chartDataMingguan',
            'selesaiPct',
            'diprosesPct',
            'ditolakPct',
            'rekapProdi',
            'csvContent'
        ));
    }
}
