<?php ?>
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Kehadiran</h6>
             <!--  <a href="<?php echo base_url('rombel/tambah')?>" class="btn btn-sm btn-primary float-right"> <i class="fas fa-plus"></i> Tambah Data</a> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <!-- <th>No</th> -->
                      <th>Tanngal Absen</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <!-- <th>No</th> -->
                      <th>Tanngal Absen</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  	<?php $no = 1; foreach ($absen->result() as $data_absen) { ?>
                    <tr>
                      <!-- <td><?php echo $no++ ?></td> -->
                      <td><a href="<?php echo base_url() ?>kehadiran/detail_absen/<?php echo encrypt_url($data_absen->tgl_absen) ?>"><?php echo $data_absen->tgl_absen; ?></a></td>
                    </tr>
                	<?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->