<?php

class Product extends Controller
{

    public $data = [];
    public $product = [];

    public function __construct()
    {
        $this ->product = $this ->model('ProductRepository');


    }
    function index()
    {
        if (isset($_SESSION['search_results'])) {
            // Lấy kết quả tìm kiếm từ session
            $searchResults = $_SESSION['search_results'];
    
            unset($_SESSION['search_results']);
    
            // Gán kết quả tìm kiếm cho dữ liệu trong view
            $this->data['product_list'] = $searchResults;
        } else {
            // Nếu không có kết quả tìm kiếm, thực hiện như bình thường (lấy danh sách tất cả sản phẩm)
            $dataProduct = $this ->product->getList();
            $this-> data['product_list'] = $dataProduct;

        }

        $category = $this ->model('CategoryRepository');
        $dataCategory = $category->getList();
        $this-> data['cate_list'] = $dataCategory;

        //reder view
        $this->render('Product_index',$this->data);

    }

    function addProduct(){
   
        // Xử lý dữ liệu POST từ form và thực hiện các tác vụ cần thiết
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productName = $_POST['productName'];
            $categoryId = $_POST['category'];
            
            
            //Xử lý ảnh
            //$productImage = $_FILES['productImage']['name'];

            if (isset($_FILES['productImage'])) {
                // Thư mục lưu trữ ảnh sản phẩm
                $targetDir = _DIR_ROOT."/app/uploads/";
        
                // Tên file tạm thời trên server
                $tmpFileName = $_FILES['productImage']['tmp_name'];
                // Tên file thật sau khi lưu vào thư mục
                $targetFileName = $targetDir . basename($_FILES['productImage']['name']);
        
                // Di chuyển file tạm thời vào thư mục lưu trữ
                move_uploaded_file($tmpFileName, $targetFileName);

            }

            $productData = [
                'ProductName' => $productName,
                'Category' => $categoryId,
                'Image' => $_FILES['productImage']['name']
            ];
            

             if ($this ->product->addProduct($productData)) {
                header('Location: /DemoRouter/product');
           

        
        } 
    }

    
}

function deleteProduct()   
    {
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            // Lấy ID sản phẩm từ yêu cầu POST
            $productId = $_POST['product_id'];

            // Gọi phương thức xóa sản phẩm từ repository (hoặc model)
            $result = $this ->product->deleteProduct($productId);

            if ($result) {
                // Nếu xóa thành công, chuyển hướng người dùng đến trang danh sách sản phẩm hoặc trang khác
                header('Location: /DemoRouter/product');
                exit();
            } else {
               echo "Lỗi";
            }
        } 
    }
    public function search()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
        
                // Gọi phương thức tìm kiếm sản phẩm từ repository 
                $searchResults = $this->product->searchProduct($keyword);
        
                // Lưu kết quả tìm kiếm vào session
                $_SESSION['search_results'] = $searchResults;
            }
        
            // Hiển thị trang kết quả tìm kiếm
            header('Location: /DemoRouter/product');
        }

    public function getProductInfo() {
           
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
                $productId = $_GET['id'];
        
                // Gọi phương thức trong repository hoặc model để lấy thông tin sản phẩm dựa vào productId
                $productInfo = $this->product->getProductById($productId);
        
                // Trả về thông tin sản phẩm dưới dạng JSON
                header('Content-Type: application/json');
                echo json_encode($productInfo);
                exit();
            }
    }    

    public function updateProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_idEdit'])) {
            // Lấy thông tin sản phẩm từ yêu cầu POST
            $productId = $_POST['product_idEdit'];
            $productName = $_POST['productNameEdit'];
            $categoryId = $_POST['categoryEdit'];

            // Kiểm tra xem có ảnh sản phẩm được gửi lên hay không
            if (isset($_FILES['productImageEdit']) && $_FILES['productImageEdit']['error'] === UPLOAD_ERR_OK) {

                // Nếu có ảnh, thực hiện lưu ảnh và lấy đường dẫn của ảnh
                $targetDir = _DIR_ROOT."/app/uploads/";
        
                // Tên file tạm thời trên server
                $tmpFileName = $_FILES['productImageEdit']['tmp_name'];
                // Tên file thật sau khi lưu vào thư mục
                $targetFileName = $targetDir . basename($_FILES['productImageEdit']['name']);
        
                // Di chuyển file tạm thời vào thư mục lưu trữ
                if (move_uploaded_file($tmpFileName, $targetFileName)) {
                    $image = $_FILES['productImageEdit']['name'];
                }

            } else {
                // Không có ảnh, giữ nguyên ảnh cũ
                $productInfo = $this->product->getProductById($productId);
                $image = $productInfo['Image'] ?? '';
            }

            echo $image;

            // Gọi phương thức updateProduct từ repository để cập nhật thông tin sản phẩm
            $productData = [
                'productId' => $productId,
                'productName' => $productName,
                'category' => $categoryId,
                'image' => $image,
            ];

            $result = $this->product->updateProduct($productData);
            if ($result) {
                // Nếu cập nhật thành công, chuyển hướng người dùng đến trang danh sách sản phẩm hoặc trang khác
                header('Location: /DemoRouter/product');
                exit();
            } else {
               echo'Không thành công';
        }
        }
        else{
            echo 'không thành công';
        } 
    }






}
