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

    .menu-menu {
        padding-left: 160px; 
    }

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

</style>

<div class="row">

<form action="<?= base_url('home/items_search') ?>" method="post">
    <div class="input-group search-area">
        <input type="text" class="form-control text-capitalize" name="search_items" placeholder="Search here...">
        <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
    </div>
</form>  
<br> 
<div class="right-aligned">
    <?php if(!empty($search)) {?>
        <a href="<?= base_url('/home/items/')?>"><button class="btn btn-info"><i class="fa fa-reply"></i> Back</button></a>
    <?php }?>
<?php  if(session()->get('level')== 2) { ?>
        <a href="<?= base_url('/home/add_items/')?>"><button class="btn btn-success"><i class="fa fa-plus"></i> Add</button></a>
  <?php }else{} ?>    
<?php  if(session()->get('level')== 3) { ?>
        <a href="<?= base_url('/home/add_outbound_items/')?>"><button class="btn btn-success" style="margin-right: 10px;"><i class="fa fa-plus"></i> Add Outbound Items</button></a>
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
                        <a href="<?= base_url('/home/detail_items/'.$gas->id_barang)?>">
                            <img class="me-3 img-fluid custom-image" src="<?= base_url('assets/images/barang/' . $gas->foto_barang) ?>" alt="">
                        </a>
                        <div class="rounded-button">
                            <a href="<?= base_url('/home/detail_items/'.$gas->id_barang)?>"><i class="fa-solid fa fa-briefcase"></i></a>
                        </div>
                    </div>
                    <div class="new-arrival-content text-left mt-3 menu-details">
                        <h4><a class="text-capitalize"><?php echo $gas->jumlah == 0 ? '<span style="color: red;">' : ''; ?><?php echo $gas->nama_barang ?><?php echo $gas->jumlah == 0 ? '</span>' : ''; ?></a></h4>
                    </div>
                    <div class="menu-menu">
                        <?php
                        $jumlah = $gas->jumlah;
                        $textColorClass = $jumlah == 0 ? 'text-danger' : 'text-dark';
                        echo "<span class='text-capitalize text-center $textColorClass'>Tersedia: $jumlah</span>";
                        ?>
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


