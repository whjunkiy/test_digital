<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\DB;


class Tst extends Controller
{
    public function tst(Request $request) {
        return Inertia::render('Tst/Index', [
            'sessions' => session()->all(),
            'files' => \App\Models\Tst::getFiles()
        ]);
    }

    public function store(FormRequest $request){
        $file = $request->file('file');
        $name = $request->name;

        $collection = (new FastExcel)->import($file->getRealPath());
        if (!$name) {
            $name = $file->getFilename();
        }

        foreach ($collection as $c) {
            $c['file'] = $name;
            if ($c['isrc'] == '-') $c['isrc'] = null;
            if (!intval($c['track_external_id'])) $c['track_external_id'] = null;
            if (!intval($c['album_id'])) $c['album_id'] = null;
            if (!intval($c['album_external_id'])) $c['album_external_id'] = null;
            $model = \App\Models\Tst::create($c);
            $model->save();
        }

        return response(status: 200);
    }

    public function exr1(Request $request) {
        return (new FastExcel(\App\Models\Tst::getDubls()))->download('file.xlsx');
    }

    public function exr2(Request $request) {
        $f1 = $request->get('f1', '1');
        $f2 = $request->get('f2', '2');
        return (new FastExcel(\App\Models\Tst::getDif($f1, $f2)))->download('file.xlsx');
    }
}
