<?php  ?>
<!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="card shadow mb-4 border-bottom-primary">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Absensi</h6>
            </div>
            <div class="card-body">
              <form action="<?php echo base_url('kehadiran/add_absen') ?>" method="post" accept-charset="utf-8">
                <div class="form-group">
                  <b>Nama Rombel</b>
                  <input type="text" name="i_namarombel" value="<?php echo $detail_kelas->nama_kelas ?>" class="form-control" readonly>
                </div>
                <div class="alert alert-danger">
                  Hubungi Developer Via E-Mail <code>lukmanha73@gmail.com</code> Untuk Versi Lengkap ☺
                </div>
              </form>
            </div>
          </div>

        </div>

        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->