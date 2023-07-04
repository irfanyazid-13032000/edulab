


<!-- Begin Page Content -->
<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800">Ubah Data Task</h1>

<form action="<?php echo base_url('tasks/update').'/'.$task['id'] ?>" method="post">
    <div class="form-group">
        <label for="judul">Judul</label>
        <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $task['judul'] ?>" required>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" id="status" name="status">
              <option value="0" <?php echo ($task['status'] == "0") ? "selected" : ""; ?>>Belum Selesai</option>
              <option value="1" <?php echo ($task['status'] == "1") ? "selected" : ""; ?>>Sudah Selesai</option>

        </select>
    </div>

    <button type="submit" class="btn btn-primary">Edit Data</button>
</form>


</div>
<!-- /.container-fluid -->


  </div>
            <!-- End of Main Content -->

           
