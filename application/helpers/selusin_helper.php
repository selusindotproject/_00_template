<?php
defined('BASEPATH') or exit('No direct script access allowed');




/**
 * update hak akses
 */
function updateHakAkses($idMenu)
{

    // set variable $this
    $ci =& get_instance();

    /**
     * collect data groups
     */
    $q = "select * from " . TABLE_GROUPS;
    $dataGroups = $ci->db->query($q)->result();

    // simpan data ke tabel t90_groups_menus (groups hak akses)
    foreach($dataGroups as $row) {
        $data = array(
            'idgroups' => $row->id,
            'idmenu' => $idMenu,
            'rights' => 7,
        );
        $ci->db->insert(TABLE_HAKAKSES, $data);
    }
}



/**
 * create hak akses for new groups
 */
function createHakAkses($idgroups)
{

    // set variable $this
    $ci =& get_instance();

    /**
     * collect data menus
     */
    $q = "select * from " . TABLE_MENU . " where nama <> '#'";
    $dataMenu = $ci->db->query($q)->result();

    foreach($dataMenu as $row) {
        $data = array(
            'idgroups' => $idgroups,
            'idmenu' => $row->id,
            'rights' => 0,
        );
        $ci->db->insert(TABLE_HAKAKSES, $data);
    }
}




/**
 * get hak akses berdasarkan idusers = user_id dan idmenus
 */
function getHakAkses($modulName)
{
    // set variable $this
    $ci =& get_instance();

    // ambil nilai id menu dari tabel master menu
    $ci->db->where('kode', $modulName);
    $idMenu = $ci->db->get('t89_menu')->row()->id;

    // ambil nilai id groups sesuai user yang login
    $idGroups = $ci->ion_auth->get_users_groups()->row()->id;

    // ambil nilai hak akses
    $ci->db->where('idgroups', $idGroups);
    $ci->db->where('idmenu', $idMenu);
    $row = $ci->db->get('t90_groups_menu')->row();
    $hakAkses = array('tambah' => false, 'ubah' => false, 'hapus' => false);

    // tentukan hak akses
    if ($row) {
        switch ($row->rights) {
            case 1:
                $hakAkses = array('tambah' => true, 'ubah' => false, 'hapus' => false);
                break;
            case 2:
                $hakAkses = array('tambah' => false, 'ubah' => true, 'hapus' => false);
                break;
            case 3:
                $hakAkses = array('tambah' => true, 'ubah' => true, 'hapus' => false);
                break;
            case 4:
                $hakAkses = array('tambah' => false, 'ubah' => false, 'hapus' => true);
                break;
            case 5:
                $hakAkses = array('tambah' => true, 'ubah' => false, 'hapus' => true);
                break;
            case 6:
                $hakAkses = array('tambah' => false, 'ubah' => true, 'hapus' => true);
                break;
            case 7:
                $hakAkses = array('tambah' => true, 'ubah' => true, 'hapus' => true);
                break;
        }
    }
    return $hakAkses;
}




/**
 * buat saldo awal baru berdasarkan periode_id baru
 */
function buatSaldoawal($periode_id)
{
    $ci =& get_instance();

    // ambil saldo awal
    $q = "
        select
    ";


}




/**
 * ambil nilai nomor jurnal baru
 * parameter ::
 * 'PJ', 'PJ', 'nomor', 't76_jurnal'
 */
 function getNewNomorJurnal($kodeJurnal, $tanggal)
 {

     $CI =& get_instance();

     if ($tanggal != null) {
         // echo pre(dateMysql($date)); exit;
     }

     $nextNomorJurnal = "";
     $lastNomorJurnal = "";

     $prefix = $tanggal != null ? $kodeJurnal . substr($tanggal, -2) . substr($tanggal, 3, 2) : $kodeJurnal . date('ym'); // date('ym');
     $nextNomorJurnal = $prefix . "001";

     $CI->db->where('left(nomor, 6) = ', $prefix);
     $CI->db->order_by('nomor', 'desc');
     $CI->db->limit(1);
     $row = $CI->db->get('t76_jurnal')->row();
     if ($row) {
         $value = $row->nomor;
         if ($prefix == substr($value, 0, 6)) {
             /**
              * masih pada bulan yang sama
              */
             $lastNomorJurnal = intval(substr($value, 6, 3));
             $lastNomorJurnal = intval($lastNomorJurnal) + 1;
             $nextNomorJurnal = $prefix . sprintf('%03s', $lastNomorJurnal);
             if (strlen($nextNomorJurnal) > 9) {
                 $nextNomorJurnal = $prefix . "999";
             }
         }
     }
     return $nextNomorJurnal;
 }




