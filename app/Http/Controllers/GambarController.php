<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Gambar;
use Exception;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GambarController extends Controller
{
    public function index()
    {

        // cara akses request langsung tanpa pakai parameter
        // request()
        // $value = session('data', 'guest');
        // if (!request()->session()->exists('data')) {
        //     dump(request()->session()->all());
        // } else {
        //     dump(request()->session()->get('data'));
        // }

        $gambar = Gambar::all();

        return view('home', compact('gambar'));
    }


    public function tambahData()
    {
        try {
            $docId = DB::select('select LPAD(substr(doc_id, 12, 5)+1,5,0) as doc_id from images order by doc_id desc limit 1');

            $docId =  $docId[0]->doc_id; // hasil query dimasukkan ke variable   
            $docId = 'PI-LKRS-20-' . $docId; //doc id di concate dengan hasil query

        } catch (Exception $e) {
            $docId = 'PI-LKRS-20-00001';
        }
        echo $docId;

        return view('tambahData', [
            'id' => $docId,
            'counter' => 0,
            'message' => 'kosong'
        ]);
    }


    public function insert(Request $request)
    {
        $docId = $request->doc_id; //dpt dokumen id 

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // $validator = Validator::make($request->all(), [
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        // ]);

        // if ($validator->fails()) {
        //     return redirect('upload')
        //         ->withErrors($validator)
        //         ->withInput(['id' => $docId]);
        // }

        // $oriName = $request->image->getClientOriginalName();
        // $file = $request->file('image'); //cek isi file yg ke upload

        $ext = $request->image->extension();  //dpt file extension 
        //cari namanya apa
        try {
            echo $docId;
            $name = DB::select("select SUBSTR(img_name,INSTR(img_name,'.')-1,1) as img_name from images where doc_id = ? order by img_name desc limit 1", [$docId]);
            $name = $name[0]->img_name + 1;

            if ($name == '7') {
                return view('tambahData', [
                    'id' => $docId,
                    'counter' => 6,
                    'message' => 'Melewati Batas Maksimal'
                ]);
            }

            $name = $docId . '-' . $name . '.' . $ext;
        } catch (Exception $e) {
            $name = $docId . '-1.' . $ext;
        } // end cari nama

        $path = storage_path('app\public\images\\' . $name);

        // $request->image->storeAs('public/images', $name); // masukkan gambar ke folder images
        Image::make($request->image)->resize(300, 200)->save($path);

        // Storage::disk('imgPath')->put($name, $image, 'public');


        if (!$request->session()->exists('data')) {
            $created_by = 'Guest';
        } else {
            $created_by = $request->session()->get('data');
        }

        Gambar::create([
            'doc_id' => $docId,
            'img_name' => $name,
            'img_path' => $path,
            'created_by' => $created_by
        ]);

        return view('tambahData', [
            'id' => $docId,
            'counter' => 1,         // buat trigger alert
            'message' => 'berhasil di input'    // buat pesan di allert
        ]);
    }
}
