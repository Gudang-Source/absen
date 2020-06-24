<?php  ?>
<!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="alert alert-info alert-dismissible fade show" role="alert">
            1. Download Format File Excel <strong><a href="<?php echo base_url('/excel/FormatUploadDataGuru.xlsx') ?>" title="">Disini.</a></strong><br>
            2. Isi File Yang Telah Di Download Dengan Benar
          </div>

          <div class="card shadow mb-4 border-bottom-primary">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
            </div>
            <div class="card-body">
              <form action="<?php echo base_url('guru/upload') ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="file" name="i_file" placeholder="Nama Kelas" class="form-control-file">
                </div>
                <div class="form-group">
                  <!-- <input type="submit" name="i_simpan" value="Simpan" class="btn btn-sm btn-primary"> -->
                  <input type="submit" name="preview" value="Preview" class="btn btn-sm btn-info">
                </div>
              </form>
              <?php
                if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form 
                  if(isset($upload_error)){ // Jika proses upload gagal
                    echo "<div class='alert alert-danger'>".$upload_error."</div>"; // Muncul pesan error upload
                    // die; // stop skrip
                  }

                  echo "<hr>";

                  // Buat sebuah tag form untuk proses import data ke database
                  echo "<form method='post' action='".base_url("index.php/guru/import")."'>";
                  
                  // Buat sebuah div untuk alert validasi kosong
                  // echo "<div style='color: red;' id='kosong'>
                  // Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum diisi.
                  // </div>";
                  
                  echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                  <tr>
                    <th colspan='6'>Preview Data</th>
                  </tr>
                  <tr>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                  </tr>";
                  
                  $numrow = 1;
                  $kosong = 0;
                  
                  // Lakukan perulangan dari data yang ada di excel
                  // $sheet adalah variabel yang dikirim dari controller
                  foreach($sheet as $row){ 
                    // Ambil data pada excel sesuai Kolom
                    $nip = $row['A']; // Ambil data NIS
                    $nama = $row['B']; // Ambil data NISN
                    $jenis_kelamin = $row['C']; // Ambil data nama
                    $tpt_lahir = $row['D']; // Ambil data jenis kelamin
                    $tgl_lahir = $row['E'];
                    $alamat = $row['F'];
                    
                    // Cek jika semua data tidak diisi
                    if($nip == "" && $nama == "" && $jenis_kelamin == "" && $tpt_lahir == "" && $tgl_lahir == "" && $alamat == "")
                      continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
                    
                    // Cek $numrow apakah lebih dari 1
                    // Artinya karena baris pertama adalah nama-nama kolom
                    // Jadi dilewat saja, tidak usah diimport
                    if($numrow > 1){
                      // Validasi apakah semua data telah diisi
                      $nip_td = ( ! empty($nip))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                      $nama_td = ( ! empty($nama))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                      $jk_td = ( ! empty($jenis_kelamin))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                      $tpt_td = ( ! empty($tpt_lahir))? "" : " style='background: #E07171;'"; // Jika Tempat Lahir kosong, beri warna merah
                      $tgl_td = ( ! empty($tgl_lahir))? "" : " style='background: #E07171;'"; // Jika Tanggal Lahir kosong, beri warna merah
                      $alamat_td = ( ! empty($alamat))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                      
                      // Jika salah satu data ada yang kosong
                      if($nip == "" or $nama == "" or $jenis_kelamin == "" or $tpt_lahir == "" or $tgl_lahir == "" or $alamat == ""){
                        $kosong++; // Tambah 1 variabel $kosong
                      }
                      
                      echo "<tr>";
                      echo "<td".$nip_td.">".$nip."</td>";
                      echo "<td".$nama_td.">".$nama."</td>";
                      echo "<td".$jk_td.">".$jenis_kelamin."</td>";
                      echo "<td".$tpt_td.">".$tpt_lahir."</td>";
                      echo "<td".$tgl_td.">".$tgl_lahir."</td>";
                      echo "<td".$alamat_td.">".$alamat."</td>";
                      echo "</tr>";
                    }
                    
                    $numrow++; // Tambah 1 setiap kali looping
                  }
                  
                  echo "</table>";
                  
                  // Cek apakah variabel kosong lebih dari 0
                  // Jika lebih dari 0, berarti ada data yang masih kosong
                  if($kosong > 0){
                  ?>  
                    <script>
                    $(document).ready(function(){
                      // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
                      $("#jumlah_kosong").html('<?php echo $kosong; ?>');
                      
                      $("#kosong").show(); // Munculkan alert validasi kosong
                    });
                    </script>
                  <?php
                  }else{ // Jika semua data sudah diisi
                    echo "<hr>";
                    
                    // Buat sebuah tombol untuk mengimport data ke database
                    echo "<input type='submit' name='i_simpan' value='Simpan' class='btn btn-sm btn-primary'>    ";
                    echo "<input type='reset' name='' value='Batal' class='btn btn-sm  btn-danger'>";
                  }
                  
                  echo "</form>";
                }  

              ?>
            </div>
          </div>

        </div>

        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->