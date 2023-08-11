<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $data = Employee::all();

        if ($request->ajax()) {

            // Filter data berdasarkan kolom
            if ($request->has('search') && !empty($request->input('search')['value'])) {
                $searchValue = $request->input('search')['value'];
                $data->where(function ($query) use ($searchValue) {
                    $query->where('nama', 'like', '%' . $searchValue . '%')
                        ->orWhere('nik', 'like', '%' . $searchValue . '%')
                        ->orWhere('posisi', 'like', '%' . $searchValue . '%');
                });
            }

            // Menghitung total data tanpa filtering
            $totalData = $data->count();

            // Menghitung total data setelah filtering
            $filteredData = $data->get();

            // Pagination
            $start = $request->input('start');
            $length = $request->input('length');
            $data = $data->skip($start)->take($length)->get();

            // Bentuk response JSON sesuai format DataTables
            $response = [
                "draw" => intval($request->input('draw')),
                "recordsTotal" => $totalData,
                "recordsFiltered" => $filteredData->count(),
                "data" => $data,
            ];

            return response()->json($response);
        }

        return view('datapegawai', ['data' => $data]);
    }

    public function tambahpegawai(){
        return view('tambahdata');
    }

    public function insertdata(Request $request){
        $this->validate($request,[
            'nama' => 'required',
            'nik' => 'required|min:12|max:13',
            'posisi' => [
                'required',
                Rule::in(['Digital Marketing','Frontend','Backend']),
            ],
            'foto' => 'required','mimes:jpg,png,jpeg|image|max:2048',
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

    public function updateData(Request $request, $id)
    {
        // Validasi input menggunakan aturan validasi yang sesuai
        $rules = [
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:employees,nik,' . $id, // Tambahkan pengecualian untuk ID saat validasi unik
            'posisi' => 'required|string|max:255',
        ];

        $request->validate($rules);

        // Temukan data pegawai berdasarkan ID
        $data = Employee::find($id);

        // Lakukan pembaruan data
        $data->update($request->all());

        if (session('halaman_url')) {
            return redirect(session('halaman_url'))->with('success', 'Data Berhasil Diupdate');
        }

        return redirect()->route('pegawai')->with('success', 'Data Berhasil Diupdate');
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
