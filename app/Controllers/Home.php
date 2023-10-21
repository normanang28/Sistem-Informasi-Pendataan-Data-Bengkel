<?php

namespace App\Controllers;
use CodeIgniter\Controllers;
use App\Models\M_model;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends BaseController
{
    public function index()
    {
        if(session()->get('level')!= null) {
        $previousURL = previous_url(); 
        
        if ($previousURL) {
            return redirect()->to($previousURL); 
        }

        }else{

            $model=new M_model();
            $where=array('dipakai'=>'Y');
            
            $cekSekolah=$model->getRow('settings_website',$where);
            session()->set('foto_sekolah',$cekSekolah->foto);
            session()->set('text_sekolah',$cekSekolah->text);
            session()->set('login_sekolah',$cekSekolah->login);
            session()->set('nama_website',$cekSekolah->nama_website);

            echo view('login');
        }
    }
    
    public function aksi_login()
    {
        $n=$this->request->getPost('username'); 
        $p=$this->request->getPost('password');

        $captchaResponse = $this->request->getPost('g-recaptcha-response');
        $captchaSecretKey = '6Le4D6snAAAAAHD3_8OPnw4teaKXWZdefSyXn4H3';

        $verifyCaptchaResponse = file_get_contents(
            "https://www.google.com/recaptcha/api/siteverify?secret={$captchaSecretKey}&response={$captchaResponse}"
        );

        $captchaData = json_decode($verifyCaptchaResponse);

        if (!$captchaData->success) {

            session()->setFlashdata('error', 'CAPTCHA verification failed. Please try again.');
            return redirect()->to('/Home');
        }

        $model= new M_model();
        $data=array(
            'username'=>$n, 
            'password'=>md5($p)
        );
        $cek=$model->getarray('user', $data);
        if ($cek>0) {
            $where=array('id_user_karyawan'=>$cek['id_user']);
            $karyawan=$model->getarray('karyawan', $where);

                if ($karyawan) { 
                session()->set('id', $cek['id_user']);
                session()->set('username', $cek['username']);
                session()->set('nama_karyawan', $karyawan['nama_karyawan']);
                session()->set('level', $cek['level']);

                $id = session()->get('id');
                $kui=array(
                    'id_user_log'=>session()->get('id'),
                    'activity'=>"Login on the system with ID ". $id." ",
                    'datetime'=>date('Y-m-d H:i:s')
                );
                $model->simpan('log_activity',$kui);

                return redirect()->to('/home/dashboard');
            } else {
                $where = array('id_user_pengguna' => $cek['id_user']);
                $pengguna = $model->getarray('pengguna', $where);

                if ($pengguna) { 
                    session()->set('id', $cek['id_user']);
                    session()->set('username', $cek['username']);
                    session()->set('nama_pengguna', $pengguna['nama_pengguna']);
                    session()->set('level', $cek['level']);

                    $kui=array(
                        'id_user_log'=>session()->get('id'),
                        'activity'=>"Login on the system with ID ". $id." ",
                        'datetime'=>date('Y-m-d H:i:s')
                    );
                    $model->simpan('log_activity',$kui);

                    return redirect()->to('/home/dashboard');
                }
            }
        }
        return redirect()->to('/');
    }

    public function register()
    {
        echo view('register');
    }

    public function aksi_register()
    {
        $model=new M_model();

        $nik=$this->request->getPost('nik');
        $nama_pengguna=$this->request->getPost('nama_pengguna');
        $jk_pengguna=$this->request->getPost('jk_pengguna');
        $ttl_pengguna=$this->request->getPost('ttl_pengguna');
        $no_telp_pengguna=$this->request->getPost('no_telp_pengguna');
        $alamat=$this->request->getPost('alamat');
        $username=$this->request->getPost('username');
        $password=$this->request->getPost('password');

        $user=array(
            'username'=>$username,
            'password'=>md5($password),
            'level'=> '4',
        );

        $model=new M_model();
        $model->simpan('user', $user);
        $where=array('username'=>$username);
        $id=$model->getarray('user', $where);
        $iduser = $id['id_user'];

        $pengguna = array(
            'nik' => $nik,
            'nama_pengguna' => $nama_pengguna,
            'jk_pengguna' => 'Data has not been filled in',
            'ttl_pengguna' => 'Data has not been filled in',
            'no_telp_pengguna' => '080000000000',
            'alamat' => 'Data has not been filled in',
            'id_user_pengguna' => $iduser,
        );
        $model->simpan('pengguna', $pengguna);

        return redirect()->to('/');
    }

// SETTINGS CONTROL
    public function settings_control()
    {
        if(session()->get('level')== 1) {

        $id=session()->get('id');
        $where=array('id_settings'=> 1);
        $model=new M_model();
        $pakif['use']=$model->getRow('settings_website',$where);

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('settings', $pakif);
        echo view('template/footer');

        }else {
            return redirect()->to('/');
        }
    }

    public function aksi_change_website_settings()
    {
        $model = new M_model();
        $id = $this->request->getPost('id');
        $where = array('id_settings' => $id);
        
        $logo = array();

        $photo = $this->request->getFile('foto');
        $text = $this->request->getFile('text'); 
        $login = $this->request->getFile('login'); 

        if ($photo && $photo->isValid()) {
            $img = $photo->getRandomName();
            $photo->move(PUBLIC_PATH . '/assets/images/settings_web/', $img);
            $logo['foto'] = $img;
        }

        if ($text && $text->isValid()) {
            $textFileName = $text->getRandomName();
            $text->move(PUBLIC_PATH . '/assets/images/settings_web/', $textFileName);
            $logo['text'] = $textFileName;
        }

        if ($login && $login->isValid()) {
            $loginFileName = $login->getRandomName();
            $login->move(PUBLIC_PATH . '/assets/images/settings_web/', $loginFileName);
            $logo['login'] = $loginFileName;
        }

        $nama_website = $this->request->getPost('nama_website');
        if (!empty($nama_website)) {
            $logo['nama_website'] = $nama_website;
        }

        if (!empty($logo)) {
            $model->edit('settings_website', $logo, $where);
        }

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Editing System Control ". $nama_website." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('/home/log_out');
    }

// LOG-OUT
    public function log_out()
    {
        if(session()->get('id') > 0) {

            $model = new M_model(); 
            session()->destroy();

            $kui=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Log out on the system with ID ". $id." ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$kui);

            return redirect()->to('/');

        } else {
            return redirect()->to('/home/dashboard');
        }
    }

// DASHBOARD
    public function dashboard()
    {
        if(session()->get('id')>0) {

        $model= new M_model();
        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('template/dashboard');
        echo view('template/footer');

        }else{
            return redirect()->to('/');
        }
    }

