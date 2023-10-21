<?php
namespace App\Models;
use CodeIgniter\Model;
class M_model extends model
{

	public function tampil ($table)
	{
		return $this->db->table($table)->get()->getResult();
	}

	public function pay_invoice($table1, $table2, $table3, $on, $on2, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->getWhere($where)->getRow();
	}
	
	public function tampil_title ($table)
	{
		return $this->db->table($table)->get()->getRow();
	}

	public function tampilOrderBy ($table, $column)
	{
		return $this->db->table($table)->orderBy($column, 'DESC')->get()->getResult();
	}

	public function log_activity($table1, $table2, $on, $where)
	{
		return $this->db->table($table1)->join($table2, $on, 'left')->where($where)->get()->getResult();
	}

	public function filter4($table, $awal, $akhir) {
		return $this->db->query(
			"SELECT *
			FROM ".$table."
			JOIN barang ON ".$table.".id_barang=barang.id_barang
			JOIN user ON ".$table.".maker_masuk=user.id_user
			WHERE ".$table.".tanggal_masuk
			BETWEEN '".$awal."'
			AND '".$akhir."'"
		)->getResult();
	}

	public function filter_u($table, $awal, $akhir) {
		return $this->db->query(
			"SELECT *
			FROM ".$table."
			JOIN kelas ON ".$table.".id_kelas=kelas.id_kelas
			JOIN user ON ".$table.".id_user_user=user.id_user
			WHERE ".$table.".tanggal_pgu
			BETWEEN '".$awal."'
			AND '".$akhir."'"
		)->getResult();
	}

	public function filter_p($table, $awal, $akhir) {
		return $this->db->query(
			"SELECT *
			FROM ".$table."
			JOIN kelas ON ".$table.".id_kelas=kelas.id_kelas
			JOIN user ON ".$table.".maker_uk=user.id_user
			WHERE ".$table.".tanggal_uk
			BETWEEN '".$awal."'
			AND '".$akhir."'"
		)->getResult();
	}

	public function filter_employee_salary ($table, $awal,$akhir)
	{
		return $this->db->query(
			"SELECT *
			FROM ".$table."
			join guru ON ".$table.".id_guru_gaji = guru.id_guru
			WHERE ".$table.".tanggal_gaji
			BETWEEN '".$awal."'
			AND '".$akhir."'"
		)->getResult();
	}

	public function filter_guru ($table, $awal,$akhir,$where)
	{
		return $this->db->query(
			"SELECT *
			FROM ".$table."
			join guru ON ".$table.".id_guru_gaji = guru.id_guru
			WHERE ".$table.".tanggal_gaji
			BETWEEN '".$awal."'
			AND '".$akhir."'"
		)->getWhere($where)->getResult();
	}

	public function filter_items ($table, $awal,$akhir)
	{
		return $this->db->query(
			"SELECT *
			FROM ".$table."
			join user ON ".$table.".maker_barang = user.id_user
			WHERE ".$table.".barang_laporan
			BETWEEN '".$awal."'
			AND '".$akhir."'"
		)->getResult();
	}

	public function filter_vm($table, $awal, $akhir, $username = null)
	{
	    $builder = $this->db->table($table)
	        ->join('bengkel', "$table.id_service_bengkel = bengkel.id_bengkel")
	        ->join('user', "$table.maker_kendaraan = user.id_user")
	        ->where("$table.vm_laporan BETWEEN '$awal' AND '$akhir'");

	    if ($username !== null) {
	        $builder->where('user.username', $username);
	    }

	    return $builder->get()->getResult();
	}

	public function filter_invoice($table, $awal, $akhir, $username = null)
	{
	    $builder = $this->db->table($table)
	        ->join('kendaraan', "$table.id_kendaraan_invoice = kendaraan.id_kendaraan")
	        ->join('user', "$table.maker_invoice = user.id_user")
	        ->where("$table.invoice_laporan BETWEEN '$awal' AND '$akhir'");

	    if ($username !== null) {
	        $builder->where('user.username', $username);
	    }

	    return $builder->get()->getResult();
	}

