<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Nhân viên</title>
    <link rel="stylesheet" href="styles.css">
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
        
        $html .= '<tr data-row="' . $index . '" style="background-color: ' . $mauNen . ';">';
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

// Khởi tạo dữ liệu
$danhSachNhanVien = khoiTaoNhieuNhanVien();

// Tạo dữ liệu JSON để JavaScript sử dụng
$jsonData = json_encode($danhSachNhanVien);
?>

<div class="container">
    <h1>🏢 QUẢN LÝ NHÂN VIÊN</h1>
    
    <div class="info">
        <h3>📋 Thông tin về chương trình:</h3>
        <p><strong>Mảng Nhân Viên:</strong> Mỗi nhân viên có 4 thuộc tính: ID, Họ tên, Tuổi, Hệ số lương</p>
        <p><strong>Tổng số nhân viên:</strong> <span id="totalEmployees"><?php echo count($danhSachNhanVien); ?></span> người</p>
        <p><strong>Chế độ màu hiện tại:</strong> <span id="currentColorMode">Chưa hiển thị</span></p>
    </div>
    
    <!-- g) Phần chuyển đổi giữa hai dạng hiển thị -->
    <div class="controls">
        <h3>🎨 Điều khiển bảng:</h3>
        <button class="btn" id="loadTableBtn" onclick="loadTable()">📋 Load Bảng</button>
        <button class="btn" id="evenOddBtn" onclick="applyEvenOddColors()" disabled>📊 Màu Chẵn/Lẻ</button>
        <button class="btn" id="randomBtn" onclick="applyRandomColors()" disabled>🎲 Màu Ngẫu Nhiên</button>
    </div>
    
    <!-- Container để hiển thị bảng nhân viên -->
    <div id="tableContainer"></div>
    
</div>

<script>
// Dữ liệu nhân viên từ PHP
const employeeData = <?php echo $jsonData; ?>;
let currentEmployees = [...employeeData]; // Copy để có thể xóa

// Màu sáng để random
const lightColors = [
    '#FFE6E6', '#E6F3FF', '#E6FFE6', '#FFF0E6', 
    '#F0E6FF', '#E6FFF0', '#FFE6F0', '#F0FFE6',
    '#E6E6FF', '#FFE6CC', '#CCE6FF', '#E6FFCC'
];

// Hàm tạo bảng HTML
function createTable(employees, colorType = 'evenodd') {
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
    
    employees.forEach((employee, index) => {
        let backgroundColor;
        if (colorType === 'random') {
            backgroundColor = lightColors[Math.floor(Math.random() * lightColors.length)];
        } else {
            backgroundColor = (index + 1) % 2 === 0 ? '#F8F9FA' : '#E9ECEF';
        }
        
        html += `<tr data-row="${index}" style="background-color: ${backgroundColor};">`;
        html += `<td>${employee.id}</td>`;
        html += `<td>${employee.hoten}</td>`;
        html += `<td>${employee.tuoi}</td>`;
        html += `<td>${employee.hsl}</td>`;
        html += '<td><button class="delete-btn" onclick="deleteRow(this)">Xóa</button></td>';
        html += '</tr>';
    });
    
    html += '</tbody>';
    html += '</table>';
    
    return html;
}

// Hàm load bảng
function loadTable() {
    currentEmployees = [...employeeData]; // Reset dữ liệu
    const tableContainer = document.getElementById('tableContainer');
    tableContainer.innerHTML = createTable(currentEmployees, 'evenodd');
    
    // Enable các nút màu
    document.getElementById('evenOddBtn').disabled = false;
    document.getElementById('randomBtn').disabled = false;
    
    // Update thông tin
    document.getElementById('totalEmployees').textContent = currentEmployees.length;
    document.getElementById('currentColorMode').textContent = 'Màu chẵn/lẻ';
    
    // Update trạng thái nút
    updateButtonStates('evenodd');
}

// Hàm áp dụng màu chẵn/lẻ
function applyEvenOddColors() {
    const tableContainer = document.getElementById('tableContainer');
    tableContainer.innerHTML = createTable(currentEmployees, 'evenodd');
    document.getElementById('currentColorMode').textContent = 'Màu chẵn/lẻ';
    updateButtonStates('evenodd');
}

// Hàm áp dụng màu ngẫu nhiên
function applyRandomColors() {
    const tableContainer = document.getElementById('tableContainer');
    tableContainer.innerHTML = createTable(currentEmployees, 'random');
    document.getElementById('currentColorMode').textContent = 'Màu ngẫu nhiên';
    updateButtonStates('random');
}

// Hàm xóa dòng
function deleteRow(button) {
    const row = button.closest('tr');
    const rowIndex = parseInt(row.getAttribute('data-row'));
    
    // Xóa khỏi mảng dữ liệu
    currentEmployees.splice(rowIndex, 1);
    
    // Cập nhật lại bảng với index mới
    const currentColorMode = document.getElementById('currentColorMode').textContent;
    const colorType = currentColorMode === 'Màu ngẫu nhiên' ? 'random' : 'evenodd';
    
    const tableContainer = document.getElementById('tableContainer');
    tableContainer.innerHTML = createTable(currentEmployees, colorType);
    
    // Update số lượng nhân viên
    document.getElementById('totalEmployees').textContent = currentEmployees.length;
}

// Hàm cập nhật trạng thái nút
function updateButtonStates(activeType) {
    // Reset tất cả nút
    document.querySelectorAll('.btn').forEach(btn => btn.classList.remove('active'));
    
    // Active nút hiện tại
    if (activeType === 'evenodd') {
        document.getElementById('evenOddBtn').classList.add('active');
    } else if (activeType === 'random') {
        document.getElementById('randomBtn').classList.add('active');
    }
}
</script>

</body>
</html>
