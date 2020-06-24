<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class guru extends CI_Controller {
	private $filename = "import_data_guru";
	public function index(){
		$data['semester'] = $this->absensi_models->whereQuery('tb_komponen','status','Aktif')->row();
		if ($this->session->userdata("uname")=="") {
				redirect("login");
			}
		$data['guru'] = $this->absensi_models->queryAll('tb_guru');
		$this->load->view('template/header', $data);
		$this->load->view('guru/v_guru', $data);
		$this->load->view('template/footer');
	}

	public static function TglIndo($date){
		$str = explode('-', $date);

		$bulan = array(
			'01' => 'Jan',
			'02' => 'Feb',
			'03' => 'Mar',
			'04' => 'Apr',
			'05' => 'Mei',
			'06' => 'Jun',
			'07' => 'Jul',
			'08' => 'Agu',
			'09' => 'Sep',
			'10' => 'Okt',
			'11' => 'Nov',
			'12' => 'Des');

		return $str[2]." ".$bulan[$str[1]]." ".$str[0];
	}

	public function tambah(){
		$data['semester'] = $this->absensi_models->whereQuery('tb_komponen','status','Aktif')->row();
		if ($this->session->userdata("uname")=="") {
				redirect("login");
			}
		$this->load->view('template/header', $data);
		$this->load->view('guru/v_tambah');
		$this->load->view('template/footer');
	}

	public function add(){
		$field['nip'] = $this->input->post("i_nip");
		$field['nama_guru'] = $this->input->post("i_namaguru");
		$field['jenis_kelamin'] = $this->input->post("i_jk");
		$field['alamat'] = $this->input->post("i_alamat");
		$field['tpt_lahir'] = $this->input->post("i_tptlahir");
		$field['tgl_lahir'] = $this->input->post("i_tgllahir");
		$field['uname'] = $this->input->post("i_username");
		$field['pwd'] = md5($this->input->post("i_pwd"));
		$field['status'] = "Aktif";

		$this->db->insert('tb_guru', $field);
		redirect('guru');
 	}

 	public function edit($id){
 		$ID = decrypt_url($id);
		$data['semester'] = $this->absensi_models->whereQuery('tb_komponen','status','Aktif')->row();
		$data['detail'] = $this->absensi_models->whereQuery('tb_guru', 'nip', $ID)->row();
		$this->load->view('template/header', $data);
		$this->load->view('guru/v_edit', $data);
		$this->load->view('template/footer');
	}

	public function edgur($id){
 		$ID = decrypt_url($id);
		$data['semester'] = $this->absensi_models->whereQuery('tb_komponen','status','Aktif')->row();
		$data['detail'] = $this->absensi_models->whereQuery('tb_guru', 'nip', $ID)->row();
		$this->load->view('template/header', $data);
		$this->load->view('guru/v_edgur', $data);
		$this->load->view('template/footer');
	}

	public function update(){
		$ID = $this->input->post("i_nip");
		$field['nama_guru'] = $this->input->post("i_namaguru");
		$field['jenis_kelamin'] = $this->input->post("i_jk");
		$field['alamat'] = $this->input->post("i_alamat");
		$field['tpt_lahir'] = $this->input->post("i_tptlahir");
		$field['tgl_lahir'] = $this->input->post("i_tgllahir");
		$field['uname'] = $this->input->post("i_username");
		$PWD = $this->input->post("i_pwd");
		if (empty($PWD)) {
			$field['pwd'] = $this->input->post("i_pwd2");
		}else{
			$field['pwd'] = $this->input->post("i_pwd");
		}

		$this->db->where('nip', $ID);
		$this->db->update('tb_guru', $field);
		redirect('guru');
 	}

 	public function upgur(){
		$ID = $this->input->post("i_nip");
		$field['nama_guru'] = $this->input->post("i_namaguru");
		$field['jenis_kelamin'] = $this->input->post("i_jk");
		$field['alamat'] = $this->input->post("i_alamat");
		$field['tpt_lahir'] = $this->input->post("i_tptlahir");
		$field['tgl_lahir'] = $this->input->post("i_tgllahir");
		$field['uname'] = $this->input->post("i_username");
		$PWD = $this->input->post("i_pwd");
		if (empty($PWD)) {
			$field['pwd'] = $this->input->post("i_pwd2");
		}else{
			$field['pwd'] = md5($this->input->post("i_pwd"));
		}

		$this->db->where('nip', $ID);
		$this->db->update('tb_guru', $field);
		redirect('Welcome');
 	}

 	public function upload(){
 		if ($this->session->userdata("uname")=="") {
				redirect("login");
			}
 		$data = array();

		if (isset($_POST['preview'])) {

			$config['upload_path']          = './assets/excel';
	        $config['allowed_types']        = 'xlsx';
	        $config['file_name']        	= $this->filename;
	        $config['overwrite'] 			= true;
	        $config['remove_spaces']		= false;

	        $this->load->library('upload', $config);

	        if ( ! $this->upload->do_upload('i_file')){
	            $error = array('error' => $this->upload->display_errors());
	            return $error;
	            // $this->load->view('lembaga/tbh_lembaga', $error);
	        }else{
	            $data = array('upload_data' => $this->upload->data());

	            // Load plugin PHPExcel nya
		        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		        
		        $excelreader = new PHPExcel_Reader_Excel2007();
		        $loadexcel = $excelreader->load('assets/excel/'.$this->filename.'.xlsx'); // Load file yang tadi diupload ke folder excel
		        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		        
		        // Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
		        // Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
		        $data['sheet'] = $sheet;
	        }
	    }

		$data['semester'] = $this->absensi_models->whereQuery('tb_komponen','status','Aktif')->row();
		$this->load->view('template/header', $data);
		$this->load->view('guru/v_upload', $data);
		$this->load->view('template/footer');
	}

	public function import(){
		// Load plugin PHPExcel nya
	    include APPPATH.'third_party/PHPExcel/PHPExcel.php';
	    
	    $excelreader = new PHPExcel_Reader_Excel2007();
	    $loadexcel = $excelreader->load('assets/excel/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
	    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
	    
	    // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
	    $data = array();
	    
	    $numrow = 1;
	    foreach($sheet as $row){
	      // Cek $numrow apakah lebih dari 1
	      // Artinya karena baris pertama adalah nama-nama kolom
	      // Jadi dilewat saja, tidak usah diimport
	      if($numrow > 1){
	        // Kita push (add) array data ke variabel data
	        array_push($data, array(
	          'nip'=>$row['A'],
	          'nama_guru'=>$row['B'], // Insert data nis dari kolom A di excel
	          'jenis_kelamin'=>$row['C'], // Insert data nama dari kolom B di excel
	          'tpt_lahir'=>$row['D'], // Insert data jenis kelamin dari kolom C di excel
	          'tgl_lahir'=>$row['E'], // Insert data jenis kelamin dari kolom C di excel
	          'alamat'=>$row['F'], // Insert data jenis kelamin dari kolom C di excel
	        ));
	      }
	      
	      $numrow++; // Tambah 1 setiap kali looping
	    }
	    // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
	    $this->absensi_models->insert_multiple("tb_guru",$data);
	    
	    redirect("guru"); // Redirect ke halaman awal (ke controller guru fungsi index)
	}
}
?>