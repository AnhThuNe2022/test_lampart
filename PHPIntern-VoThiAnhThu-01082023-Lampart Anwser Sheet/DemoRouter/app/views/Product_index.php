<!DOCTYPE html>
<html>
<head>
    <title>PHP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <div class="container">
        <h1><i class="fas fa-globe"></i> Danh sách danh mục</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="input-group">
            <form action="product/search" method="get">
                <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm sản phẩm" aria-label="Tìm kiếm sản phẩm">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
            </form>
            </div>
            
            <button class="btn btn-success" type="button" data-bs-toggle="modal" onclick ='addProduct()' data-bs-target="#addModal"><i class="fas fa-plus"></i> Thêm sản phẩm</button>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['product_list'] as $product): ?>
                    <tr>
                        <td><?php echo $product['Id'];?></td>
                        <td><?php echo $product['Name']; ?></td>
                        <td><?php echo $product['Category']; ?></td>
                        <?php
                            // Lấy đường dẫn ảnh từ tên ảnh trong dữ liệu sản phẩm
                            $imageName = $product['Image'];
                            $imagePath = 'app/uploads/' . $imageName;
                            ?>
                        <td><img src="<?php echo $imagePath; ?>"alt="Product Image" width="100"></td>
                        <td>
                            <a href="#"onclick="openEditModalOrDetail(<?php echo $product['Id']; ?>,1)"  title="Sửa"><i class="fas fa-edit fa-lg"></i></a>
                            <a href="#" title="Thêm mới" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus-circle fa-lg"></i></a>
                            <a href="#" onclick="openEditModalOrDetail(<?php echo $product['Id']; ?>,0)"> <i class="fas fa-info-circle fa-lg"></i></a>
                            <form action="product/deleteProduct" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $product['Id']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirmDelete()">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="product/addProduct" method="post" enctype="multipart/form-data"> <!-- Thay 'save_product.php' bằng đường dẫn tới file xử lý dữ liệu PHP -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="productName" name="productName">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <?php foreach ($data['cate_list'] as $category): ?>
                                <option value="<?php echo $category['Id']; ?>"><?php echo $category['CategoryName']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productImage" class="form-label">Ảnh sản phẩm</label>
                        <input type="file" class="form-control" id="productImage" name="productImage">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal sửa -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Sửa sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form sửa thông tin sản phẩm -->
                <form action="product/updateProduct" method="post" enctype="multipart/form-data">
                     <div class="mb-3">
                        <label for="productID" class="form-label">Mã sản phẩm</label>
                        <input type="text" class="form-control" id="product_idEdit" name="product_idEdit" value="<?php echo $product['Id']; ?>">
                    </div>                    <div class="mb-3">
                        <label for="productName" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="productNameEdit" name="productNameEdit" value="<?php echo $product['Name']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="categoryEdit" name="categoryEdit">
                            <?php foreach ($data['cate_list'] as $category): ?>
                                <option value="<?php echo $category['Id']; ?>"><?php echo $category['CategoryName']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                    <label for="productImageEdit" class="form-label">Ảnh sản phẩm</label>
                    <input type="file" class="form-control" id="productImageEdit" name="productImageEdit">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xem chi tiết sản phẩm -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Chi tiết sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="productNameDetail" class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="productNameDetail" readonly>
                </div>
                <div class="mb-3">
                    <label for="categoryDetail" class="form-label">Category</label>
                    <input type="text" class="form-control" id="categoryDetail" readonly>
                </div>
                <?php
                            // Lấy đường dẫn ảnh từ tên ảnh trong dữ liệu sản phẩm
                            $imageName = $product['Image'];
                            $imagePath = 'app/uploads/' . $imageName;
                            ?>
                    <div class="mb-3">
                    <img src="<?php echo $imagePath; ?>"alt="Product Image" width="100">
                </div>
                <!-- Thêm các trường thông tin khác của sản phẩm tại đây -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script> 

    function confirmDelete() {
        if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
            return true;
        } else {
            return false;
        }
    }


    function openEditModalOrDetail(productId,isEdit) {
      
        $.ajax({
            url: '/DemoRouter/Product/getProductInfo', // Đường dẫn tới phương thức trong controller để lấy thông tin sản phẩm
            method: 'GET',
            data: { id: productId },
            success: function(response) {
                //var productInfo = JSON.parse(response);
                if (isEdit == 1){
                    $('#product_idEdit').val(response.Id);

                    $('#productNameEdit').val(response.Name);
                    $('#categoryEdit').val(response.Category);
                    // if (response.Image) {
                    //     var imageUrl = 'app/uploads' + response.Image;
                    //     $('#productImageEdit').attr('src', imageUrl);
                    // } else {
                    //     // Nếu không có ảnh, xóa thuộc tính src để không hiển thị ảnh cũ (nếu có)
                    //     $('#productImageEdit').removeAttr('src');
                    // }
                    $('#editModal').modal('show');
                }
                else {
                    $('#productNameDetail').val(response.Name);
                    $('#categoryDetail').val(response.Category);
                    // Các trường thông tin khác của sản phẩm cũng có thể được thêm vào modal tại đây

                    // Mở modal
                    $('#detailModal').modal('show');

                }

                
            },
            error: function() {
                alert('Có lỗi khi lấy thông tin sản phẩm!');
            }
        });
    }

   
    </script>
   
</body>
</html> 

