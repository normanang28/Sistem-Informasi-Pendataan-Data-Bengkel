<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="header-left">
                <form action="<?= base_url('home/workshop_search') ?>" method="post">
                    <div class="input-group search-area">
                        <input type="text" class="form-control text-capitalize" name="search_workshop" placeholder="Search here...">
                        <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                    </div>
                </form>
            </div>
            <div class="right-aligned">
                <?php if(!empty($search)) {?>
                    <a href="<?= base_url('/home/workshop/')?>"><button class="btn btn-info"><i class="fa fa-reply"></i> Back</button></a>
                <?php }?>
                <a href="<?= base_url('/home/add_workshop/')?>"><button class="btn btn-success custom-button"><i class="fa fa-plus"></i> Add</button></a>
            </div>
            <style>
                .form-container {
                    width: 300px; 
                    margin: 0 auto; 
                }

                .right-aligned {
                    text-align: right;
                }

                .button-container {
                    display: flex;
                    align-items: center;
                    gap: 10px; 
                }

                .button-container a {
                    text-decoration: none; 
                }

            </style>
            <style>
                .search-area input::placeholder {
                    color: #999; 
                    transition: color 0.3s; 
                }

                .search-area input:focus::placeholder {
                    color: #ff0000; 
                }
            </style>

            
            <br>
            <div class="table-responsive">
                <table class="table items-table table table-bordered table-striped verticle-middle table-responsive-sm">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Workshop Name</th>
                            <th class="text-center">Number Telephone</th>
                            <th class="text-center">Addres</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=1;
                        foreach ($duar as $gas){
                          ?>
                          <tr>
                            <th class="text-center"><?php echo $no++ ?></th>
                            <td class="text-center text-capitalize text-dark"><?php echo $gas->nama_bengkel?></td>
                            <td class="text-center text-capitalize text-dark"><?php echo $gas->no_bengkel?></td>
                            <td class="text-center text-capitalize text-dark"><?php echo $gas->alamat_bengkel?></td>
                            <td>
                                <div class="button-container">
                                  <a href="<?= base_url('/home/edit_workshop/'.$gas->id_bengkel)?>"><button class="btn btn-warning"><i class="fa fa-edit"></i> </button></a>
                                  <a href="<?= base_url('/home/delete_workshop/'.$gas->id_bengkel)?>"><button class="btn btn-danger"><i class="fa fa-trash"></i> </button></a>
                              </div>
                              <style>
                                .button-container {
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: center;
                                }
                                .btn {
                                    margin-right: 10px; 
                                }
                                </style>
                          </td>
                      </tr>
                  <?php }?>
              </tbody>
          </table>
      </div>
      <div class="pagination">
        <nav>
            <ul class="pagination pagination-sm">
                <li class="page-item page-indicator" id="previousPageButton">
                    <a class="page-link" href="javascript:void(0)">
                        <i class="la la-angle-left"></i></a>
                    </li>
                    <li class="page-item" id="currentPageNumber">1</li>
                    <li class="page-item page-indicator" id="nextPageButton">
                        <a class="page-link" href="javascript:void(0)">
                            <i class="la la-angle-right"></i></a>
                        </li>
                    </ul>
                </nav>
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
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tableBody = document.querySelector('.table tbody');
                const currentPageNumber = document.getElementById('currentPageNumber');
                const previousPageButton = document.getElementById('previousPageButton');
                const nextPageButton = document.getElementById('nextPageButton');

                const data = <?= json_encode($duar) ?>; 
                const itemsPerPage = 20;
                let currentPage = 1;
                const totalPages = Math.ceil(data.length / itemsPerPage);

                function displayDataOnPage(page) {
                    tableBody.innerHTML = ''; 

                    const startIndex = (page - 1) * itemsPerPage;
                    const endIndex = startIndex + itemsPerPage;

                    for (let i = startIndex; i < endIndex && i < data.length; i++) {
                        const gas = data[i];
                        const row = `
                        <tr>
                        <th class="text-center">${i + 1}</th>
                        <td class="text-center text-capitalize text-dark">${gas.nama_bengkel}</td>
                        <td class="text-center text-capitalize text-dark">${gas.no_bengkel}</td>
                        <td class="text-center text-capitalize text-dark">${gas.alamat_bengkel}</td>
                        <td>
                        <div class="button-container">
                        <a href="<?= base_url('/home/edit_workshop/') ?>/${gas.id_bengkel}"><button class="btn btn-warning"><i class="fa fa-edit"></i></button></a>
                        <a href="<?= base_url('/home/delete_workshop/') ?>/${gas.id_bengkel}"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
                        </div>
                        </td>
                        </tr>
                        `;
                        tableBody.innerHTML += row;
                    }
                }

                function updatePageNumbers() {
                    currentPageNumber.textContent = currentPage;
                }

                previousPageButton.addEventListener('click', function () {
                    if (currentPage > 1) {
                        currentPage--;
                        displayDataOnPage(currentPage);
                        updatePageNumbers();
                    }
                });

                nextPageButton.addEventListener('click', function () {
                    if (currentPage < totalPages) {
                        currentPage++;
                        displayDataOnPage(currentPage);
                        updatePageNumbers();
                    }
                });

                displayDataOnPage(currentPage);
                updatePageNumbers();
            });

        </script>
    </div>
</div>
</div>