/**
 * check data periode
 */
//
function checkPeriode($date = null)
{

    if ($date == null) {
        $date = date('Y-m-d');
    } else {
        $date = dateMysql($date);
    }

    $CI =& get_instance();
    $CI->db->where("'" . $date . "' between `start_` and `end`");

    $row = $CI->db->get('t73_periode')->row();
    // jika periode belum ada, maka
    if (!$row) {

        // simpan periode_id terakhir sebelum tambah baru
        $q = "
            select periode_id from t73_periode order by periode_id desc limit 1
        ";
        $CI->db->query($q)->row();

        // buat periode baru sesuai parameter $date
        $CI->db->insert('t73_periode', array('start_' => date('Y-m-01'), 'end' => date('Y-m-t'), 'isaktif' => 1));

        // simpan periode_id baru
        $periode_id = $CI->db->insert_id();

        /**
         * buat data saldo awal baru
         */
        buatSaldoawal($periode_id);

        return $periode_id;
    } else {
        return $row->id;
    }

}




/**
 * posting penjualan by contoh kang bani wordpress
 */
function postingPenjualan($kodeJurnal, $tanggal, $keterangan, $total, $ppn)
{

    $CI =& get_instance();

    // ambil nilai tipejurnal_id
    $CI->load->model('t75_tipejurnal/T75_tipejurnal_model');
    $tipejurnal_id = $CI->T75_tipejurnal_model->get_by_kode($kodeJurnal)->id;

    // ambil nilai periode_id
    // $this->load->model('t73_periode/T73_periode_model');
    // $periode_id = checkPeriode($tanggal);
    $periode_id = 1;

    // header jurnal
    $CI->db->insert('t76_jurnal', array(
        'tipejurnal_id' => $tipejurnal_id,
        'periode_id' => $periode_id,
        'tanggal' => dateMysql($tanggal),
        'nomor' => getNewNomorJurnal($kodeJurnal, $tanggal),
        'keterangan' => $keterangan,
    ));

    $jurnal_id = $CI->db->insert_id();

    $CI->load->model('t72_akun/T72_akun_model');

    // detail jurnal, akun piutang usaha
    $akun = $CI->T72_akun_model->get_by_kode(getSetting('piutang_usaha'))->id;
    $CI->db->insert('t77_jurnald', array(
        'jurnal_id' => $jurnal_id,
        'akun_id' => $akun,
        'debet' => $total + $ppn,
        'kredit' => 0,
    ));

    // detail jurnal, akun pendapatan
    $akun = $CI->T72_akun_model->get_by_kode(getSetting('pendapatan'))->id;
    $CI->db->insert('t77_jurnald', array(
        'jurnal_id' => $jurnal_id,
        'akun_id' => $akun,
        'debet' => 0,
        'kredit' => $total,
    ));

    // detail jurnal, akun ppn_keluaran
    $akun = $CI->T72_akun_model->get_by_kode(getSetting('ppn_keluaran'))->id;
    $CI->db->insert('t77_jurnald', array(
        'jurnal_id' => $jurnal_id,
        'akun_id' => $akun,
        'debet' => 0,
        'kredit' => $ppn,
    ));

}




/**
 * posting penjualan
 */