	// public function filter_vm ($table, $awal,$akhir, $username = null)
	// {
	// 	return $this->db->query(
	// 		"SELECT *
	// 		FROM ".$table."
	// 		join bengkel ON ".$table.".id_service_bengkel = bengkel.id_bengkel
	// 		join user ON ".$table.".maker_kendaraan = user.id_user
	// 		WHERE ".$table.".vm_laporan
	// 		BETWEEN '".$awal."'
	// 		AND '".$akhir."'"
	// 	)->getResult();
	// }

	public function filter_incoming_items ($table, $awal,$akhir)
	{
		return $this->db->query(
			"SELECT *
			FROM ".$table."
			join barang ON ".$table.".id_masuk_barang = barang.id_barang
			join user ON ".$table.".maker_barang_masuk = user.id_user
			WHERE ".$table.".barang_masuk_laporan
			BETWEEN '".$awal."'
			AND '".$akhir."'"
		)->getResult();
	}

	// public function filter_outbound_items ($table, $awal,$akhir)
	// {
	// 	return $this->db->query(
	// 		"SELECT *
	// 		FROM ".$table."
	// 		join barang ON ".$table.".id_keluar_barang = barang.id_barang
	// 		join user ON ".$table.".maker_barang_masuk = user.id_user
	// 		WHERE ".$table.".barang_keluar_laporan
	// 		BETWEEN '".$awal."'
	// 		AND '".$akhir."'"
	// 	)->getResult();
	// }

	public function filter_outbound_items($table, $awal, $akhir, $username = null)
	{
	    $builder = $this->db->table($table)
	        ->join('barang', "$table.id_keluar_barang = barang.id_barang")
	        ->join('user', "$table.maker_barang_masuk = user.id_user")
	        ->where("$table.barang_keluar_laporan BETWEEN '$awal' AND '$akhir'");

	    if ($username !== null) {
	        $builder->where('user.username', $username);
	    }

	    return $builder->get()->getResult();
	}


	public function filter_loan ($table, $awal,$akhir)
	{
		return $this->db->query(
			"SELECT *
			FROM ".$table."
			join user ON ".$table.".maker_pinjaman = user.id_user
			WHERE ".$table.".pinjaman_laporan
			BETWEEN '".$awal."'
			AND '".$akhir."'"
		)->getResult();
	}

	public function filter_angsuran ($table, $awal,$akhir)
	{
		return $this->db->query(
			"SELECT *
			FROM ".$table."
			join pinjaman_laporan ON ".$table.".id_angsuran_peminjaman = pinjaman_laporan.id_pinjaman
			join katagori_pinjaman ON ".$table.".id_angsuran_kategori = katagori_pinjaman.id_katagori
			join user ON ".$table.".maker_angsuran = user.id_user
			WHERE ".$table.".angsuran_laporan
			BETWEEN '".$awal."'
			AND '".$akhir."'"
		)->getResult();
	}

	public function filter_f($table, $awal, $akhir) {
		return $this->db->query(
			"SELECT *
			FROM ".$table."
			JOIN kelas ON ".$table.".id_kelas=kelas.id_kelas
			JOIN user ON ".$table.".maker_denda=user.id_user
			WHERE ".$table.".tanggal_denda
			BETWEEN '".$awal."'
			AND '".$akhir."'"
		)->getResult();
	}

	public function filter_e($table, $awal, $akhir) {
		return $this->db->query(
			"SELECT *
			FROM ".$table."
			JOIN kelas ON ".$table.".id_kelas=kelas.id_kelas
			JOIN user ON ".$table.".maker_p=user.id_user
			WHERE ".$table.".tanggal_p
			BETWEEN '".$awal."'
			AND '".$akhir."'"
		)->getResult();
	}
	// public function filter3 ($table,$table2,$awal,$akhir)
	// {
	// 	return $this->db->query(
	// 		"SELECT *
	// 		FROM ".$table."
	// 		join dta_jabatan
	// 		on ".$table.".id_jabatan=dta_jabatan.id_jabatan
	// 		WHERE ".$table.".tanggal_karyawan
	// 		BETWEEN '".$awal."'
	// 		and '".$akhir."'"

