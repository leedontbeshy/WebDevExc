<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Nhân viên</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>

<?php
// a) Khai báo mảng Nhân Viên với 4 phần tử
function khaiBaoNhanVien($id, $hoten, $tuoi, $hsl) {
    return array(
        'id' => $id,
        'hoten' => $hoten,
        'tuoi' => $tuoi,
        'hsl' => $hsl
    );
}

// b) Hàm khởi tạo thông tin cho một đối tượng nhân viên
function khoiTaoNhanVien($id, $hoten, $tuoi, $hsl) {
    return khaiBaoNhanVien($id, $hoten, $tuoi, $hsl);
}

// c) Hàm khởi tạo thông tin cho nhiều đối tượng nhân viên
function khoiTaoNhieuNhanVien() {
    $danhSachNhanVien = array();
    
    // Thêm dữ liệu mẫu
    $danhSachNhanVien[] = khoiTaoNhanVien('NV001', 'Nguyễn Văn An', 28, 3.5);
    $danhSachNhanVien[] = khoiTaoNhanVien('NV002', 'Trần Thị Bình', 32, 4.2);
    $danhSachNhanVien[] = khoiTaoNhanVien('NV003', 'Lê Văn Cường', 25, 2.8);
    $danhSachNhanVien[] = khoiTaoNhanVien('NV004', 'Phạm Thị Dung', 29, 3.8);
    $danhSachNhanVien[] = khoiTaoNhanVien('NV005', 'Hoàng Văn Em', 35, 4.5);
    $danhSachNhanVien[] = khoiTaoNhanVien('NV006', 'Vũ Thị Phương', 27, 3.2);
    $danhSachNhanVien[] = khoiTaoNhanVien('NV007', 'Đặng Văn Giang', 31, 4.0);
    $danhSachNhanVien[] = khoiTaoNhanVien('NV008', 'Bùi Thị Hoa', 26, 3.6);
    
    return $danhSachNhanVien;
}

// d) Hàm tạo bảng table để hiển thị thông tin nhân viên
function taoBangNhanVien($danhSachNhanVien, $loaiMau = 'chanle') {
    $html = '<table id="employeeTable">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th>ID</th>';
    $html .= '<th>Họ và Tên</th>';
    $html .= '<th>Tuổi</th>';
    $html .= '<th>Hệ số Lương</th>';
    $html .= '<th>Thao tác</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
    
    $stt = 0;
    foreach ($danhSachNhanVien as $index => $nhanVien) {
        $stt++;
        
        // Áp dụng màu theo loại được chọn
        if ($loaiMau == 'random') {
            $mauNen = taoMauNgauNhien();
        } else {
            $mauNen = taoMauChanLe($stt);
        }
        
        $html .= '<tr style="background-color: ' . $mauNen . ';" data-index="' . $index . '">';
        $html .= '<td>' . htmlspecialchars($nhanVien['id']) . '</td>';
        $html .= '<td>' . htmlspecialchars($nhanVien['hoten']) . '</td>';
        $html .= '<td>' . htmlspecialchars($nhanVien['tuoi']) . '</td>';
        $html .= '<td>' . htmlspecialchars($nhanVien['hsl']) . '</td>';
        $html .= '<td><button class="delete-btn" onclick="deleteRow(this)">Xóa</button></td>';
        $html .= '</tr>';
    }
    
    $html .= '</tbody>';
    $html .= '</table>';
    
    return $html;
}

// e) Hàm khởi tạo màu ngẫu nhiên cho từng dòng
function taoMauNgauNhien() {
    $mauSang = array(
        '#FFE6E6', '#E6F3FF', '#E6FFE6', '#FFF0E6', 
        '#F0E6FF', '#E6FFF0', '#FFE6F0', '#F0FFE6',
        '#E6E6FF', '#FFE6CC', '#CCE6FF', '#E6FFCC'
    );
    
    return $mauSang[array_rand($mauSang)];
}

// f) Hàm khởi tạo màu chẵn/lẻ cho bảng
function taoMauChanLe($stt) {
    if ($stt % 2 == 0) {
        // Dòng chẵn - màu sáng
        return '#F8F9FA';
    } else {
        // Dòng lẻ - màu tối hơn
        return '#E9ECEF';
    }
}

// Xử lý chuyển đổi màu - mặc định ẩn bảng
$loaiMau = isset($_GET['mau']) ? $_GET['mau'] : 'chanle';
$showTable = isset($_GET['show']) ? true : false;

// Khởi tạo dữ liệu
$danhSachNhanVien = khoiTaoNhieuNhanVien();

// Chuyển dữ liệu PHP sang JavaScript
$jsData = json_encode($danhSachNhanVien);
?>

<div class="container">
    <h1>🏢 QUẢN LÝ NHÂN VIÊN</h1>
    
    <div class="info">
        <h3>📋 Thông tin về chương trình:</h3>
        <p><strong>Mảng Nhân Viên:</strong> Mỗi nhân viên có 4 thuộc tính: ID, Họ tên, Tuổi, Hệ số lương</p>
        <p><strong>Tổng số nhân viên:</strong> <span id="totalEmployees"><?php echo count($danhSachNhanVien); ?></span> người</p>
        <p><strong>Chế độ màu hiện tại:</strong> <span id="currentMode">Chưa chọn</span></p>
    </div>
    
    <!-- Các nút điều khiển -->
    <div class="controls">
        <h3>🎨 Chọn chế độ hiển thị:</h3>
        <button id="loadBtn" class="btn" onclick="loadTable()">📊 Load Bảng</button>
        <button id="evenOddBtn" class="btn" onclick="applyEvenOddColor()">� Màu Chẵn/Lẻ</button>
        <button id="randomBtn" class="btn" onclick="applyRandomColor()">🎲 Màu Ngẫu Nhiên</button>
        <button id="refreshBtn" class="btn" onclick="refreshTable()">🔄 Làm mới</button>
    </div>
    
    <!-- Container cho bảng -->
    <div id="tableContainer"></div>
    
    
