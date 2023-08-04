<!DOCTYPE html>
<html>
<head>
    <title>Trang PHP sử dụng Bootstrap và Font Awesome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-globe"></i> Danh sách danh mục</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['cate_list'] as $category): ?>
                    <tr>
                        <td><?php echo $category['CategoryName'] ?></td>
                        <td><?php echo '123'; ?></td>
                        <td><?php echo '567'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>