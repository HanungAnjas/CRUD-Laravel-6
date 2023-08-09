<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    public function index(Request $request){
        if($request->has('search')){
            $data = Employee::where('nama','LIKE','%' .$request->search.'%')->paginate(10);
            Session::put('halaman_url', request()->fullUrl());
        } else{
            $data = Employee::paginate(10);
            Session::put('halaman_url', request()->fullUrl());
        }

        return view('datapegawai',compact('data'));
    }

    public function tambahpegawai(){
        return view('tambahdata');
    }

    public function insertdata(Request $request){
        $this->validate($request,[
            'nama' => 'required',
            'nik' => 'required|min:12|max:13',
            'posisi' => 'required',
            'foto' => 'mimes:jpg,png,jpeg|image|max:2048',
        ]);
        $data = Employee::create($request->all());
        if ($request->hasFile('foto')){
            $request->file('foto')->move('fotopegawai/', $request->file('foto')->getCLIentOriginalName());
            $data->foto = $request->file('foto')->getCLIentOriginalName();
            $data->save();
        }
        return redirect()->route('pegawai')->with('success','Data Berhasil Ditambahkan');
    }

    public function tampilkandata($id){
        $data = Employee::find($id);
        return view('tampildata', compact('data'));
    }

    public function updatedata(Request $request, $id){
        $data = Employee::find($id);
        $data->update($request->all());
        if(session('halaman_url')){
            return Redirect(session('halaman_url'))->with('success','Data Berhasil Diupdate');
        }
        return redirect()->route('pegawai')->with('success','Data Berhasil Diupdate');
    }

    public function delete($id){
        $data = Employee::find($id);
        $data->delete();
        if(session('halaman_url')){
            return Redirect(session('halaman_url'))->with('success','Data Berhasil Dihapus');
        }
        return redirect()->route('pegawai')->with('success','Data Berhasil Dihapus');
    }

    public function exportpdf(){
        $data = Employee::all();
        
        view()->share('data', $data);
        $pdf = PDF::loadview('datapegawai-pdf');
        return $pdf->download('Data Pegawai CV. Nore Inovasi.pdf');
    }

    public function exportexcel(){
        return Excel::download(new EmployeeExport, 'Data Pegawai CV. Nore Inovasi.xlsx');
    }

    public function importexcel(Request $request){
        $data = $request->file('file');
        $namafile = $data->getCLientOriginalName();
        $data->move('EmployeeData', $namafile);
        Excel::import(new EmployeeImport, \public_path('/EmployeeData/'.$namafile));
        return \redirect()->back();
    }
}
