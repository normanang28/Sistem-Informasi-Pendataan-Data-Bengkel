<style>
    .custom-image {
        width: 100px; 
        height: 150px; 
        object-fit: cover; 
    }

    .rounded-card {
        border-radius: 20px;
        overflow: hidden; 
    }

    .product-grid-card {
        border: none; 
    }

    .rounded-button {
        width: 30px; 
        height: 30px; 
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 10px; 
        right: 10px; 
        border: 1px solid #000; 
        background-color: #fff; 
    }

    .menu-details {
        padding-left: 20px; 
    }

    /*.menu-menu {
        padding-left: 140px; 
    }*/

    .custom-button {
        position: fixed; 
        bottom: 0;
        right: 0; 
        margin: 20px; 
    }

    .search-area {
        margin-top: 10px; 
        margin-bottom: 10px; 
    }

    .smaller-text {
        font-size: 65%; 
        padding-left: 150px; 
    }

    .float-right {
        float: right;
    }
</style>

<div class="row">

<form action="<?= base_url('home/vehicle_maintenance_search') ?>" method="post">
    <div class="input-group search-area">
        <input type="text" class="form-control text-capitalize" name="search_vehicle_maintenance" placeholder="Search here...">
        <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
    </div>
</form>  
<br> 
<div class="right-aligned">
    <?php if(!empty($search)) {?>
        <a href="<?= base_url('/home/vehicle_maintenance/')?>"><button class="btn btn-info"><i class="fa fa-reply"></i> Back</button></a>
    <?php }?>
<?php  if(session()->get('level')== 4) { ?>
        <a href="<?= base_url('/home/add_vehicle_maintenance/')?>"><button class="btn btn-success"><i class="fa fa-plus"></i> Add</button></a>
  <?php }else{} ?>    
</div>
<h1></h1>
<style>
    .search-area input::placeholder {
        color: #999; 
        transition: color 0.3s; 
    }

    .search-area input:focus::placeholder {
        color: #ff0000; 
    }

      .form-container {
        width: 300px; 
        margin: 0 auto; 
    }

    .right-aligned {
        text-align: right;
    }
</style>      
<br>
<?php
foreach ($duar as $gas) {
    ?>
    <div class="col-xl-2 col-xxl-3 col-md-4 col-sm-6">
        <div class="card rounded-card">
            <div class=" product-grid-card">
                <div class="new-arrival-product">
                    <div class="new-arrivals-img-contnent">
                        <a href="<?= base_url('/home/detail_vehicle_maintenance/'.$gas->id_kendaraan)?>">
                            <img class="me-3 img-fluid custom-image" src="<?= base_url('assets/images/service/' . $gas->foto_kendaraan) ?>" alt="">
                        </a>
                        <div class="rounded-button">
                            <a href="<?= base_url('/home/detail_vehicle_maintenance/'.$gas->id_kendaraan)?>"><i class="fa-solid fa fa-info"></i></a>
                        </div>
                    </div>
                    <div class="new-arrival-content text-left mt-3 menu-details">
                        <h4><a class="text-capitalize" ><?php echo $gas->merk_kendaraan ?></a></h4>
                        <span class="text-uppercase text-center text-dark"><?php echo $gas->plat_kendaraan ?></span>
                    </div>
                    <div class="menu-menu">
                        <span class="text-capitalize text-center <?php echo ($gas->status_kendaraan === 'Not Approved') ? 'text-danger' : (($gas->status_kendaraan === 'Already Serviced') ? 'text-success' : 'text-dark'); ?> float-right ">
                            <?php echo $gas->status_kendaraan; ?>
                        </span>
                        <style>
                            .text-danger {
                                color: red;
                            }

                            .text-success {
                                color: green;
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>

    <div id="searchNotFound" class="search-not-found">
        <p><i class="fa fa-exclamation-triangle"></i> Sorry, the search you are looking for does not exist.</p>
    </div>
    <style>        
        .search-not-found {
            opacity: 0;
            position: fixed;
            bottom: 20px;
            right: -1050px; 
            background-color: #ff9900;
            color: #fff;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: opacity 1s;
        }
        
        .search-not-found i {
            margin-right: 5px; 
        }
    </style>
    <script>
        function showSearchNotFoundMessage() {
        var searchNotFound = document.getElementById('searchNotFound');
        searchNotFound.style.opacity = 1; 

            setTimeout(function () {
                searchNotFound.style.opacity = 0; 
            }, 10000); 
        }

        if (<?= count($duar) ?> === 0) {
            showSearchNotFoundMessage();
        }
    </script>
</div>


