<div class = "container-fluid">
    <button class ="btn btn-sm btn-primary mb-3" data-toggle="modal" data-target="#tambahpelanggan"><i class="fas da-plus fa-sm"></i>Tambah Pelanggan</button>
    <table class="table table-bordered">
        <tr>
            <th>NO</th>
            <th>NAMA PELANGGAN</th>
            <th>ALAMAT</th>
            <th>USERNAME</th>
            <th>PASSWORD</th>
            <th colspan="3">AKSI</th>
        </tr>
        <?php 
        $no=1;
        foreach($pelanggan as $plg): ?> <!--menginisialisasi data ke variabel plg-->
        <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $plg->nama_plg ?></td> <!--menampilkan data-->
            <td><?php echo $plg->alamat ?></td>
            <td><?php echo $plg->username ?></td>
            <td><?php echo $plg->password ?></td>
            
            <!-- <td><?php //echo anchor('admin/data_pelanggan/read/'.$plg->id_plg, '<div class="btn btn-success btn-sm"> <i class ="fas fa-search-plus"></i> </div>') ?></td> -->
            <td><?php echo anchor('admin/data_pelanggan/edit/'.$plg->id_plg, '<div class="btn btn-primary btn-sm"> <i class ="fa fa-edit"></i> </div>') ?></td> <!--memanggil controller admin/data_pelanggan dengan fungsi edit berdasarkan id-->
            <td><?php echo anchor('admin/data_pelanggan/hapus/'.$plg->id_plg,'<div class="btn btn-danger btn-sm"> <i class ="fa fa-trash"></i> </div>')?></td> <!--memanggil controller admin/data_pelanggan dengan fungsi edit berdasarkan id-->
        </tr>

        <?php endforeach;?>
    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="tambahpelanggan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Input Pelanggan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url(). 'admin/data_pelanggan/tambah_aksi' ?>" method="post" enctype="multipart/form-data"> <!--memanggil controller admin/data_pelanggan dengan fungsi tambah aksi-->
           <div class="form-group">
               <label>Nama Pelanggan</label>
               <input type="text" name="nama_plg" class="form-control">

           </div>
           <div class="form-group">
               <label>Alamat</label>
               <input type="text" name="alamat" class="form-control">

           </div>
           <div class="form-group">
               <label>Username</label>
               <input type="text" name="username" class="form-control">

           </div>
           <div class="form-group">
               <label>Password</label>
               <input type="text" name="password" class="form-control">

           </div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>