	// 	)->getResult();
	// }

	public function filter5($table, $awal, $akhir) {
		return $this->db->query(
			"SELECT *
			FROM ".$table."
			JOIN barang ON ".$table.".id_barang=barang.id_barang
			JOIN user ON ".$table.".maker_keluar=user.id_user
			WHERE ".$table.".tanggal_keluar
			BETWEEN '".$awal."'
			AND '".$akhir."'"
		)->getResult();
	}

	public function filter3($table, $awal, $akhir) {
		return $this->db->query(
			"SELECT *
			FROM ".$table."
			JOIN dta_jabatan ON ".$table.".id_jabatan=dta_jabatan.id_jabatan
			JOIN dta_departement ON ".$table.".id_departement=dta_departement.id_departement
			JOIN user ON ".$table.".maker=user.id_user
			WHERE ".$table.".tanggal_karyawan
			BETWEEN '".$awal."'
			AND '".$akhir."'"
		)->getResult();
	}


	public function tes ($table)
	{
		return $this->db->query("
			SELECT *
			FROM ".$table."
			ORDER BY kode DESC
			")->getRow();
	}

	public function kodeJabatan ()
	{
		return $this->db->query("
			SELECT *
			FROM dta_jabatan
			ORDER BY kode_jabatan DESC
			")->getRow();
	}

	// public function filter ($table, $awal,$akhir)
	// {
	// 	return $this->db->table($table)->getWhere($where)->getResult();

	// 	return $this->db->query("
	// 	    SELECT *
	// 	    FROM ".$table."
	// 	    WHERE ".$table.".tanggal_transaksi
	// 	    BETWEEN '".$awal."'
	// 	    AND '".$akhir."'
	// 	")->getResult();
	// }

	public function filter($table, $awal, $akhir)
	{
		if (!empty($awal) && !empty($akhir)) {
			return $this->db->table($table)
			->where('tanggal_laporan >=', $awal)
			->where('tanggal_laporan <=', $akhir)
			->get()
			->getResult();
		} else {
			return [];
		}
	}


// public function filter ($table, $awal,$akhir)
// 	{
// 		$sql = "SELECT *
//         FROM $table
//         WHERE tanggal BETWEEN ? AND ?";
// 		$query = $this->db->query($sql, array($awal, $akhir));
// 		$result = $query->getResult();
// 		return $result;
// 	}

	// public function filter ($table,$awal,$akhir)
	// {

	// 	return $this->db->query(
	// 		"SELECT *
	// 		FROM ".$table."
	// 		join user
	// 		on ".$table.".maker_barang=user.id_user
	// 		WHERE ".$table.".tanggal_barang
	// 		BETWEEN '".$awal."'
	// 		and '".$akhir."'"

	// 	)->getResult();
	// }

	public function filter_c ($table, $awal,$akhir)
	{
		return $this->db->table($table)->getWhere($where)->getResult();

		return $this->db->query("
			SELECT *
			FROM ".$table."
			WHERE ".$table.".tanggal_k
			BETWEEN '".$awal."'
			AND '".$akhir."'
			")->getResult();
	}

	public function filter_b ($table,$awal,$akhir)
	{
		return $this->db->query("
			SELECT *
			FROM ".$table."
			join karyawan
			on ".$table.".id_user=karyawan.id_user
			WHERE ".$table.".tanggal
			BETWEEN '".$awal."'
			and '".$akhir."'"

		)->getResult();
	}

	// public function filter_f ($table,$awal,$akhir)
	// {
	// 	return $this->db->query("
	// 		SELECT *
	// 		FROM ".$table."
	// 		join karyawan
	// 		on ".$table.".id_user=karyawan.id_user
	// 		join barang
	// 		on ".$table.".id_brg=barang.id_brg
	// 		WHERE ".$table.".tanggal
	// 		BETWEEN '".$awal."'
	// 		and '".$akhir."'"

	// 	    )->getResult();
	// }

	public function hapus($table, $where)
	{
		return $this->db->table($table)->delete($where);
	}

	public function simpan($table, $data)
	{
		return $this->db->table($table)->insert($data);
	}

	public function getWhere($table, $where)
	{
		return $this->db->table($table)->getWhere($where)->getResult();
	}

	public function getRow($table, $where)
	{
		return $this->db->table($table)->getWhere($where)->getRow();
	}

	public function edit_pp($table, $where)
	{
		return $this->db->table($table)->getWhere($where)->getRow();
	}

	public function getarray($table, $where)
	{
		return $this->db->table($table)->getWhere($where)->getRowArray();
	}

	public function edit($table, $data, $where)
	{
		return $this->db->table($table)->update($data, $where);
	}

	public function edit_coba($table, $data, $where)
	{
    return $this->db->table($table)->where($where)->update($data);
	}


	public function fusion($table1, $table2, $on)
	{
		return $this->db->table($table1)->join($table2, $on)->get()->getResult();
	}

	public function fusionArray($table1, $table2, $table3, $on, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->getWhere($where)->getRowArray();
	}

	public function fusion_where($table1, $table2, $on,$where)
	{
		return $this->db->table($table1)->join($table2, $on)->getWhere($where)->getResult();
	}

	public function fusionOderBy($table1, $table2, $on, $column)
	{
		return $this->db->table($table1)->join($table2, $on)->orderBy($column, 'DESC')->get()->getResult();
	}

	public function monsterOderBy($table1, $table2, $table3, $table4, $table5, $on, $on2, $on3, $on4, $column)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->join($table5, $on4)->orderBy($column, 'DESC')->get()->getResult();
	}

	public function siswaOderBy($table1, $table2, $table3, $table4, $table5, $on, $on2, $on3, $on4, $column)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->join($table5, $on4)->orderBy($column, 'DESC')->get()->getResult();
	}

	public function fusion_Row($table1, $table2, $on,$where)
	{
		return $this->db->table($table1)->join($table2, $on)->getWhere($where)->getRow();
	}

	public function fusionleft($table1, $table2, $on)
	{
		return $this->db->table($table1)->join($table2, $on, 'left')->get()->getResult();
	}

	public function super($table1, $table2, $table3, $on, $on2)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->get()->getResult();
	}

