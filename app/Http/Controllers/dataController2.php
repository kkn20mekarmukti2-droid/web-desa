<?php

namespace App\Http\Controllers;

use App\Models\dataModel;
use App\Models\rwModel;
use Illuminate\Http\Request;

class dataController extends Controller
{
    public function penduduk()
    {
        return view("datapenduduk");
    }
    public function kk()
    {
        return view("datakk");
    }
    public function pendidikan()
    {
        return view("datapendidikan");
    }
    public function kesehatan()
    {
        return view("datakesehatan");
    }
    public function siswa()
    {
        return view("datasiswa");
    }
    public function profesi()
    {
        return view("dataprofesi");
    }
    public function klub()
    {
        return view("dataklub");
    }
    public function kesenian()
    {
        return view("datakesenian");
    }
    public function sumberair()
    {
        return view("datasumberair");
    }
    public function getChartData($type)
    {
        $data = dataModel::where('data', $type)->get();
        return response()->json([
            'labels' => $data->pluck('label')->toArray(),
            'data' => $data->pluck('total')->toArray(),
        ]);
    }
    public function sinkron(Request $request)
    {

        $type = $request->input('type');
        $data = $request->input('data');
        dataModel::where('data', $type)->delete();
        foreach ($data as $i) {
            dataModel::insert([
                'data'=> $type,
                'label'=> $i['label'],
                'total'=> $i['total'],
            ]);
        }

        return response("Berhasil Sinkron");
    }
    public function rw($rw){
        $rw = rwModel::with(['rts' => function ($query) {
            $query->orderBy('rt');
        }])->where('rw', $rw)->first();
        return view('rw', compact('rw'));
    }
}
