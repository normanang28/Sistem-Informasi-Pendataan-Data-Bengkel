<style>
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

    .form-container {
        width: 300px;
        margin: 0 auto; 
    }

    .right-aligned {
        text-align: right;
    }

    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }

    .blinking-icon {
        animation: blink 1s infinite; 
    }

    @keyframes blink-green {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }

    @keyframes blink-orange {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }

    .blinking-icon {
        animation-duration: 1s; 
        animation-iteration-count: infinite; 
    }

    .text-success .blinking-icon {
        animation-name: blink-green; 
    }

    .text-warning .blinking-icon {
        animation-name: blink-orange; 
    }

    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }

    .alert i.blinking-icon {
        animation: blink 2s infinite;
    }
</style>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="default-tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#home"><i class="la la-home me-2"></i> Invoice</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile"><i class="la la-user me-2"></i> Paid Off</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="home" role="tabpanel">
                            <div class="pt-4">
<?php  if(session()->get('level')== 2) { ?>   
                                <div class="right-aligned">
                                    <a href="<?= base_url('/home/add_invoice/')?>" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Add</button></a>
                                </div>
<?php }else{} ?>  
                                <br>
                                <div class="table-responsive">
                                    <table class="table items-table table table-bordered table-striped verticle-middle table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Vehicle Brand / Plat Number</th>
                                                <th class="text-center">Vehicle Service / Service Price</th>
                                                <th class="text-center">Remark</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no=1;
                                            foreach ($duar as $gas){
                                              if ($gas->status_invoice != "Paid Off") {
                                                  ?>
                                                  <tr>
                                                    <th class="text-center"><?php echo $no++ ?></th>
                                                    <td class="text-center text-capitalize text-dark"><?php echo $gas->merk_kendaraan?> / <?php echo $gas->plat_kendaraan?></td>
                                                    <td class="text-center text-capitalize text-dark"><?php echo $gas->service_kendaraan?> / Rp. <?php echo number_format($gas->harga_invoice  , 0, '.', ','); ?></td>
                                                    <td class="text-center text-capitalize text-dark"><?php echo $gas->remark?></td>
                                                    <td class="text-capitalize text-dark text-center">
                                                        <?php if ($gas->status_invoice == 'Paid Off'){ ?>
                                                            <i class="fas fa-circle text-success blinking-icon"></i> Paid Off
                                                        <?php } else { ?>
                                                            <i class="fas fa-circle text-warning blinking-icon"></i> Not Yet Paid Off
                                                        <?php } ?>
                                                    </td>                                              
                                                    <td>
                                                        <div class="col-12 center-column">
                                                            <?php  if(session()->get('level')== 2) { ?>        
                                                            <a href="<?= base_url('/home/delete_invoice/'.$gas->id_invoice)?>"><button class="btn btn-danger"><i class="fa fa-trash"></i> </button></a> 
                                                            <?php }else{} ?>  
                                                            <?php  if(session()->get('level')== 4) { ?>        
                                                                <a href="<?= base_url('/home/paid_invoice/'.$gas->id_invoice)?>"><button class="btn btn-success"><i class="fa-solid fa fa-dollar-sign"></i> </button></a>       
                                                            <?php }else{} ?>  
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php }}?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <div class="pt-4">
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-exclamation-triangle blinking-icon"></i> If there is underline text on the vehicle brand and plat number then there is proof of invoice payment, you can download by pressing the text underline!!
                            </div>
                                <div class="table-responsive">
                                    <table class="table items-table table table-bordered table-striped verticle-middle table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Vehicle Brand / Plat Number</th>
                                                <th class="text-center">Vehicle Service / Service Price</th>
                                                <th class="text-center">Payment Method</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no=1;
                                            foreach ($duar as $gas){
                                              if ($gas->status_invoice == "Paid Off") {
                                                  ?>
                                                  <tr>
                                                    <th class="text-center"><?php echo $no++ ?></th>
                                                    <td class="text-capitalize text-center">
                                                        <?php if (session()->get('level') == 2 || session()->get('level') == 4 && !empty($gas->bukti_pembayaran)) { ?>
                                                            <a href="<?= base_url('/home/download/' . $gas->bukti_pembayaran) ?>" style="text-decoration: underline; color: blue;">
                                                                <?php echo $gas->merk_kendaraan ?>/<?= $gas->plat_kendaraan ?>
                                                            </a>
                                                        <?php } else { ?>
                                                            <?php echo $gas->merk_kendaraan ?>/<?= $gas->plat_kendaraan ?>
                                                        <?php } ?>
                                                    </td>

                                                    <td class="text-center text-capitalize text-dark"><?php echo $gas->service_kendaraan?> / Rp. <?php echo number_format($gas->harga_invoice  , 0, '.', ','); ?></td>
                                                    <td class="text-center text-capitalize text-dark"><?php echo $gas->metode_pembayaran?></td>
                                                    <td class="text-capitalize text-dark text-center">
                                                        <?php if ($gas->status_invoice == 'Paid Off'){ ?>
                                                            <i class="fas fa-circle text-success blinking-icon"></i> Paid Off
                                                        <?php } else { ?>
                                                            <i class="fas fa-circle text-warning blinking-icon"></i> Not Yet Paid Off
                                                        <?php } ?>
                                                    </td>                                              
                                                </tr>
                                            <?php }}?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
