<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDataController extends Controller
{
    public function index()
    {
        $categories = DB::table('data')
            ->select('data', DB::raw('COUNT(*) as total_records'), DB::raw('SUM(total) as total_population'))
            ->groupBy('data')
            ->orderBy('data')
            ->get();

        return view('admin.data-management', compact('categories'));
    }

    public function show($category)
    {
        $records = DB::table('data')
            ->where('data', $category)
            ->orderBy('label')
            ->get();

        return view('admin.data-category', compact('records', 'category'));
    }

    public function update(Request $request, $category)
    {
        $request->validate([
            'records.*.id' => 'required|exists:data,id',
            'records.*.label' => 'required|string|max:255',
            'records.*.total' => 'required|integer|min:0',
        ]);

        foreach ($request->records as $record) {
            DB::table('data')
                ->where('id', $record['id'])
                ->update([
                    'label' => $record['label'],
                    'total' => $record['total'],
                    'updated_at' => now(),
                ]);
        }

        return redirect()->route('admin.data.show', $category)
            ->with('success', 'Data berhasil diperbarui!');
    }

    public function store(Request $request, $category)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'total' => 'required|integer|min:0',
        ]);

        DB::table('data')->insert([
            'data' => $category,
            'label' => $request->label,
            'total' => $request->total,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.data.show', $category)
            ->with('success', 'Data baru berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $record = DB::table('data')->where('id', $id)->first();
        if (!$record) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }

        DB::table('data')->where('id', $id)->delete();

        return redirect()->route('admin.data.show', $record->data)
            ->with('success', 'Data berhasil dihapus!');
    }

    public function export($category)
    {
        $records = DB::table('data')
            ->where('data', $category)
            ->orderBy('label')
            ->get();

        $filename = "data_{$category}_" . date('Y-m-d_H-i-s') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($records) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Label', 'Total']);
            
            foreach ($records as $record) {
                fputcsv($file, [$record->label, $record->total]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
