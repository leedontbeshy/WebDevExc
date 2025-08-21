// Mảng lưu trữ dữ liệu
let danhSach = [];
let dangSua = false; // Biến kiểm tra có đang sửa hay không
let viTriSua = -1; // Vị trí đang sửa

// Hàm lưu dữ liệu vào localStorage (bộ nhớ trình duyệt)
function luuDuLieu() {
    localStorage.setItem('danhSachThongTin', JSON.stringify(danhSach));
}

// Hàm tải dữ liệu từ localStorage
function taiDuLieu() {
    let duLieuLuu = localStorage.getItem('danhSachThongTin');
    if (duLieuLuu) {
        // Nếu có dữ liệu đã lưu, tải lên
        danhSach = JSON.parse(duLieuLuu);
    } else {
        // Nếu chưa có dữ liệu, thêm dữ liệu mẫu
        danhSach.push({
            hoTen: 'Nguyễn A',
            ngaySinh: '01/01/2005',
            gioiTinh: 'Nam',
            queQuan: 'Thanh Hóa'
        });
        // Lưu dữ liệu mẫu vào localStorage
        luuDuLieu();
    }
}

// Hàm thêm thông tin mới
function themThongTin() {
    // Lấy dữ liệu từ form
    let hoTen = document.getElementById('hoTen').value;
    let ngaySinh = document.getElementById('ngaySinh').value;
    let queQuan = document.getElementById('queQuan').value;
    
    // Lấy giới tính được chọn
    let gioiTinh = '';
    if (document.getElementById('nam').checked) {
        gioiTinh = 'Nam';
    } else if (document.getElementById('nu').checked) {
        gioiTinh = 'Nữ';
    }
    
    // Kiểm tra dữ liệu có đầy đủ không
    if (hoTen === '' || ngaySinh === '' || queQuan === '') {
        alert('Vui lòng nhập đầy đủ thông tin!');
        return;
    }
    
    // Chuyển đổi ngày sinh sang định dạng dd/mm/yyyy
    let ngaySinhFormatted = chuyenDoiNgay(ngaySinh);
    
    if (dangSua) {
        // Nếu đang sửa, cập nhật thông tin
        danhSach[viTriSua] = {
            hoTen: hoTen,
            ngaySinh: ngaySinhFormatted,
            gioiTinh: gioiTinh,
            queQuan: queQuan
        };
        dangSua = false;
        viTriSua = -1;
        
        // Đổi text nút về "Thêm"
        let nutThem = document.querySelector('button[onclick="themThongTin()"]');
        nutThem.textContent = 'Thêm';
        nutThem.className = 'btn btn-primary';
    } else {
        // Tạo đối tượng thông tin mới
        let thongTinMoi = {
            hoTen: hoTen,
            ngaySinh: ngaySinhFormatted,
            gioiTinh: gioiTinh,
            queQuan: queQuan
        };
        
        // Thêm vào mảng
        danhSach.push(thongTinMoi);
    }
    
    // Lưu dữ liệu vào localStorage
    luuDuLieu();
    
    // Cập nhật bảng
    capNhatBang();
    
    // Xóa dữ liệu trong form
    xoaForm();
}

// Hàm chuyển đổi ngày từ yyyy-mm-dd sang dd/mm/yyyy
function chuyenDoiNgay(ngay) {
    let parts = ngay.split('-');
    return parts[2] + '/' + parts[1] + '/' + parts[0];
}

// Hàm cập nhật bảng
function capNhatBang() {
    let tbody = document.getElementById('danhSachThongTin');
    tbody.innerHTML = ''; // Xóa nội dung cũ
    
    // Duyệt qua từng phần tử trong mảng
    for (let i = 0; i < danhSach.length; i++) {
        let dong = document.createElement('tr');
        
        // Tạo các ô dữ liệu
        dong.innerHTML = 
            '<td>' + (i + 1) + '</td>' +
            '<td>' + danhSach[i].hoTen + '</td>' +
            '<td>' + danhSach[i].ngaySinh + '</td>' +
            '<td>' + danhSach[i].gioiTinh + '</td>' +
            '<td>' + danhSach[i].queQuan + '</td>' +
            '<td><button class="btn btn-danger btn-sm" data-index="' + i + '" onclick="xoaThongTin(this)">X</button></td>' +
            '<td><button class="btn btn-warning btn-sm" data-index="' + i + '" onclick="suaThongTin(this)">✏️</button></td>';
        
        // Thêm dòng vào bảng
        tbody.appendChild(dong);
    }
}

// Hàm xóa thông tin
function xoaThongTin(button) {
    console.log('Hàm xoaThongTin được gọi');
    
    // Lấy chỉ số từ data-index
    let viTri = parseInt(button.getAttribute('data-index'));
    console.log('Vị trí cần xóa:', viTri);
    console.log('Dữ liệu trước khi xóa:', danhSach);
    
    // Hỏi xác nhận trước khi xóa
    if (confirm('Bạn có chắc muốn xóa thông tin này?')) {
        console.log('Người dùng xác nhận xóa');
        
        // Xóa phần tử tại vị trí được chỉ định
        danhSach.splice(viTri, 1);
        console.log('Dữ liệu sau khi xóa:', danhSach);
        
        // Lưu dữ liệu sau khi xóa
        luuDuLieu();
        console.log('Đã lưu dữ liệu vào localStorage');
        
        // Cập nhật lại bảng
        capNhatBang();
        console.log('Đã cập nhật lại bảng');
    } else {
        console.log('Người dùng hủy xóa');
    }
}

// Hàm sửa thông tin
function suaThongTin(button) {
    // Lấy chỉ số từ data-index
    let viTri = parseInt(button.getAttribute('data-index'));
    
    // Lấy thông tin cần sửa
    let thongTin = danhSach[viTri];
    
    // Đưa thông tin lên form
    document.getElementById('hoTen').value = thongTin.hoTen;
    document.getElementById('queQuan').value = thongTin.queQuan;
    
    // Chuyển đổi ngày sinh về định dạng yyyy-mm-dd
    let ngaySinhParts = thongTin.ngaySinh.split('/');
    let ngaySinhFormatted = ngaySinhParts[2] + '-' + ngaySinhParts[1] + '-' + ngaySinhParts[0];
    document.getElementById('ngaySinh').value = ngaySinhFormatted;
    
    // Chọn giới tính
    if (thongTin.gioiTinh === 'Nam') {
        document.getElementById('nam').checked = true;
    } else {
        document.getElementById('nu').checked = true;
    }
    
    // Đánh dấu đang sửa
    dangSua = true;
    viTriSua = viTri;
    
    // Đổi text nút thành "Cập nhật"
    let nutThem = document.querySelector('button[onclick="themThongTin()"]');
    nutThem.textContent = 'Cập nhật';
    nutThem.className = 'btn btn-success';
}

// Hàm xóa form
function xoaForm() {
    document.getElementById('hoTen').value = '';
    document.getElementById('ngaySinh').value = '';
    document.getElementById('queQuan').value = '';
    document.getElementById('nam').checked = true;
}

// Hàm xóa tất cả dữ liệu (bonus)
function xoaTatCa() {
    if (confirm('Bạn có chắc muốn xóa tất cả dữ liệu?')) {
        danhSach = [];
        luuDuLieu();
        capNhatBang();
    }
}

// Tải dữ liệu khi trang được tải
window.onload = function() {
    // Tải dữ liệu từ localStorage
    taiDuLieu();
    
    // Cập nhật bảng hiển thị
    capNhatBang();
};