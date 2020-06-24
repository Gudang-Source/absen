<?php  ?>
<!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="card shadow mb-4 border-bottom-primary">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
            </div>
            <div class="card-body">
              <form action="<?php echo base_url('rombel/add') ?>" method="post" accept-charset="utf-8">
                <div class="form-group" hidden>
                  <b>Nama Rombel</b>
                  <input type="text" name="i_namarombel" placeholder="Nama Rombel" class="form-control">
                </div>
                <div class="form-group">
                  <b>Nama Kelas</b>
                  <select name="i_kdkelas" class="form-control js-example-basic-single">
                  	<option value="">Pilih Kelas</option>
                  	<?php foreach ($kelas->result() as $datakelas) {?>
                  		<option value="<?php echo $datakelas->id_kelas ?>"><?php echo $datakelas->nama_kelas ?></option>
                  	<?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <b>Nama Siswa</b>
                  <select name="i_kdsiswa[]" class="form-control js-example-basic-multiple" multiple>
                  	<option value="">Pilih Siswa</option>
                  	<?php foreach ($siswa->result() as $datasiswa) {?>
                  		<option value="<?php echo $datasiswa->nis ?>"><?php echo $datasiswa->nama_siswa ?></option>
                  	<?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <input type="submit" name="i_simpan" value="Simpan" class="btn btn-sm btn-primary">
                </div>
              </form>
            </div>
          </div>

        </div>

        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->