	public function superLike2($table1, $table2, $on1, $column, $column2, $where)
	{
		return $this->db->table($table1)->join($table2, $on1)->groupStart()->like($column, $where)->orLike($column2, $where)->groupEnd()->get()->getResult();
	}

	public function superLikebm($table1, $table2, $table3, $on1, $on2, $column, $column2, $column3, $where, $where2)
	{
		return $this->db->table($table1)->join($table2, $on1)->join($table3, $on2)->groupStart()->like($column, $where)->orLike($column2, $where)->orLike($column3, $where)->groupEnd()->where($where2)->get()->getResult();
	}

	public function superLike_vm ($table1, $table2, $table3, $on1, $on2, $column, $column2,$where)
	{
		return $this->db->table($table1)->join($table2, $on1)->join($table3, $on2)->groupStart()->like($column, $where)->orLike($column2, $where)->groupEnd()->get()->getResult();
	}

	public function superLike_iis ($table1, $table2, $table3, $on1, $on2, $column, $column2, $column3, $where)
	{
		return $this->db->table($table1)->join($table2, $on1)->join($table3, $on2)->groupStart()->like($column, $where)->orLike($column2, $where)->orLike($column3, $where)->groupEnd()->get()->getResult();
	}

	public function superLikeLog($table1, $table2, $on1, $column, $column2, $where, $where2)
	{
		return $this->db->table($table1)->join($table2, $on1)->groupStart()->like($column, $where)->orLike($column2, $where)->groupEnd()->where($where2)->get()->getResult();
	}
	
	public function superLike3($table1, $table2, $on1, $column, $column2, $column3, $where)
	{
		return $this->db->table($table1)->join($table2, $on1)->groupStart()->like($column, $where)->orLike($column2, $where)->orLike($column3, $where)->groupEnd()->get()->getResult();
	}

