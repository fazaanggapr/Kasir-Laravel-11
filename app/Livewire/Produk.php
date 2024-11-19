<?php

namespace App\Livewire; 

use App\Models\Produk as ModelProduk;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Produk as ImporProduk;

class Produk extends Component
{
    use WithFileUploads;
    public $pilihanMenu = 'lihat';
    public $nama;
    public $kode;
    public $stok;
    public $harga;
    public $produkTerpilih;
    public $fileExcel;

    public function imporExcel(){
        Excel::import(new ImporProduk, $this->fileExcel);
        $this->reset();
    }

    public function pilihEdit($id) {
        $this->produkTerpilih = ModelProduk::findOrFail($id);
        $this->nama = $this->produkTerpilih->nama;
        $this->kode = $this->produkTerpilih->kode;
        $this->stok = $this->produkTerpilih->stok;
        $this->harga = $this->produkTerpilih->harga;
        $this->pilihanMenu = 'edit';
    }

    public function simpanEdit() {
        $this->validate([
            'nama' => 'required',
            'kode' => ['required', 'unique:produks,kode'.$this->produkTerpilih->id],
            'stok' => 'required',
            'harga' => 'required'
        ],[
            'nama.required' => 'Nama harus diisi!',
            'kode.required' => 'Kode harus diisi!',
            'kode.unique' => 'Kode telah digunakan!',
            'stok.required' => 'Stok harus diisi!',
            'harga.required' => 'Harga harus diisi!'
        ]);
        $simpan = $this->produkTerpilih;
        $simpan->nama = $this->nama;
        $simpan->kode = $this->kode;
        $simpan->harga = ($this->harga);
        $simpan->stok = $this->stok;
        $simpan->save();

        $this->reset();
        $this->pilihanMenu = 'lihat';
    }

    public function pilihHapus($id) {
        $this->produkTerpilih = ModelProduk::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }

    public function hapus() { 
        $this->produkTerpilih->delete();
        $this->reset();
    }

    public function batal() {
        $this->reset();
    }

    public function simpan() {
        $this->validate([
            'nama' => 'required',
            'kode' => ['required', 'unique:produks,kode'],
            'stok' => 'required',
            'harga' => 'required'
        ],[
            'nama.required' => 'Nama harus diisi!',
            'kode.required' => 'Kode harus diisi!',
            'kode.unique' => 'Kode telah digunakan!',
            'stok.required' => 'Stok harus diisi!',
            'harga.required' => 'Harga harus diisi!'
        ]);
        $simpan = new ModelProduk();
        $simpan->nama = $this->nama;
        $simpan->kode = $this->kode;
        $simpan->harga = ($this->harga);
        $simpan->stok = $this->stok;
        $simpan->save();

        $this->reset(['nama', 'kode', 'harga', 'stok']);
        $this->pilihanMenu = 'lihat';
    }
    public function pilihMenu($menu) 
    {
        $this->pilihanMenu = $menu;
    }
    public function render()
    {
        return view('livewire.produk')->with([
            'semuaProduk' =>ModelProduk::all()
        ]);
    }
}