</div>

<script>
// Dữ liệu nhân viên từ PHP
let employeesData = <?php echo $jsData; ?>;
let originalData = JSON.parse(JSON.stringify(employeesData)); // Backup dữ liệu gốc

// Màu sáng cho random
const lightColors = [
    '#FFE6E6', '#E6F3FF', '#E6FFE6', '#FFF0E6', 
    '#F0E6FF', '#E6FFF0', '#FFE6F0', '#F0FFE6',
    '#E6E6FF', '#FFE6CC', '#CCE6FF', '#E6FFCC'
];

// Hàm tạo màu ngẫu nhiên
function getRandomColor() {
    return lightColors[Math.floor(Math.random() * lightColors.length)];
}

// Hàm tạo màu chẵn lẻ
function getEvenOddColor(index) {
    return (index % 2 === 0) ? '#F8F9FA' : '#E9ECEF';
}

// Hàm tạo bảng HTML
function createTable(colorMode = 'evenodd') {
    if (employeesData.length === 0) {
        return '<p>Không có dữ liệu nhân viên để hiển thị.</p>';
    }

    let html = '<table id="employeeTable" class="show">';
    html += '<thead>';
    html += '<tr>';
    html += '<th>ID</th>';
    html += '<th>Họ và Tên</th>';
    html += '<th>Tuổi</th>';
    html += '<th>Hệ số Lương</th>';
    html += '<th>Thao tác</th>';
    html += '</tr>';
    html += '</thead>';
    html += '<tbody>';
    
    employeesData.forEach((employee, index) => {
        let bgColor;
        if (colorMode === 'random') {
            bgColor = getRandomColor();
        } else {
            bgColor = getEvenOddColor(index);
        }
        
        html += `<tr style="background-color: ${bgColor};" data-index="${index}">`;
        html += `<td>${employee.id}</td>`;
        html += `<td>${employee.hoten}</td>`;
        html += `<td>${employee.tuoi}</td>`;
        html += `<td>${employee.hsl}</td>`;
        html += `<td><button class="delete-btn" onclick="deleteRow(this)">Xóa</button></td>`;
        html += '</tr>';
    });
    
    html += '</tbody>';
    html += '</table>';
    
    return html;
}

// Hàm load bảng lần đầu
function loadTable() {
    document.getElementById('tableContainer').innerHTML = createTable('evenodd');
    updateCurrentMode('Màu Chẵn/Lẻ');
    updateActiveButton('loadBtn');
}

// Hàm áp dụng màu chẵn lẻ
function applyEvenOddColor() {
    const table = document.getElementById('employeeTable');
    if (!table) {
        alert('Vui lòng Load bảng trước!');
        return;
    }
    
    document.getElementById('tableContainer').innerHTML = createTable('evenodd');
    updateCurrentMode('Màu Chẵn/Lẻ');
    updateActiveButton('evenOddBtn');
}

// Hàm áp dụng màu ngẫu nhiên
function applyRandomColor() {
    const table = document.getElementById('employeeTable');
    if (!table) {
        alert('Vui lòng Load bảng trước!');
        return;
    }
    
    document.getElementById('tableContainer').innerHTML = createTable('random');
    updateCurrentMode('Màu Ngẫu Nhiên');
    updateActiveButton('randomBtn');
}

// Hàm xóa dòng
function deleteRow(button) {
    const row = button.closest('tr');
    const index = parseInt(row.getAttribute('data-index'));
    
    // Xóa khỏi mảng dữ liệu
    employeesData.splice(index, 1);
    
    // Cập nhật lại bảng với màu hiện tại
    const currentMode = document.getElementById('currentMode').textContent;
    let colorMode = currentMode.includes('Ngẫu Nhiên') ? 'random' : 'evenodd';
    
    document.getElementById('tableContainer').innerHTML = createTable(colorMode);
    
    // Cập nhật số lượng nhân viên
    document.getElementById('totalEmployees').textContent = employeesData.length;
}

// Hàm làm mới - khôi phục dữ liệu gốc
function refreshTable() {
    employeesData = JSON.parse(JSON.stringify(originalData));
    document.getElementById('tableContainer').innerHTML = createTable('evenodd');
    document.getElementById('totalEmployees').textContent = employeesData.length;
    updateCurrentMode('Màu Chẵn/Lẻ');
    updateActiveButton('refreshBtn');
}

// Hàm cập nhật chế độ hiện tại
function updateCurrentMode(mode) {
    document.getElementById('currentMode').textContent = mode;
}

// Hàm cập nhật nút active
function updateActiveButton(activeId) {
    // Xóa class active khỏi tất cả nút
    document.querySelectorAll('.btn').forEach(btn => btn.classList.remove('active'));
    // Thêm class active cho nút được chọn
    if (activeId !== 'refreshBtn') {
        document.getElementById(activeId).classList.add('active');
    }
}
</script>

</body>
</html>