function postingPenjualan0(
    $tglJurnal, $kodeJurnal, $keterangan, $jenisTransaksi, $nomorTransaksi,
    $totalNominalPenjualanNonPpn, $totalNominalPpn, $pendapatanLain)
{
    /**
     * ambil akun piutang usaha dan akun pendapatan
     */
    $akunPiutangUsaha = getSetting('piutang_usaha');
    $akunPendapatan = getSetting('pendapatan');

    /**
     * check akun
     */
    if ($akunPiutangUsaha != false && $akunPendapatan != false) {

        $CI =& get_instance();

        /**
         * hitung total jurnal
         */
        $CI->db->where("tanggal between '" . date('Y-m-01', strtotime($tglJurnal)) . "' and '" . date('Y-m-d', strtotime($tglJurnal)) . "'");
        $totalJurnal = $CI->db->count_all_results('t86_jurnal');

        /**
         * create nomor jurnal
         */
        // $nomorJurnal = createNomorJurnal($totalJurnal, $tglJurnal, $kodeJurnal);
        $nomorJurnal = 'J' . $kodeJurnal . date("y", strtotime($tglJurnal)) . date("m", strtotime($tglJurnal)) . str_pad($totalJurnal + 1, 3, "0", STR_PAD_LEFT);

        /**
         * create header jurnal
         * input data di tabel header jurnal
         * t86_jurnal
         */
        // createHeaderJurnal($tglJurnal, $nomorJurnal, $keterangan, $jenisTransaksi, $nomorTransaksi);
        $data = array(
            'nomor' => $nomorJurnal,
            'tanggal' => dateMysql($tglJurnal),
            'keterangan' => $keterangan,
            'transaksi_jenis' => $jenisTransaksi,
            'transaksi_nomor' => $nomorTransaksi,
        );
        $CI->db->insert('t86_jurnal', $data);

        /**
         * simpan idjurnal
         */
        $idjurnal = $CI->db->insert_id();

        /**
         * index urutan
         * belum tau ini diperlukan atau tidak di program
         */
        $urutan = 1;

        /**
         * create detail jurnal
         * input data di tabel detail jurnal
         * t87_jurnald
         */
        //piutang customer
        $data = array(
            'idjurnal' => $idjurnal,
            'nilai_debet' => $totalNominalPenjualanNonPpn + $totalNominalPpn + $pendapatanLain,
            'nilai_kredit' => 0,
            'akun' => $akunPiutangUsaha,
            'keterangan' => '',
        );
        $CI->db->insert('t87_jurnald', $data);
        $urutan += 1;

        //penjualan
        $data = array(
            'idjurnal' => $idjurnal,
            'nilai_debet' => 0,
            'nilai_kredit' => $totalNominalPenjualanNonPpn,
            'akun' => $akunPendapatan,
            'keterangan' => '',
        );
        $CI->db->insert('t87_jurnald', $data);
        $urutan += 1;

        /**
         * posting laba rugi
         */
        // PostingMutasiLaba($tgl_jurnal, $coa->pendapatan, 0, $total_nominal_penjualan_non_ppn, $kode_jenis_transaksi, $nomor_transaksi);
        // postingMutasiLaba($tglJurnal, $akunPendapatan, 0, $totalNominalPenjualanNonPpn, $jenisTransaksi, $nomorTransaksi);
        $data = array(
            'tanggal' => dateMysql($tglJurnal),
            'transaksi_jenis' => $jenisTransaksi,
            'transaksi_nomor' => $nomorTransaksi,
            'nominal' => $totalNominalPenjualanNonPpn,
        );
        $CI->db->insert('t84_mutasilaba', $data);

        /**
         * check nominal ppn
         */
        if ($totalNominalPpn > 0) {
            // Helpers::InsertDetailJurnal($urutan, $nomor_jurnal, 0, $total_nominal_ppn, $coa->ppnterhutang );
            $akunPpnTerhutang = getSetting('ppn_terhutang');
            // ppn penjualan
            $data = array(
                'idjurnal' => $idjurnal,
                'nilai_debet' => 0,
                'nilai_kredit' => $totalNominalPpn,
                'akun' => $akunPpnTerhutang,
                'keterangan' => '',
            );
            $CI->db->insert('t87_jurnald', $data);
            $urutan += 1;
        }

        /**
         * check nominal pendapatan lain2
         */
        if ($pendapatanLain > 0) {
            // Helpers::InsertDetailJurnal($urutan, $nomor_jurnal, 0, $pendapatanlain, $coa->pendapatanlain );
            $akunPendapatanLain = getSetting('pendapatan_lain');
            // pendapatan lain
            $data = array(
                'idjurnal' => $idjurnal,
                'nilai_debet' => 0,
                'nilai_kredit' => $pendapatanLain,
                'akun' => $akunPendapatanLain,
                'keterangan' => '',
            );
            $CI->db->insert('t87_jurnald', $data);
            $urutan += 1;
        }

        /**
         * hitung perubahan akun bulan ini dan bulan berikutnya
         */
        //
        // Helpers::Hitung_Perubahan_Akun_Bulan_Ini_Dan_Berikutnya($nomor_jurnal, $tgl_jurnal);
        // rekalkulasiAkun();


    }
}




