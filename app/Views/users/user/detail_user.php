<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="right-aligned">
                <a href="<?= base_url('/home/user/')?>" type="submit" class="btn btn-info"><i class="fa fa-undo"></i></button></a>
                <a href="<?= base_url('/home/reset_user/'.$gas->id_user_pengguna)?>"><button class="btn btn-info" title="Reset Password"><i class="fa fa-light fa-key"></i></button></a>
                <a href="<?= base_url('/home/delete_user/'.$gas->id_user_pengguna)?>"><button class="btn btn-danger"><i class="fa fa-trash"></i> </button></a>         
            </div>
            <br>
            <style>
              .form-container {
                width: 300px;
                margin: 0 auto; 
            }

            .right-aligned {
                text-align: right;
            }
        </style>
        <div class="table-responsive">
            <table class="table items-table table table-bordered table-striped verticle-middle table-responsive-sm">
                <thead>
                    <tr>
                        <th class="text-center">NIK</th>
                        <th class="text-center">Full Name</th>
                        <th class="text-center">Gender</th>
                        <th class="text-center">Place And Date Of Birth</th>
                        <th class="text-center">Phone Number</th>
                        <th class="text-center">Address</th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->nik?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->nama_pengguna?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->jk_pengguna?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->ttl_pengguna?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->no_telp_pengguna?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->alamat?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <style>
     .pagination {
        display: flex;
        justify-content: flex-end; 
        align-items: center; 
    }

    .page-numbers button {
        margin-left: 5px;
        font-size: 14px; 
        padding: 5px 10px;
    }

    .center-column {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .center-column .btn {
        margin-top: 5px; 
    }

    .button-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
</div>
</div>
</div>