	public function superLikeS($table1, $table2, $on1, $column, $column2, $column3, $where, $where2)
	{
		return $this->db->table($table1)->join($table2, $on1)->groupStart()->like($column, $where)->orLike($column2, $where)->orLike($column3, $where)->groupEnd()->where($where2)->get()->getResult();
	}

	public function superLike5($table1, $table2, $table3, $table4, $on1, $on2, $on3, $column, $column2, $column3, $column4, $column5, $where)
	{
        return $this->db->table($table1)->join($table2, $on1)->join($table3, $on2)->join($table4, $on3)->groupStart()->like($column, $where)->orLike($column2, $where)->orLike($column3, $where)->orLike($column4, $where)->orLike($column5, $where)->groupEnd()->get()->getResult();
	}

	public function superLikeAngsuran($table1, $table2, $table3, $table4, $on1, $on2, $on3, $column, $column2, $column3, $column4, $column5, $where, $where2)
	{
        return $this->db->table($table1)->join($table2, $on1)->join($table3, $on2)->join($table4, $on3)->groupStart()->like($column, $where)->orLike($column2, $where)->orLike($column3, $where)->orLike($column4, $where)->orLike($column5, $where)->groupEnd()->where($where2)->get()->getResult();
	}

	public function search_log($table1, $table2, $on1, $column, $where)
	{
		return $this->db->table($table1)->join($table2, $on1)->like($column, $where)->get()->getResult();
	}

