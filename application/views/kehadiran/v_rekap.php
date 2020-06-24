<?php  ?>
<!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="card shadow mb-4 border-bottom-primary">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Absensi</h6>
            </div>
            <div class="card-body">
              <form action="<?php echo base_url() ?>kehadiran/outputrekap" method="post" target="_blank">
                <input type="hidden" name="i_kdkelas" value="<?php echo $detail_kelas->id_kelas ?>" placeholder="">
                <div class="form-group">
                  <b>Nama Rombel</b>
                  <input type="text" name="i_namarombel" value="<?php echo $detail_kelas->nama_kelas ?>" class="form-control" readonly>
                </div>
                <div class="form-group">
                  <b>Smt/Tahun Pelajaran</b>
                  <select name="i_smt" class="form-control js-example-basic-single" required>
                    <option value="">Pilih Smt/Tahun Pelajaran</option>
                    <?php foreach ($smt->result() as $data) { ?>
                      <option value="<?php echo $data->id_komponen ?>"><?php echo $data->semester.' '.$data->tahun_ajaran ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <input type="submit" name="i_rekao" value="Rekap" class="btn btn-sm btn-primary">
                </div>                  
              </form>
            </div>
          </div>

        </div>

        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->