/**
 * create header jurnal
 */
function createHeaderJurnal($tglJurnal, $nomorJurnal, $keterangan, $jenisTransaksi, $nomorTransaksi)
{
    // code...
    $CI =& get_instance();
    $data = array(
        'nomor' => $nomorJurnal,
        'tanggal' => dateMysql($tglJurnal),
        'keterangan' => $keterangan,
        'transaksi_jenis' => $jenisTransaksi,
        'transaksi_nomor' => $nomorTransaksi,
    );
    $CI->db->insert('t86_jurnal', $data);
}




/**
 * create nomor jurnal baru
 */
function createNomorJurnal($totalJurnal, $tglJurnal, $kodeJurnal)
{
    // code...
    // public static function CreateNomorJurnal($total_jurnal, $tgl_jurnal, $kode_jurnal){ //create nomor jurnal
        // $nomor_jurnal = 'J'.$kode_jurnal.date("y", strtotime($tgl_jurnal) ).date("m", strtotime($tgl_jurnal)).str_pad($total_jurnal+1, 3, "0", STR_PAD_LEFT);
        // return $nomor_jurnal;
    // }
    $nomorJurnal = 'J' . $kodeJurnal . date("y", strtotime($tglJurnal)) . date("m", strtotime($tglJurnal)) . str_pad($totalJurnal + 1, 3, "0", STR_PAD_LEFT);
    return $nomorJurnal;
}




/**
 * hitung total jumlah jurnal
 * untuk keperluan create nomor jurnal baru
 * berdasarkan nomor jurnal terakhir
 */
function hitungTotalJurnal($tglJurnal)
{
    // $GlobalJurnal = GlobalJurnal::find(array(
    //                 "tanggal >= :tglAwal: and tanggal <= LAST_DAY(:tglAkhir:) ",
    //                 "bind" => array(
    //                     "tglAwal" =>date("Y-m-01 00:00:00", strtotime($tgl_jurnal)),
    //                     "tglAkhir" =>date("Y-m-d 23:59:59", strtotime($tgl_jurnal)),
    //                 ),
    // ));

    $CI =& get_instance();
    $CI->db->where("tanggal between '" . date('Y-m-01', strtotime($tglJurnal)) . "' and '" . date('Y-m-d', strtotime($tglJurnal)) . "'");

    // echo $CI->db->get_compiled_select('t86_jurnal');

    // $totalJurnal = $GlobalJurnal->count();
    $totalJurnal = $CI->db->count_all_results('t86_jurnal');

    return $totalJurnal;
}




/**
 * ambil setting:: nama setting dan nilai setting
 * bila diisi parameter:: maka hanya diambil sesuai parameter
 * bila tanpa parameter:: maka diambil semua setting
 */
function getSetting($nama = null)
{
    // $sNextKode = "";
    // $sLastKode = "";
    $CI =& get_instance();
    // $CI->db->order_by($fieldName, 'desc');
    // $CI->db->limit(1);
    if ($nama != null) {
        $CI->db->where('nama', $nama);
    }
    $row = $CI->db->get('t85_setting')->row();
    if ($row) {
        return $row->nilai;
    } else {
        return false;
    }
}




/**
 * mengubah format tanggal
 * menjadi format dd-mm-yyyy
 */
function dateIndo($value)
{
    return date_format(date_create($value), 'd-m-Y');
}




/**
 * mengubah format tanggal
 * menjadi format yyyy-mm-dd
 */
function dateMysql($value)
{
    return date('Y-m-d', strtotime(str_replace('/', '-', $value)));
}




/**
 * menampilkan nilai variabel
 */
function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