// EMPLOYEE
    public function employee()
    {
        $model=new M_model();
        $on='karyawan.maker_karyawan=user.id_user';
        $kui['duar']=$model->fusionOderBy('karyawan', 'user', $on,  'tanggal_karyawan');

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('users/employee/employee');
        echo view('template/footer');
    }

    public function add_employee()
    {
        $model=new M_model();
        $on='karyawan.id_user_karyawan=user.id_user';
        $kui['duar']=$model->fusionOderBy('karyawan', 'user', $on,  'tanggal_karyawan');

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('users/employee/add_employee');
        echo view('template/footer');
    }

    public function aksi_add_employee()
    {
        $model=new M_model();

        $nip=$this->request->getPost('nip');
        $nama_karyawan=$this->request->getPost('nama_karyawan');
        $jk_karyawan=$this->request->getPost('jk_karyawan');
        $ttl_karyawan=$this->request->getPost('ttl_karyawan');
        $username=$this->request->getPost('username');
        $level=$this->request->getPost('level');
        $maker_karyawan=session()->get('id');

        $user=array(
            'username'=>$username,
            'password'=>md5('@dmin123'),
            'level'=>$level,
        );

        $model=new M_model();
        $model->simpan('user', $user);
        $where=array('username'=>$username);
        $id=$model->getarray('user', $where);
        $iduser = $id['id_user'];

        $karyawan = array(
            'nip' => $nip,
            'nama_karyawan' => $nama_karyawan,
            'jk_karyawan' => $jk_karyawan,
            'ttl_karyawan' => $ttl_karyawan,
            'id_user_karyawan' => $iduser,
            'maker_karyawan' => $maker_karyawan,

        );
        $model->simpan('karyawan', $karyawan);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Add Employee Accounts By Name ". $nama_karyawan." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('/home/employee');
    }

    public function employee_search()
    {
     if(!session()->get('id') > 0){
        return redirect()->to('/home/dashboard');
    }

    if(session()->get('level')== 1) {

        $model=new M_model();
        $on='karyawan.id_user_karyawan=user.id_user';
        $where=$this->request->getPost('search_employee');
        $kui['duar']=$model->superLike3('karyawan', 'user', $on, 'karyawan.nip','karyawan.nama_karyawan','user.username', $where);
    }

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['search']="on";

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('users/employee/employee');
        echo view('template/footer');
    }

    public function detail_employee($id)
    {
        $model=new M_model();
        $where2=array('id_user_karyawan'=>$id); 
        $on='karyawan.id_user_karyawan=user.id_user';
        $kui['gas']=$model->detail('karyawan', 'user',$on, $where2);

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('users/employee/detail_employee');
        echo view('template/footer');
    }

    public function reset_employee($id)
    {
        $model=new M_model();
        $where=array('id_user'=>$id);
        $data=array(
            'password'=>md5('@dmin123')
        );
        $model->edit('user',$data,$where);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Reset Employee Account Password With ID ". $id." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('/home/employee');
    }

    public function edit_employee($id)
    {
        $model=new M_model();
        $where2=array('karyawan.id_user_karyawan'=>$id);

        $on='karyawan.id_user_karyawan=user.id_user';
        $kui['duar']=$model->edit_user('karyawan', 'user',$on, $where2);

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('users/employee/edit_employee');
        echo view('template/footer');
    }

    public function aksi_edit_employee()
    {
        $id= $this->request->getPost('id');    
        $username= $this->request->getPost('username');
        $level= $this->request->getPost('level');
        $nip= $this->request->getPost('nip');
        $nama_karyawan= $this->request->getPost('nama_karyawan');
        $jk_karyawan= $this->request->getPost('jk_karyawan');
        $ttl_karyawan= $this->request->getPost('ttl_karyawan');
        $maker_karyawan=session()->get('id');

        $where=array('id_user'=>$id);    
        $where2=array('id_user_karyawan'=>$id);
        if ($password !='') {
            $user=array(
                'username'=>$username,
                'level'=>$level,
            );
        }else{
            $user=array(
                'username'=>$username,
                'level'=>$level,
            );
        }

        $model=new M_model();
        $model->edit('user', $user,$where);

        $karyawan=array(
            'nip'=>$nip,
            'nama_karyawan'=>$nama_karyawan,
            'jk_karyawan' => $jk_karyawan,
            'ttl_karyawan'=>$ttl_karyawan,
            'maker_karyawan' => $maker_karyawan,
        );

        $model->edit('karyawan', $karyawan, $where2);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Edit Employee Account By Name ". $nama_karyawan." with ID ". $id." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('/home/employee');
    }

    public function delete_employee($id)
    {
        $model=new M_model();
        $where2=array('id_user'=>$id);
        $where=array('id_user_karyawan'=>$id);
        $model->hapus('karyawan',$where);
        $model->hapus('user',$where2);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Delete Employee Account With ID ". $id." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('/home/employee');
    }

// USER
    public function user()
    {
        $model=new M_model();
        $on='pengguna.id_user_pengguna=user.id_user';
        $kui['duar']=$model->fusionOderBy('pengguna', 'user', $on,  'tanggal_pengguna');

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('users/user/user');
        echo view('template/footer');
    }

    public function user_search()
    {
     if(!session()->get('id') > 0){
        return redirect()->to('/home/dashboard');
    }

    if(session()->get('level')== 1) {

        $model=new M_model();
        $on='pengguna.id_user_pengguna=user.id_user';
        $where=$this->request->getPost('search_user');
        $kui['duar']=$model->superLike3('pengguna', 'user', $on, 'pengguna.nik','pengguna.nama_pengguna','user.username', $where);
    }

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['search']="on";

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('users/user/user');
        echo view('template/footer');
    }

    public function detail_user($id)
    {
        $model=new M_model();
        $where2=array('id_user_pengguna'=>$id); 
        $on='pengguna.id_user_pengguna=user.id_user';
        $kui['gas']=$model->detail('pengguna', 'user',$on, $where2);

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('users/user/detail_user');
        echo view('template/footer');
    }

    public function reset_user($id)
    {
        $model=new M_model();
        $where=array('id_user'=>$id);
        $data=array(
            'password'=>md5('@dmin123')
        );
        $model->edit('user',$data,$where);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Reset User Account Password With ID ". $id." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('/home/user');
    }

    public function delete_user($id)
    {
        $model=new M_model();
        $where2=array('id_user'=>$id);
        $where=array('id_user_pengguna'=>$id);
        $model->hapus('pengguna',$where);
        $model->hapus('user',$where2);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Delete User Account With ID ". $id." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('/home/user');
    }

