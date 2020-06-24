<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class siswa extends CI_Controller {
	private $filename = "import_data_siswa";
	public function index(){
		if ($this->session->userdata("uname")=="") {
				redirect("login");
			}
		$data['semester'] = $this->absensi_models->whereQuery('tb_komponen','status','Aktif')->row();
		$data['siswa'] = $this->absensi_models->queryAll('tb_siswa');
		$this->load->view('template/header', $data);
		$this->load->view('siswa/v_siswa', $data);
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
		if ($this->session->userdata("uname")=="") {
				redirect("login");
			}
		$data['semester'] = $this->absensi_models->whereQuery('tb_komponen','status','Aktif')->row();
		$this->load->view('template/header', $data);
		$this->load->view('siswa/v_tambah');
		$this->load->view('template/footer');
	}

	public function add(){
		$field['nis'] = $this->input->post("i_nis");
		$field['nisn'] = $this->input->post("i_nisn");
		$field['nama_siswa'] = $this->input->post("i_namasiswa");
		$field['jenis_kelamin'] = $this->input->post("i_jk");
		$field['alamat'] = $this->input->post("i_alamat");
		$field['tpt_lahir'] = $this->input->post("i_tptlahir");
		$field['tgl_lahir'] = $this->input->post("i_tgllahir");
		$field['status'] = "Aktif";

		$this->db->insert('tb_siswa', $field);
		redirect('siswa');
 	}

 	public function edit($id){
 		$ID = decrypt_url($id);
		$data['semester'] = $this->absensi_models->whereQuery('tb_komponen','status','Aktif')->row();
		$data['detail'] = $this->absensi_models->whereQuery('tb_siswa', 'nis', $ID)->row();
		$this->load->view('template/header', $data);
		$this->load->view('siswa/v_edit', $data);
		$this->load->view('template/footer');
	}

	public function update(){
		$ID = $this->input->post("i_nis");
		$field['status'] = $this->input->post("i_status");
		$field['nisn'] = $this->input->post("i_nisn");
		$field['nama_siswa'] = $this->input->post("i_namasiswa");
		$field['jenis_kelamin'] = $this->input->post("i_jk");
		$field['alamat'] = $this->input->post("i_alamat");
		$field['tpt_lahir'] = $this->input->post("i_tptlahir");
		$field['tgl_lahir'] = $this->input->post("i_tgllahir");

		$this->db->where('nis', $ID);
		$this->db->update('tb_siswa', $field);
		redirect('siswa');
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
		$this->load->view('siswa/v_upload', $data);
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
	          'nis'=>$row['A'],
	          'nisn'=>$row['B'], // Insert data nis dari kolom A di excel
	          'nama_siswa'=>$row['C'], // Insert data nama dari kolom B di excel
	          'jenis_kelamin'=>$row['D'], // Insert data jenis kelamin dari kolom C di excel
	          'tpt_lahir'=>$row['E'], // Insert data jenis kelamin dari kolom C di excel
	          'tgl_lahir'=>$row['F'], // Insert data jenis kelamin dari kolom C di excel
	          'alamat'=>$row['G'], // Insert data alamat dari kolom D di excel
	        ));
	      }
	      
	      $numrow++; // Tambah 1 setiap kali looping
	    }
	    // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
	    $this->absensi_models->insert_multiple("tb_siswa",$data);
	    
	    redirect("siswa"); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}
}
?>