	public function superOderBy($table1, $table2, $table3, $on, $on2, $column)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->orderBy($column, 'DESC')->get()->getResult();
	}

	public function invoice ($table1, $table2, $table3, $on, $on2, $column, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->orderBy($column, 'DESC')->getWhere($where)->getResult();
	}

	public function ultraOderBy($table1, $table2, $table3, $table4, $on, $on2, $on3, $column)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->orderBy($column, 'DESC')->get()->getResult();
	}

	public function superOderByWhere($table1, $table2, $table3, $on, $on2, $column,$where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->orderBy($column, 'DESC')->getWhere($where)->getResult();
	}

	public function superData($table1, $table2, $table3, $table4, $on, $on2, $on3, $column, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->orderBy($column, 'ASC')->getWhere($where)->getResult();
	}

	public function superDataDouble($table1, $table2, $table3, $on, $on2, $column, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->orderBy($column, 'DESC')->getWhere($where)->getResult();
	}

	public function fusionDataDouble($table1, $table2,  $on,  $column, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->orderBy($column, 'DESC')->getWhere($where)->getResult();
	}

	public function fusionOderByWhere($table1, $table2, $on, $column, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->orderBy($column, 'DESC')->getWhere($where)->getResult();
	}

	public function bayar($table1, $table2, $on, $column, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->orderBy($column, 'ASC')->getWhere($where)->getRow();
	}

	public function ultra($table1, $table2, $table3, $table4, $on, $on2, $on3)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->get()->getResult();
	}

	public function monster($table1, $table2, $table3, $table4, $table5, $on, $on2, $on3, $on4)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->join($table5, $on4)->get()->getResult();
	}

	public function ultraRow($table1, $table2, $table3, $table4, $on, $on2, $on3, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->getWhere($where)->getRow();
	}

	public function edit_kategori($table1, $table2, $on, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->getWhere($where)->getRow();
	}

	public function getwhereIn($table, $column, $whereIn)
	{
		return $this->db->table($table)->whereIn($whereInColumn, $whereInValues)->update([$columnToUpdate => $newValue]);
	}

	public function edit_keranjang($table1, $table2, $table3, $on, $on2, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->getWhere($where)->getRow();
	}

	public function edit_siswa($table1, $table2, $table3, $table4, $table5, $on, $on2, $on3, $on4, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->join($table5, $on4)->getWhere($where)->getRow();
	}

	public function detail($table1, $table2, $on, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->getWhere($where)->getRow();
	}

	public function detail_vm ($table1, $table2, $table3, $on, $on2, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->getWhere($where)->getRow();
	}

	public function detail_angsuran($table1, $table2, $table3, $table4, $on, $on2, $on3, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->getWhere($where)->getRow();
	}

	public function detail_s($table1, $table2, $table3, $table4, $table5, $on, $on2, $on3, $on4, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->join($table5, $on4)->getWhere($where)->getRow();
	}

	public function detail_siswa($table1, $table2, $table3, $table4, $table5, $on, $on2, $on3, $on4, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->join($table5, $on4)->getWhere($where)->getRow();
	}

	public function spp_test($table1, $table2, $table3, $on, $on2, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->getWhere($where)->getRow();
	}

	public function fusionRows($table1, $table2, $on, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->getWhere($where)->getRow();
	}

	public function monsterRows($table1, $table2, $table3, $table4, $table5, $on, $on2, $on3, $on4, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->join($table5, $on4)->getWhere($where)->getRow();
	}

	public function ultraRows($table1, $table2, $table3,  $on, $on2, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->getWhere($where)->getRow();
	}

	public function klsRows($table1, $table2, $table3, $table4, $on, $on2, $on3, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->getWhere($where)->getRow();
	}

	public function bayar_invoice($table1, $table2, $on, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->getWhere($where)->getRow();
	}

	public function superRows($table1, $table2, $table3,  $on, $on2, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->getWhere($where)->getRow();
	}

	public function edit_invoice($table1, $table2, $table3, $table4, $on, $on2, $on3, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->getWhere($where)->getRow();
	}

	public function superRowsAsc($table1, $table2, $table3,  $on, $on2, $column, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->orderBy($column, 'ASC')->getWhere($where)->getRow();
	}
	
	public function tesRows($table1, $table2, $on, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->getWhere($where)->getRow();
	}

	public function ultraOrderBy($table1, $table2, $table3, $table4, $on, $on2, $on3, $column)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->orderBy($column, 'DESC')->get()->getResult();
	}
	
	public function ultra_bayar($table1, $table2, $table3, $table4, $on, $on2, $on3, $where)
	{
		return $this->db->table($table1)->join($table2, $on, 'left')->join($table3, $on2, 'left')->join($table4, $on3, 'left')->getwhere($where)->getResult();
	}

	public function details()
	{
		return $this->db->table('dta_departement')->orderBy('tanggal', 'DESC')->get()->getResult();
	}

	public function deleteData($data_id)
	{
		return $this->db->table($this->table)->where('id', $data_id)->delete();
	}

	public function tampilW($table1, $table2, $on, $where)
	{
		return $this->db->table($table1)->join($table2, $on, 'left')->getWhere($where)->getResult();
	}

	public function like2($table,$column,$column2, $where)
	{
		$this->db->table($table)
		->groupStart()
		->like($column, $where[$column])
		->orLike($column2, $where[$column2])
		->groupEnd();

		return $this->db->get()->getResult();
	}
	
	public function asc_date($table1, $table2, $table3, $table4, $on, $on2, $on3, $column)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->orderBy($column, 'ASC')->get()->getResult();
	}

	public function log($table1, $table2, $on, $where, $column)
	{
		return $this->db->table($table1)->join($table2, $on)->where($where)->orderBy($column, 'DESC')->get()->getResult();
	}

	public function hapusSemua($table)
	{
		$this->db->table($table)->emptyTable();
	}

	public function hapusKeranjangByIdUser($table, $id_user)
	{
		$this->db->table($table)->where('id_user', $id_user)->delete();
	}

	public function outbound_items ($table1, $table2, $table3, $on, $on2, $column, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->orderBy($column, 'DESC')->getWhere($where)->getResult();
	}

	public function angsuran($table1, $table2, $table3, $table4, $on, $on2, $on3, $column, $where)
	{
		return $this->db->table($table1)->join($table2, $on)->join($table3, $on2)->join($table4, $on3)->orderBy($column, 'ASC')->getWhere($where)->getResult();
	}

	public function getMakerKendaraan($id_kendaraan)
	{
	    return $this->db->table('kendaraan')
	        ->select('maker_kendaraan')
	        ->where('id_kendaraan', $id_kendaraan)
	        ->get()
	        ->getRow()
	        ->maker_kendaraan;
	}

}