// ITEMS
    public function items()
    {   
        if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $on='barang.maker_barang=user.id_user';
        $kui['duar']=$model->fusionOderBy('barang', 'user', $on,  'tanggal_barang');

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('items/items');
        echo view('template/footer');

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function items_search()
    {
     if(!session()->get('id') > 0){
        return redirect()->to('/home/dashboard');
    }

    if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $on='barang.maker_barang=user.id_user';
        $where=$this->request->getPost('search_items');
        $kui['duar']=$model->superLike2('barang', 'user', $on, 'barang.nama_barang','barang.jumlah', $where);
    }

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['search']="on";

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('items/items');
        echo view('template/footer');
    }

    public function detail_items($id)
    {
        $model=new M_model();
        $where2=array('id_barang'=>$id); 
        $on='barang.maker_barang=user.id_user';
        $kui['gas']=$model->detail('barang', 'user',$on, $where2);

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('items/detail_items');
        echo view('template/footer');
    }

    public function add_items()
    {
        $model=new M_model();
        $on='barang.maker_barang=user.id_user';
        $kui['duar']=$model->fusionOderBy('barang', 'user', $on,  'tanggal_barang');

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('items/add_items');
        echo view('template/footer');
    }

    public function aksi_add_items()
    {
        $model=new M_model();
        $nama_barang=$this->request->getPost('nama_barang');
        $remark_barang=$this->request->getPost('remark_barang');
        $maker_barang=session()->get('id');
        $data=array(

            'nama_barang'=>$nama_barang,
            'remark_barang'=>$remark_barang,
            'jumlah'=>'0',
            'maker_barang'=>$maker_barang
        );

        try {
            $foto = $this->request->getFile('foto_barang');
            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                $newName = $foto->getRandomName();
                $foto->move(ROOTPATH . '/public/assets/images/barang/', $newName);
                $data['foto_barang'] = $newName; 
            }

            $model->simpan('barang',$data);

            $kui=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Add Data Items By Name ". $nama_barang." ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$kui);

            return redirect()->to('/home/items');
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function edit_items($id)
    {
        $model=new M_model();
        $where2=array('barang.id_barang'=>$id);

        $on='barang.maker_barang=user.id_user';
        $kui['duar']=$model->edit_user('barang', 'user',$on, $where2);

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('items/edit_items');
        echo view('template/footer');
    }

    public function aksi_edit_ikan()
    {
        $model=new M_model();
        $id=$this->request->getPost('id');
        $nama_barang=$this->request->getPost('nama_barang');
        $remark_barang=$this->request->getPost('remark_barang');
        $maker_barang=session()->get('id');
        $data=array(

            'nama_barang'=>$nama_barang,
            'remark_barang'=>$remark_barang,
            'maker_barang'=>$maker_barang
        );

        try {
            $foto = $this->request->getFile('foto_barang');
            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                $newName = $foto->getRandomName();
                $foto->move(ROOTPATH . '/public/assets/images/barang/', $newName);
                $data['foto_barang'] = $newName; 
            }

        $where=array('id_barang'=>$id);
        $model->edit('barang',$data,$where);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Edit Data Items With ID ". $id." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('/home/items');
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function delete_items($id)
    {
        $model=new M_model();
        $where=array('id_barang'=>$id);
        $model->hapus('barang',$where);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Delete Data Items With ID ". $id." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('home/items');
    }

// INCOMING ITEMS
    public function incoming_items()
    {   
        if(session()->get('level')== 2) {

        $model=new M_model();
        $on='barang_masuk.id_masuk_barang=barang.id_barang';
        $on2='barang_masuk.maker_barang_masuk=user.id_user';
        $kui['duar']=$model->superOderBy('barang_masuk', 'barang', 'user', $on, $on2, 'tanggal_barang_masuk');

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('incoming_items/incoming_items');
        echo view('template/footer');

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function incoming_items_search()
    {
     if(!session()->get('id') > 0){
        return redirect()->to('/home/dashboard');
    }

    if(session()->get('level')== 2) {

        $model=new M_model();
        $on='barang_masuk.id_masuk_barang=barang.id_barang';
        $on2='barang_masuk.maker_barang_masuk=user.id_user';
        $where=$this->request->getPost('search_incoming_items');
        $kui['duar']=$model->superLike_iis('barang_masuk', 'barang', 'user', $on, $on2, 'barang.nama_barang','barang_masuk.stok', 'barang_masuk.harga_beli', $where);
    }

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['search']="on";

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('incoming_items/incoming_items');
        echo view('template/footer');
    }

    public function add_incoming_items()
    {
        $model=new M_model();
        $on='barang_masuk.id_masuk_barang=barang.id_barang';
        $on2='barang_masuk.maker_barang_masuk=user.id_user';
        $kui['duar']=$model->superOderBy('barang_masuk', 'barang', 'user', $on, $on2, 'tanggal_barang_masuk');

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        $kui['a']=$model->tampil('barang'); 

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('incoming_items/add_incoming_items');
        echo view('template/footer');
    }

    public function aksi_add_incoming_items()
    {
        $model=new M_model();
        $barang=$this->request->getPost('id_barang');
        $stok=$this->request->getPost('stok');
        $harga_beli=$this->request->getPost('harga_beli');
        $maker_barang_masuk=session()->get('id');
        $data=array(

            'id_masuk_barang'=> $barang,
            'stok'=>$stok,
            'harga_beli'=>$harga_beli,
            'maker_barang_masuk'=>$maker_barang_masuk
        );
            $model->simpan('barang_masuk',$data);

            $kui=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Add Data Incoming Items With ID ". $barang." ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$kui);

            return redirect()->to('/home/incoming_items');
    }

    public function delete_incoming_items($id)
    {
        $model=new M_model();
        $where=array('id_barang_masuk'=>$id);
        $model->hapus('barang_masuk',$where);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Delete Data Incoming Items With ID ". $id." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('home/incoming_items');
    }

// OUTBOUND ITEMS
    public function outbound_items()
    {   
        if(!session()->get('id') > 0){
            return redirect()->to('/home/dashboard');
        }

        if(session()->get('level')== 2) {

        $model=new M_model();
        $on='barang_keluar.id_keluar_barang=barang.id_barang';
        $on2='barang_keluar.maker_barang_masuk=user.id_user';
        $kui['duar']=$model->superOderBy('barang_keluar', 'barang', 'user', $on, $on2, 'tanggal_barang_keluar');

        }

        if(session()->get('level')== 3) {

        $model=new M_model();
        $where=array('username'=>session()->get('username'));
        $on='barang_keluar.id_keluar_barang=barang.id_barang';
        $on2='barang_keluar.maker_barang_masuk=user.id_user';
        $kui['duar']=$model->outbound_items('barang_keluar', 'barang', 'user', $on, $on2, 'tanggal_barang_keluar', $where);

        }

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('outbound_items/outbound_items');
        echo view('template/footer');

    }

    public function outbound_items_search()
    {
     if(!session()->get('id') > 0){
        return redirect()->to('/home/dashboard');
    }

    if(session()->get('level')== 2) {

        $model=new M_model();
        $on='barang_keluar.id_keluar_barang=barang.id_barang';
        $on2='barang_keluar.maker_barang_masuk=user.id_user';
        $where=$this->request->getPost('search_outbound_items');
        $kui['duar']=$model->superLike_iis('barang_keluar', 'barang', 'user', $on, $on2, 'barang.nama_barang','barang_keluar.stok', 'barang_keluar.remark_keluar', $where);
    }

    if(session()->get('level')== 3) {

        $model=new M_model();
        $on='barang_keluar.id_keluar_barang=barang.id_barang';
        $on2='barang_keluar.maker_barang_masuk=user.id_user';
        $where=$this->request->getPost('search_outbound_items');
        $where2=array('username'=>session()->get('username'));

        $kui['duar']=$model->superLikebm('barang_keluar', 'barang', 'user', $on, $on2, 'barang.nama_barang','barang_keluar.stok', 'barang_keluar.remark_keluar', $where, $where2);
    }

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['search']="on";

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('outbound_items/outbound_items');
        echo view('template/footer');
    }

    public function add_outbound_items()
    {
        $model=new M_model();
        $on='barang_keluar.id_keluar_barang=barang.id_barang';
        $on2='barang_keluar.maker_barang_masuk=user.id_user';
        $kui['duar']=$model->superOderBy('barang_keluar', 'barang', 'user', $on, $on2, 'tanggal_barang_keluar');

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        $kui['a']=$model->tampil('barang'); 

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('outbound_items/add_outbound_items');
        echo view('template/footer');
    }

    public function aksi_add_outbound_items()
    {
        $model=new M_model();
        $barang=$this->request->getPost('id_barang');
        $stok=$this->request->getPost('stok');
        $remark_keluar=$this->request->getPost('remark_keluar');
        $maker_barang_masuk=session()->get('id');
        $data=array(

            'id_keluar_barang'=> $barang,
            'stok'=>$stok,
            'remark_keluar'=>$remark_keluar,
            'maker_barang_masuk'=>$maker_barang_masuk
        );
            $model->simpan('barang_keluar',$data);

            $kui=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Add Data Outbound Items With ID ". $barang." ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$kui);

            return redirect()->to('/home/outbound_items');
    }

    public function delete_outbound_items($id)
    {
        $model=new M_model();
        $where=array('id_barang_keluar'=>$id);
        $model->hapus('barang_keluar',$where);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Delete Data Outbound Items With ID ". $id." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('home/outbound_items');
    }

// WORKSHOP
    public function workshop()
    {   
        $model=new M_model();
        $on='bengkel.maker_bengkel=user.id_user';
        $kui['duar']=$model->fusionOderBy('bengkel', 'user', $on, 'tanggal_bengkel');

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('workshop/workshop');
        echo view('template/footer');
    }

    public function workshop_search()
    {
       if(!session()->get('id') > 0){
        return redirect()->to('/home/dashboard');
    }

        if(session()->get('level')== 1) {

            $model=new M_model();
            $on='bengkel.maker_bengkel=user.id_user';
            $where=$this->request->getPost('search_workshop');
            $kui['duar']=$model->superLike2('bengkel', 'user', $on, 'bengkel.nama_bengkel','bengkel.no_bengkel', $where);
        }

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['search']="on";

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view ('workshop/workshop');
        echo view('template/footer');

    }

    public function add_workshop()
    {
        $model=new M_model();
        $on='bengkel.maker_bengkel=user.id_user';
        $kui['duar']=$model->fusionOderBy('bengkel', 'user', $on, 'tanggal_bengkel');

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('workshop/add_workshop');
        echo view('template/footer');
    }

    public function aksi_add_workshop()
    {
        $model=new M_model();
        $nama_bengkel=$this->request->getPost('nama_bengkel');
        $no_bengkel=$this->request->getPost('no_bengkel');
        $alamat_bengkel=$this->request->getPost('alamat_bengkel');
        $maker_bengkel=session()->get('id');
        $data=array(

        'nama_bengkel'=> $nama_bengkel,
        'no_bengkel'=>$no_bengkel,
        'alamat_bengkel'=>$alamat_bengkel,
        'maker_bengkel'=>$maker_bengkel
        );
        $model->simpan('bengkel',$data);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Add Data Workshop By Name ". $nama_bengkel." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('/home/workshop');
    }

    public function edit_workshop($id)
    {
        $model=new M_model();
        $where2=array('bengkel.id_bengkel'=>$id);

        $on='bengkel.maker_bengkel=user.id_user';
        $kui['duar']=$model->edit_user('bengkel', 'user',$on, $where2);

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('workshop/edit_workshop');
        echo view('template/footer');
    }

    public function aksi_edit_workshop()
    {
        $model=new M_model();
        $id=$this->request->getPost('id');
        $nama_bengkel=$this->request->getPost('nama_bengkel');
        $no_bengkel=$this->request->getPost('no_bengkel');
        $alamat_bengkel=$this->request->getPost('alamat_bengkel');
        $maker_bengkel=session()->get('id');
        $data=array(

            'nama_bengkel'=>$nama_bengkel,
            'no_bengkel'=>$no_bengkel,
            'alamat_bengkel'=>$alamat_bengkel,
            'maker_bengkel'=>$maker_bengkel
        );

        $where=array('id_bengkel'=>$id);
        $model->edit('bengkel',$data,$where);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Edit Data Workshop With ID ". $id." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('/home/workshop');
    }

    public function delete_workshop($id)
    {
        $model=new M_model();
        $where=array('id_bengkel'=>$id);
        $model->hapus('bengkel',$where);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Delete Data Workshop With ID ". $id." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('home/workshop');
    }

// REPORT
    public function items_report()
    {
        if(session()->get('level')== 2) {

            $model=new M_model();
            $kui['kunci']='view_items';

            $id=session()->get('id');
            $where=array('id_user'=>$id);
            $kui['foto']=$model->getRow('user',$where);

            echo view('template/header',$kui);
            echo view('template/menu',$kui);
            echo view('report/filter',$kui);
            echo view('template/footer');

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function print_items()
    {
        if(session()->get('level')== 2) {

            $model=new M_model();
            $awal= $this->request->getPost('awal');
            $akhir= $this->request->getPost('akhir');
            $kui['duar']=$model->filter_items('barang',$awal,$akhir);
            // $img = file_get_contents(
            //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

            // $kui['foto'] = base64_encode($img);
            
            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Items Data Reports In Print Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            echo view('report/items_report',$kui);

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function pdf_items()
    {
        if(session()->get('level')== 2) {

            $model=new M_model();
            $awal= $this->request->getPost('awal');
            $akhir= $this->request->getPost('akhir');
            $kui['duar']=$model->filter_items('barang',$awal,$akhir);
            // $img = file_get_contents(
            //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

            // $kui['foto'] = base64_encode($img);
            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Items Data Reports In PDF Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            $dompdf = new\Dompdf\Dompdf();
            $dompdf->loadHtml(view('report/items_report',$kui));
            $dompdf->setPaper('A4','landscape');
            $dompdf->render();
            $dompdf->stream('my.pdf', array('Attachment'=>0));

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function excel_items()
    {
        if (session()->get('level') == 2) {

            $model = new M_model();
            $awal = $this->request->getPost('awal');
            $akhir = $this->request->getPost('akhir');
            $data = $model->filter_items('barang', $awal, $akhir);

            $spreadsheet = new Spreadsheet();

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Items Name')
                ->setCellValue('B1', 'Amount')
                ->setCellValue('C1', 'Remark')
                ->setCellValue('D1', 'Maker');

            $column = 2;

            foreach ($data as $data) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $data->nama_barang)
                    ->setCellValue('B' . $column, $data->jumlah)
                    ->setCellValue('C' . $column, $data->remark_barang)
                    ->setCellValue('D' . $column, $data->username . '/' . $data->tanggal_barang);

                $column++;
            }

            $writer = new XLsx($spreadsheet);
            $fileName = 'Workshop Data Collection Application ~ Items Report (IR)';

            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Items Data Reports In Excel Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            header('Content-type: vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename=' . $fileName . '.xlsx');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        } else {
            return redirect()->to('/home/dashboard');
        }
    }

    public function incoming_items_report()
    {
        if(session()->get('level')== 2) {

            $model=new M_model();
            $kui['kunci']='view_incoming_items';

            $id=session()->get('id');
            $where=array('id_user'=>$id);
            $kui['foto']=$model->getRow('user',$where);

            echo view('template/header',$kui);
            echo view('template/menu',$kui);
            echo view('report/filter',$kui);
            echo view('template/footer');

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function print_incoming_items()
    {
        if(session()->get('level')== 2) {

            $model=new M_model();
            $awal= $this->request->getPost('awal');
            $akhir= $this->request->getPost('akhir');
            $kui['duar']=$model->filter_incoming_items('barang_masuk',$awal,$akhir);
            // $img = file_get_contents(
            //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

            // $kui['foto'] = base64_encode($img);
            
            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Incoming Items Data Reports In Print Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            echo view('report/incoming_items_report',$kui);

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function pdf_incoming_items()
    {
        if(session()->get('level')== 2) {

            $model=new M_model();
            $awal= $this->request->getPost('awal');
            $akhir= $this->request->getPost('akhir');
            $kui['duar']=$model->filter_incoming_items('barang_masuk',$awal,$akhir);
            // $img = file_get_contents(
            //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

            // $kui['foto'] = base64_encode($img);

            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Incoming Items Data Reports In PDF Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            $dompdf = new\Dompdf\Dompdf();
            $dompdf->loadHtml(view('report/incoming_items_report',$kui));
            $dompdf->setPaper('A4','landscape');
            $dompdf->render();
            $dompdf->stream('my.pdf', array('Attachment'=>0));

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function excel_incoming_items()
    {
        if (session()->get('level') == 2) {

            $model = new M_model();
            $awal = $this->request->getPost('awal');
            $akhir = $this->request->getPost('akhir');
            $data = $model->filter_incoming_items('barang_masuk', $awal, $akhir);

            $spreadsheet = new Spreadsheet();

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Items Name')
                ->setCellValue('B1', 'Stok')
                ->setCellValue('C1', 'Purchase Price')
                ->setCellValue('D1', 'Maker');

            $column = 2;

            foreach ($data as $data) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $data->nama_barang)
                    ->setCellValue('B' . $column, $data->stok)
                    ->setCellValue('C' . $column, $data->harga_beli)
                    ->setCellValue('D' . $column, $data->username . '/' . $data->tanggal_barang_masuk);

                $column++;
            }

            $writer = new XLsx($spreadsheet);
            $fileName = 'Workshop Data Collection Application ~ Incoming Items Report (IIR)';

            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Incoming Items Data Reports In Excel Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            header('Content-type: vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename=' . $fileName . '.xlsx');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        } else {
            return redirect()->to('/home/dashboard');
        }
    }

    public function outbound_items_report()
    {
        if(session()->get('level')== 2 || session()->get('level')== 3) {

            $model=new M_model();
            $kui['kunci']='view_outbound_items';

            $id=session()->get('id');
            $where=array('id_user'=>$id);
            $kui['foto']=$model->getRow('user',$where);

            echo view('template/header',$kui);
            echo view('template/menu',$kui);
            echo view('report/filter',$kui);
            echo view('template/footer');

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function print_outbound_items()
    {
        if(session()->get('level')== 2 || session()->get('level')== 3) {

            $model=new M_model();
            $awal= $this->request->getPost('awal');
            $akhir= $this->request->getPost('akhir');
            $username = session()->get('username');

            if (session()->get('level') == 3) {
            $kui['duar'] = $model->filter_outbound_items('barang_keluar', $awal, $akhir, $username);
            } else {
            $kui['duar'] = $model->filter_outbound_items('barang_keluar', $awal, $akhir);
            }

            // $img = file_get_contents(
            //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

            // $kui['foto'] = base64_encode($img);
            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Outbound Items Data Reports In Print Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            echo view('report/outbound_items_report',$kui);

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function pdf_outbound_items()
    {
        if (session()->get('level') == 2 || session()->get('level') == 3) {

            $model = new M_model();
            $awal = $this->request->getPost('awal');
            $akhir = $this->request->getPost('akhir');
            $username = session()->get('username');
            $kui['duar'] = [];

            if (session()->get('level') == 3) {
                $kui['duar'] = $model->filter_outbound_items('barang_keluar', $awal, $akhir, $username);
            } else {
                $kui['duar'] = $model->filter_outbound_items('barang_keluar', $awal, $akhir);
            }

            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Outbound Items Data Reports In PDF Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml(view('report/outbound_items_report', $kui));
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream('my.pdf', array('Attachment' => 0));

        } else {
            return redirect()->to('/home/dashboard');
        }
    }

    public function excel_outbound_items()
    {
        if (session()->get('level') == 2 || session()->get('level') == 3) {

            $model = new M_model();
            $awal = $this->request->getPost('awal');
            $akhir = $this->request->getPost('akhir');
            $username = session()->get('username');
            $data = [];

            if (session()->get('level') == 3) {
                $data = $model->filter_outbound_items('barang_keluar', $awal, $akhir, $username);
            } else {
                $data = $model->filter_outbound_items('barang_keluar', $awal, $akhir);
            }

            $spreadsheet = new Spreadsheet();

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Items Name')
                ->setCellValue('B1', 'Stok')
                ->setCellValue('C1', 'Remark')
                ->setCellValue('D1', 'Maker');

            $column = 2;

            foreach ($data as $data) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $data->nama_barang)
                    ->setCellValue('B' . $column, $data->stok)
                    ->setCellValue('C' . $column, $data->remark_keluar)
                    ->setCellValue('D' . $column, $data->username . '/' . $data->tanggal_barang_keluar);

                $column++;
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = 'Workshop Data Collection Application ~ Outbound Items Report (OIR)';

            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Outbound Items Data Reports In Excel Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            header('Content-type: vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename=' . $fileName . '.xlsx');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        } else {
            return redirect()->to('/home/dashboard');
        }
    }

    public function vehicle_maintenance_report()
    {
        if(session()->get('level')== 2 || session()->get('level')== 4) {

            $model=new M_model();
            $kui['kunci']='view_vehicle_maintenance';

            $id=session()->get('id');
            $where=array('id_user'=>$id);
            $kui['foto']=$model->getRow('user',$where);

            echo view('template/header',$kui);
            echo view('template/menu',$kui);
            echo view('report/filter',$kui);
            echo view('template/footer');

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function print_vehicle_maintenance()
    {
        if(session()->get('level')== 2 || session()->get('level')== 4) {

            $model=new M_model();
            $awal= $this->request->getPost('awal');
            $akhir= $this->request->getPost('akhir');
            $username = session()->get('username');

            if (session()->get('level') == 4) {
            $kui['duar'] = $model->filter_vm('kendaraan', $awal, $akhir, $username);
            } else {
            $kui['duar'] = $model->filter_vm('kendaraan', $awal, $akhir);
            }

            // $img = file_get_contents(
            //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

            // $kui['foto'] = base64_encode($img);
            
            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Vehicle Maintenance Data Reports In Print Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            echo view('report/vehicle_maintenance_report',$kui);

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function pdf_vehicle_maintenance()
    {
        if(session()->get('level')== 2 || session()->get('level')== 4) {

            $model=new M_model();
            $awal= $this->request->getPost('awal');
            $akhir= $this->request->getPost('akhir');
            $username = session()->get('username');
            $kui['duar'] = [];

            if (session()->get('level') == 4) {
                $kui['duar'] = $model->filter_vm('kendaraan', $awal, $akhir, $username);
            } else {
                $kui['duar'] = $model->filter_vm('kendaraan', $awal, $akhir);
            }

            // $img = file_get_contents(
            //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

            // $kui['foto'] = base64_encode($img);
            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Vehicle Maintenance Data Reports In PDF Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            $dompdf = new\Dompdf\Dompdf();
            $dompdf->loadHtml(view('report/vehicle_maintenance_report',$kui));
            $dompdf->setPaper('A4','landscape');
            $dompdf->render();
            $dompdf->stream('my.pdf', array('Attachment'=>0));

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function excel_vehicle_maintenance()
    {
        if(session()->get('level')== 2 || session()->get('level')== 4) {

            $model = new M_model();
            $awal = $this->request->getPost('awal');
            $akhir = $this->request->getPost('akhir');
            $username = session()->get('username');
            $data = [];

            if (session()->get('level') == 4) {
                $data = $model->filter_vm('kendaraan', $awal, $akhir, $username);
            } else {
                $data = $model->filter_vm('kendaraan', $awal, $akhir);
            }

            $spreadsheet = new Spreadsheet();

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Vehicle Brand')
                ->setCellValue('B1', 'Plat Number')
                ->setCellValue('C1', 'Workshop Name')
                ->setCellValue('D1', 'Workshop Address')
                ->setCellValue('E1', 'Vehicle Service')
                ->setCellValue('F1', 'Status')
                ->setCellValue('G1', 'Maker');

            $column = 2;

            foreach ($data as $data) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $data->merk_kendaraan)
                    ->setCellValue('B' . $column, $data->plat_kendaraan)
                    ->setCellValue('C' . $column, $data->nama_bengkel . ' ('.$data->no_bengkel.')')
                    ->setCellValue('D' . $column, $data->alamat_bengkel)
                    ->setCellValue('E' . $column, $data->service_kendaraan . ' ~ ' . $data->tanggal_service)
                    ->setCellValue('F' . $column, $data->status_kendaraan)
                    ->setCellValue('G' . $column, $data->username . ' / ' . $data->tanggal_kendaraan);

                $column++;
            }

            $writer = new XLsx($spreadsheet);
            $fileName = 'Workshop Data Collection Application ~ Vehicle Maintenance Report (VMR)';

            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Vehicle Maintenance Data Reports In Excel Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            header('Content-type: vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename=' . $fileName . '.xlsx');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        } else {
            return redirect()->to('/home/dashboard');
        }
    }

    public function invoice_report()
    {
        if(session()->get('level')== 2 || session()->get('level')== 4) {

            $model=new M_model();
            $kui['kunci']='view_invoice';

            $id=session()->get('id');
            $where=array('id_user'=>$id);
            $kui['foto']=$model->getRow('user',$where);

            echo view('template/header',$kui);
            echo view('template/menu',$kui);
            echo view('report/filter',$kui);
            echo view('template/footer');

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function print_invoice()
    {
        if(session()->get('level')== 2 || session()->get('level')== 4) {

            $model=new M_model();
            $awal= $this->request->getPost('awal');
            $akhir= $this->request->getPost('akhir');
            $username = session()->get('username');

            if (session()->get('level') == 4) {
            $kui['duar'] = $model->filter_invoice('invoice_service', $awal, $akhir, $username);
            } else {
            $kui['duar'] = $model->filter_invoice('invoice_service', $awal, $akhir);
            }

            // $img = file_get_contents(
            //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

            // $kui['foto'] = base64_encode($img);
            
            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Invoice Data Reports In Print Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            echo view('report/invoice_report',$kui);

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function pdf_invoice()
    {
        if(session()->get('level')== 2 || session()->get('level')== 4) {

            $model=new M_model();
            $awal= $this->request->getPost('awal');
            $akhir= $this->request->getPost('akhir');
            $username = session()->get('username');
            $kui['duar'] = [];

            if (session()->get('level') == 4) {
                $kui['duar'] = $model->filter_invoice('invoice_service', $awal, $akhir, $username);
            } else {
                $kui['duar'] = $model->filter_invoice('invoice_service', $awal, $akhir);
            }

            // $img = file_get_contents(
            //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

            // $kui['foto'] = base64_encode($img);
            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Invoice Data Reports In PDF Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            $dompdf = new\Dompdf\Dompdf();
            $dompdf->loadHtml(view('report/invoice_report',$kui));
            $dompdf->setPaper('A4','landscape');
            $dompdf->render();
            $dompdf->stream('my.pdf', array('Attachment'=>0));

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function excel_invoice()
    {
        if(session()->get('level')== 2 || session()->get('level')== 4) {

            $model = new M_model();
            $awal = $this->request->getPost('awal');
            $akhir = $this->request->getPost('akhir');
            $username = session()->get('username');
            $data = [];

            if (session()->get('level') == 4) {
                $data = $model->filter_invoice('invoice_service', $awal, $akhir, $username);
            } else {
                $data = $model->filter_invoice('invoice_service', $awal, $akhir);
            }

            $spreadsheet = new Spreadsheet();

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Date')
                ->setCellValue('B1', 'Description')
                ->setCellValue('C1', 'Account Name')
                ->setCellValue('D1', 'Ref')
                ->setCellValue('E1', 'Debit')
                ->setCellValue('F1', 'Kredit');

            $column = 2;

            foreach ($data as $data) {
                $hargaFormatted = number_format($data->harga_invoice, 0, ',', '.');
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $data->tanggal_invoice)
                    ->setCellValue('B' . $column, $data->merk_kendaraan . ' / ' .$data->plat_kendaraan)
                    ->setCellValue('C' . $column, $data->metode_pembayaran . ' / Pendatan')
                    ->setCellValue('D' . $column, $data->id_invoice.''.$data->id_kendaraan_invoice.''.$data->maker_invoice.''.$data->maker_invoice_kendaraan)
                    ->setCellValue('E' . $column, $hargaFormatted)
                    ->setCellValue('F' . $column, $hargaFormatted);

                $column++;
            }

            $writer = new XLsx($spreadsheet);
            $fileName = 'Workshop Data Collection Application ~ Invoice Report (IVR)';

            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Displays Invoice Data Reports In Excel Format ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            header('Content-type: vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename=' . $fileName . '.xlsx');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        } else {
            return redirect()->to('/home/dashboard');
        }
    }

// LOG ACTIVITY
    public function employee_activity()
    {
        $userLevel = session()->get('level');
        if ($userLevel == 1 || $userLevel == 2) {
            $model = new M_model();
            $where = [];

            if ($userLevel == 2) {
                $where['user.level >='] = 2;
            }

            if ($userLevel == 1) {
                $where['user.level <='] = 4;
            }

            $on = 'log_activity.id_user_log=user.id_user';
            $kui['duar'] = $model->log('log_activity', 'user', $on, $where, 'datetime');

            $id = session()->get('id');
            $where = ['id_user' => $id];

            $where = ['id_user' => session()->get('id')];
            $kui['foto'] = $model->getRow('user', $where);

            echo view ('template/header', $kui);
            echo view ('template/menu');
            echo view ('log_activity/employee_log');
            echo view ('template/footer');
        } else {
            return redirect()->to('/home/dashboard');
        }
    }


    public function log_search()
    {
        if (!session()->get('id') > 0) {
            return redirect()->to('/home/dashboard');
        }

        $model = new M_model();

        $search_log = $this->request->getPost('search_log');

        if (session()->get('level') == 1 || session()->get('level') == 2 && !empty($search_log)) {
            $on = 'log_activity.id_user_log=user.id_user';
            $kui['duar'] = $model->search_log('log_activity', 'user', $on, 'user.username', $search_log);
        }

        $id = session()->get('id');
        $where = ['id_user' => $id];
        $kui['search'] = "on";

        $where = ['id_user' => session()->get('id')];
        $kui['foto'] = $model->getRow('user', $where);

        echo view ('template/header', $kui);
        echo view ('template/menu');
        echo view ('log_activity/employee_log');
        echo view ('template/footer');
    }

    public function log_activity()
    {
        if(session()->get('level')== 1 || session()->get('level')== 2 || session()->get('level')== 3) {

            $model=new M_model();
            $where=array('log_activity.id_user_log'=>session()->get('id'));
            $on='log_activity.id_user_log=user.id_user';
            $kui['duar'] = $model->log('log_activity', 'user', $on, $where, 'datetime');

            $id=session()->get('id');
            $where=array('id_user'=>$id);

            $where=array('id_user' => session()->get('id'));
            $kui['foto']=$model->getRow('user',$where);

            echo view ('template/header', $kui);
            echo view ('template/menu');
            echo view ('log_activity/log');
            echo view ('template/footer');

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

// VM
    public function vehicle_maintenance()
    {
        if(!session()->get('id') > 0){
            return redirect()->to('/home/dashboard');
        }

        if(session()->get('level')== 2 || session()->get('level')== 3) {
            $model=new M_model();
            $on='kendaraan.id_service_bengkel=bengkel.id_bengkel';
            $on2='kendaraan.maker_kendaraan=user.id_user';
            $kui['duar']=$model->superOderBy('kendaraan', 'bengkel', 'user', $on, $on2, 'tanggal_kendaraan');
        }

        if(session()->get('level')== 4) {
            $model=new M_model();
            $where=array('username'=>session()->get('username'));
            $on='kendaraan.id_service_bengkel=bengkel.id_bengkel';
            $on2='kendaraan.maker_kendaraan=user.id_user';
            $kui['duar']=$model->invoice('kendaraan', 'bengkel', 'user', $on, $on2, 'tanggal_kendaraan', $where);
        }

            $id=session()->get('id');
            $where=array('id_user'=>$id);

            $where=array('id_user' => session()->get('id'));
            $kui['foto']=$model->getRow('user',$where);

            echo view ('template/header', $kui);
            echo view ('template/menu');
            echo view ('service/vm');
            echo view ('template/footer');
    }

    public function add_vehicle_maintenance()
    {
        $model = new M_model();
        $on = 'kendaraan.id_service_bengkel = bengkel.id_bengkel';
        $on2 = 'kendaraan.maker_kendaraan = user.id_user';
        $kui['duar'] = $model->superOderBy('kendaraan', 'bengkel', 'user', $on, $on2, 'tanggal_kendaraan');

        $id = session()->get('id');
        $where = array('id_user' => $id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto'] = $model->getRow('user', $where);

        $kui['bengkel'] = $model->tampil('bengkel');

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('service/add_vm');
        echo view('template/footer');
    }

    public function aksi_add_vehicle_maintenance()
    {
        $model=new M_model();
        $bengkel=$this->request->getPost('id_bengkel');
        $merk_kendaraan=$this->request->getPost('merk_kendaraan');
        $plat_kendaraan=$this->request->getPost('plat_kendaraan');
        $service_kendaraan=$this->request->getPost('service_kendaraan');
        $tanggal_service=$this->request->getPost('tanggal_service');
        $merk_kendaraan=$this->request->getPost('merk_kendaraan');
        $maker_kendaraan=session()->get('id');
        $data=array(

            'id_service_bengkel'=>$bengkel,
            'merk_kendaraan'=>$merk_kendaraan,
            'plat_kendaraan'=>$plat_kendaraan,
            'service_kendaraan'=>$service_kendaraan,
            'tanggal_service'=>$tanggal_service,
            'status_kendaraan'=>'Not Approved',
            'foto_kendaraan'=>'service.jpeg',
            'maker_kendaraan'=>$maker_kendaraan
        );

            $model->simpan('kendaraan',$data);

            $kui=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Add Data Vehicle Maintenance By Name ". $merk_kendaraan." ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$kui);

            return redirect()->to('/home/vehicle_maintenance');
    }

    public function detail_vehicle_maintenance($id)
    {
        $model=new M_model();
        $where2=array('id_kendaraan'=>$id); 

        $on = 'kendaraan.id_service_bengkel = bengkel.id_bengkel';
        $on2 = 'kendaraan.maker_kendaraan = user.id_user';
        $kui['gas'] = $model->detail_vm('kendaraan', 'bengkel', 'user', $on, $on2, $where2);

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('service/detail_vm');
        echo view('template/footer');
    }

    public function vehicle_maintenance_search()
    {
     if(!session()->get('id') > 0){
        return redirect()->to('/home/dashboard');
    }

    if(session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4) {

        $model=new M_model();
        $on = 'kendaraan.id_service_bengkel = bengkel.id_bengkel';
        $on2 = 'kendaraan.maker_kendaraan = user.id_user';
        $where=$this->request->getPost('search_vehicle_maintenance');
        $kui['duar'] = $model->superLike_vm('kendaraan', 'bengkel', 'user', $on, $on2, 'kendaraan.merk_kendaraan','kendaraan.plat_kendaraan', $where);
    }

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['search']="on";

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('service/vm');
        echo view('template/footer');
    }

    public function approved($id)
    {
        if(session()->get('level')== 2) {

            $model=new M_model();
            $where=array('id_kendaraan'=>$id);
            $data=array(
                'status_kendaraan'=>"Approved"
            );
            $model->edit('kendaraan', $data, $where);

            $kui=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Edit Data Vehicle Maintenance Approved With ID ". $id." ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$kui);

            return redirect()->to('/home/vehicle_maintenance');

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function already_serviced($id)
    {
        if(session()->get('level')== 3) {

            $model=new M_model();
            $where=array('id_kendaraan'=>$id);
            $data=array(
                'status_kendaraan'=>"Already Serviced"
            );
            $model->edit('kendaraan', $data, $where);

            $kui=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Edit Data Vehicle Maintenance Already Serviced With ID ". $id." ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$kui);

            return redirect()->to('/home/vehicle_maintenance');

        }else{
            return redirect()->to('/home/dashboard');
        }
    }

    public function invoice()
    {
        if(!session()->get('id') > 0){
            return redirect()->to('/home/dashboard');
        }

        if(session()->get('level')== 2) {

        $model=new M_model();
        $on = 'invoice_service.id_kendaraan_invoice = kendaraan.id_kendaraan';
        $on2 = 'invoice_service.maker_invoice = user.id_user';
        $kui['duar']=$model->superOderBy('invoice_service', 'kendaraan', 'user', $on, $on2,  'tanggal_invoice');
        }

        if(session()->get('level')== 4) {
        $model=new M_model();
        $where=array('username'=>session()->get('username'));
        $on = 'invoice_service.id_kendaraan_invoice = kendaraan.id_kendaraan';
        $on2 = 'invoice_service.maker_invoice_kendaraan = user.id_user';
        $kui['duar']=$model->invoice('invoice_service', 'kendaraan', 'user', $on, $on2,  'tanggal_invoice', $where);
        }

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('invoice/invoice');
        echo view('template/footer');
    }

    public function add_invoice()
    {
        $model=new M_model();
        $on = 'invoice_service.id_kendaraan_invoice = kendaraan.id_kendaraan';
        $on2 = 'invoice_service.maker_invoice = user.id_user';
        $kui['duar']=$model->superOderBy('invoice_service', 'kendaraan', 'user', $on, $on2,  'tanggal_invoice');

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        $kui['kendaraan'] = $model->tampil('kendaraan');

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('invoice/add_invoice');
        echo view('template/footer');
    }

    public function aksi_add_invoice()
    {
        $model=new M_model();
        $kendaraan=$this->request->getPost('id_kendaraan');
        $harga_invoice=$this->request->getPost('harga_invoice');
        $remark=$this->request->getPost('remark');
        $maker_invoice=session()->get('id');

        $maker_kendaraan = $model->getMakerKendaraan($kendaraan);
        $data=array(

            'id_kendaraan_invoice'=>$kendaraan,
            'harga_invoice'=>$harga_invoice,
            'remark'=>$remark,
            'metode_pembayaran'=>'~',
            'status_invoice'=>'Not Yet Paid Off',
            'maker_invoice_kendaraan' => $maker_kendaraan, 
            'maker_invoice'=>$maker_invoice
        );

            $model->simpan('invoice_service',$data);

            $kui=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Add Data Invoice Vehicle Maintenance By Name ". $kendaraan." ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$kui);

            return redirect()->to('/home/invoice');
    }

    public function delete_invoice($id)
    {
        $model=new M_model();
        $where=array('id_invoice'=>$id);
        $model->hapus('invoice_service',$where);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Delete Data Invoice Vehicle Maintenance With ID ". $id." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('home/invoice');
    }

    public function paid_invoice($id)
    {
        $model=new M_model();
        $where2=array('invoice_service.id_invoice'=>$id);

        $on = 'invoice_service.id_kendaraan_invoice = kendaraan.id_kendaraan';
        $on2 = 'invoice_service.maker_invoice = user.id_user';
        $kui['duar']=$model->pay_invoice('invoice_service', 'kendaraan', 'user', $on, $on2, $where2);

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('template/header', $kui);
        echo view('template/menu');
        echo view('invoice/paid_invoice');
        echo view('template/footer');
    }


    public function aksi_paid_invoice()
    {
        $model=new M_model();
        $id=$this->request->getPost('id');
        $metode_pembayaran=$this->request->getPost('metode_pembayaran');
        $maker_invoice=session()->get('id');
        $data=array(

            'metode_pembayaran'=>$metode_pembayaran,
            'status_invoice'=>'Paid Off',
            'maker_invoice'=>$maker_invoice
        );

        try {
            $foto = $this->request->getFile('bukti_pembayaran');
            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                $newName = $foto->getRandomName();
                $foto->move(ROOTPATH . '/public/assets/images/pay/', $newName);
                $data['bukti_pembayaran'] = $newName; 
            }

        $where=array('id_invoice'=>$id);
        $model->edit('invoice_service',$data,$where);

        $kui=array(
            'id_user_log'=>session()->get('id'),
            'activity'=>"Pay Service Vehicle Maintenance Bill With ID ". $id." ",
            'datetime'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$kui);

        return redirect()->to('/home/invoice');
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function download($file_name)
    {
        $file_path = FCPATH . 'assets/images/pay/' . $file_name;

        if (file_exists($file_path)) {

            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $file_name . '"');
            header('Content-Length: ' . filesize($file_path));

            readfile($file_path);
            exit;
            } else {
                die('File not found.');
        }
    }

    public function profile()
    {
        if(session()->get('level')== 1 || session()->get('level')== 2 || session()->get('level')== 3) {

            $id=session()->get('id');
            $where2=array('id_user'=>$id);
            $where=array('id_user_karyawan'=>$id);
            $model=new M_model();
            $pakif['users']=$model->edit_pp('karyawan',$where);
            $pakif['use']=$model->edit_pp('user',$where2);

            $kui['foto']=$model->getRow('user',$where2);

            $id=session()->get('id');


            echo view('template/header',$kui);
            echo view('template/menu');
            echo view('profile', $pakif);
            echo view('template/footer');
        }else {
            return redirect()->to('/');
        }
    }

    public function aksi_change_profile()
    {
        $model= new M_model();
        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $photo=$this->request->getFile('foto');
        $kui=$model->getRow('user',$where);
        if( $photo != '' ){}
            elseif($photo != '' && file_exists(PUBLIC_PATH."/assets/images/profile/".$kui->foto) ) 
            {
                unlink(PUBLIC_PATH."/assets/images/profile/".$kui->foto);
            }
            elseif($photo == '')
            {
                $username= $this->request->getPost('username');
                $nip= $this->request->getPost('nip');                    
                $nama_karyawan= $this->request->getPost('nama_karyawan');
                $jk_karyawan= $this->request->getPost('jk_karyawan');
                $ttl_karyawan= $this->request->getPost('ttl_karyawan');

                $user=array(
                    'username'=>$username,
                );
                $model->edit('user', $user,$where);
                $where2=array('id_user_karyawan'=>$id);

                $karyawan=array(
                    'nip'=>$nip,
                    'nama_karyawan'=>$nama_karyawan,
                    'jk_karyawan'=>$jk_karyawan,
                    'ttl_karyawan'=>$ttl_karyawan,
                );
                $model->edit('karyawan', $karyawan, $where2);

                $data=array(
                    'id_user_log'=>session()->get('id'),
                    'activity'=>"Edit Profile ". $nama_karyawan." ",
                    'datetime'=>date('Y-m-d H:i:s')
                );
                $model->simpan('log_activity',$data);

                return redirect()->to('/home/log_out');
            }

            $username= $this->request->getPost('username');
            $nip= $this->request->getPost('nip');                    
            $nama_karyawan= $this->request->getPost('nama_karyawan');
            $jk_karyawan= $this->request->getPost('jk_karyawan');
            $ttl_karyawan= $this->request->getPost('ttl_karyawan');

            $img = $photo->getRandomName();
            $photo->move(PUBLIC_PATH.'/assets/images/profile/',$img);
            $user=array(
                'username'=>$username,
                'foto'=>$img
            );
            $model=new M_model();
            $model->edit('user', $user,$where);

            $karyawan=array(
                'nip'=>$nip,
                'nama_karyawan'=>$nama_karyawan,
                'jk_karyawan'=>$jk_karyawan,
                'ttl_karyawan'=>$ttl_karyawan,
            );
            $where2=array('id_user_karyawan'=>$id);
            $model->edit('karyawan', $karyawan, $where2);

            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Edit Profile ". $nama_karyawan." ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            return redirect()->to('/home/profile');
        }

        public function profile_user()
    {
        if(session()->get('level')== 4) {

            $id=session()->get('id');
            $where2=array('id_user'=>$id);
            $where=array('id_user_pengguna'=>$id);
            $model=new M_model();
            $pakif['users']=$model->edit_pp('pengguna',$where);
            $pakif['use']=$model->edit_pp('user',$where2);

            $kui['foto']=$model->getRow('user',$where2);

            $id=session()->get('id');


            echo view('template/header',$kui);
            echo view('template/menu');
            echo view('profile_user', $pakif);
            echo view('template/footer');
        }else {
            return redirect()->to('/');
        }
    }

    public function aksi_change_profile_user()
    {
        $model= new M_model();
        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $photo=$this->request->getFile('foto');
        $kui=$model->getRow('user',$where);
        if( $photo != '' ){}
            elseif($photo != '' && file_exists(PUBLIC_PATH."/assets/images/profile/".$kui->foto) ) 
            {
                unlink(PUBLIC_PATH."/assets/images/profile/".$kui->foto);
            }
            elseif($photo == '')
            {
                $username= $this->request->getPost('username');
                $nik= $this->request->getPost('nik');
                $nama_pengguna= $this->request->getPost('nama_pengguna');
                $jk_pengguna= $this->request->getPost('jk_pengguna');
                $ttl_pengguna= $this->request->getPost('ttl_pengguna');
                $no_telp_pengguna= $this->request->getPost('no_telp_pengguna');
                $alamat= $this->request->getPost('alamat');

                $user=array(
                    'username'=>$username,
                );
                $model->edit('user', $user,$where);
                $where2=array('id_user_pengguna'=>$id);

                $pengguna=array(
                    'nik'=>$nik,
                    'nama_pengguna'=>$nama_pengguna,
                    'jk_pengguna'=>$jk_pengguna,
                    'ttl_pengguna'=>$ttl_pengguna,
                    'no_telp_pengguna'=>$no_telp_pengguna,
                    'alamat'=>$alamat,
                );
                $model->edit('pengguna', $pengguna, $where2);

                $data=array(
                    'id_user_log'=>session()->get('id'),
                    'activity'=>"Edit Profile ". $nama_anggota." ",
                    'datetime'=>date('Y-m-d H:i:s')
                );
                $model->simpan('log_activity',$data);

                return redirect()->to('/home/log_out');
            }

            $username= $this->request->getPost('username');
            $nik= $this->request->getPost('nik');
            $nama_pengguna= $this->request->getPost('nama_pengguna');
            $jk_pengguna= $this->request->getPost('jk_pengguna');
            $ttl_pengguna= $this->request->getPost('ttl_pengguna');
            $no_telp_pengguna= $this->request->getPost('no_telp_pengguna');
            $alamat= $this->request->getPost('alamat');

            $img = $photo->getRandomName();
            $photo->move(PUBLIC_PATH.'/assets/images/profile/',$img);
            $user=array(
                'username'=>$username,
                'foto'=>$img
            );
            $model=new M_model();
            $model->edit('user', $user,$where);

           $pengguna=array(
                'nik'=>$nik,
                'nama_pengguna'=>$nama_pengguna,
                'jk_pengguna'=>$jk_pengguna,
                'ttl_pengguna'=>$ttl_pengguna,
                'no_telp_pengguna'=>$no_telp_pengguna,
                'alamat'=>$alamat,
            );
            $where2=array('id_user_pengguna'=>$id);
            $model->edit('pengguna', $pengguna, $where2);

            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Edit Profile ". $nama_anggota." ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            return redirect()->to('/home/log_out');
        }

        public function change_pw()  
        {
            if(session()->get('level')== 1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4) {

                $id=session()->get('id');
                $where2=array('id_user'=>$id);
                $model=new M_model();
                $where=array('id_user' => session()->get('id'));
                $kui['foto']=$model->getRow('user',$where);
                $pakif['use']=$model->getRow('user',$where2);

                $id=session()->get('id');
                $where=array('id_user'=>$id);

                echo view('template/header',$kui);
                echo view('template/menu',$pakif);
                echo view('password',$pakif);
                echo view('template/footer');
            }else{
                return redirect()->to('/');
            }
        }

        public function aksi_change_pw()   
        {
            $pass=$this->request->getPost('pw');
            $id=session()->get('id');
            $model= new M_model();

            $data=array( 
                'password'=>md5($pass)
            );

            $where=array('id_user'=>$id);
            $model->edit('user', $data, $where);

            $data=array(
                'id_user_log'=>session()->get('id'),
                'activity'=>"Edit password with ID ". $id." ",
                'datetime'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            return redirect()->to('/home/log_out');
        }
}
