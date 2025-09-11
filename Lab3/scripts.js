// Mảng lưu trữ dữ liệu
let danhSach = [];
let dangSua = false; // Biến kiểm tra có đang sửa hay không
let viTriSua = -1; // Vị trí đang sửa


function luuDuLieu() {
    localStorage.setItem('danhSachThongTin', JSON.stringify(danhSach));
}


function taiDuLieu() {
    let duLieuLuu = localStorage.getItem('danhSachThongTin');
    if (duLieuLuu) {
        
        danhSach = JSON.parse(duLieuLuu);
    } else {
        //mock data
        danhSach.push({
            hoTen: 'Nguyễn A',
            ngaySinh: '01/01/2005',
            gioiTinh: 'Nam',
            queQuan: 'Thanh Hóa'
        });
        
        luuDuLieu();
    }
}


function themThongTin() {
    
    let hoTen = document.getElementById('hoTen').value;
    let ngaySinh = document.getElementById('ngaySinh').value;
    let queQuan = document.getElementById('queQuan').value;
    

    let gioiTinh = '';
    if (document.getElementById('nam').checked) {
        gioiTinh = 'Nam';
    } else if (document.getElementById('nu').checked) {
        gioiTinh = 'Nữ';
    }
    

    if (hoTen === '' || ngaySinh === '' || queQuan === '') {
        alert('Vui lòng nhập đầy đủ thông tin!');
        return;
    }
    

    let ngaySinhFormatted = chuyenDoiNgay(ngaySinh);
    
    if (dangSua) {

        danhSach[viTriSua] = {
            hoTen: hoTen,
            ngaySinh: ngaySinhFormatted,
            gioiTinh: gioiTinh,
            queQuan: queQuan
        };
        dangSua = false;
        viTriSua = -1;
        
        let nutThem = document.querySelector('button[onclick="themThongTin()"]');
        nutThem.textContent = 'Thêm';
        nutThem.className = 'btn btn-primary';
    } else {

        let thongTinMoi = {
            hoTen: hoTen,
            ngaySinh: ngaySinhFormatted,
            gioiTinh: gioiTinh,
            queQuan: queQuan
        };
        
        // Thêm vào mảng
        danhSach.push(thongTinMoi);
    }
    

    luuDuLieu();
    
    capNhatBang();
    
    xoaForm();
}


function chuyenDoiNgay(ngay) {
    let parts = ngay.split('-');
    return parts[2] + '/' + parts[1] + '/' + parts[0];
}

function capNhatBang() {
    let tbody = document.getElementById('danhSachThongTin');
    tbody.innerHTML = ''; 
    
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
        

        tbody.appendChild(dong);
    }
}

function xoaThongTin(button) {
    console.log('Hàm xoaThongTin được gọi');
    

    let viTri = parseInt(button.getAttribute('data-index'));
    console.log('Vị trí cần xóa:', viTri);
    console.log('Dữ liệu trước khi xóa:', danhSach);
    
    if (confirm('Bạn có chắc muốn xóa thông tin này?')) {
        console.log('Người dùng xác nhận xóa');
        
        danhSach.splice(viTri, 1);
        console.log('Dữ liệu sau khi xóa:', danhSach);
        
        luuDuLieu();
        console.log('Đã lưu dữ liệu vào localStorage');
        
        capNhatBang();
        console.log('Đã cập nhật lại bảng');
    } else {
        console.log('Người dùng hủy xóa');
    }
}

// Hàm sửa thông tin
function suaThongTin(button) {
    let viTri = parseInt(button.getAttribute('data-index'));
    
    let thongTin = danhSach[viTri];
    
    document.getElementById('hoTen').value = thongTin.hoTen;
    document.getElementById('queQuan').value = thongTin.queQuan;
    
    let ngaySinhParts = thongTin.ngaySinh.split('/');
    let ngaySinhFormatted = ngaySinhParts[2] + '-' + ngaySinhParts[1] + '-' + ngaySinhParts[0];
    document.getElementById('ngaySinh').value = ngaySinhFormatted;
    
    if (thongTin.gioiTinh === 'Nam') {
        document.getElementById('nam').checked = true;
    } else {
        document.getElementById('nu').checked = true;
    }
    
    dangSua = true;
    viTriSua = viTri;
    
    let nutThem = document.querySelector('button[onclick="themThongTin()"]');
    nutThem.textContent = 'Cập nhật';
    nutThem.className = 'btn btn-success';
}

function xoaForm() {
    document.getElementById('hoTen').value = '';
    document.getElementById('ngaySinh').value = '';
    document.getElementById('queQuan').value = '';
    document.getElementById('nam').checked = true;
}

function xoaTatCa() {
    if (confirm('Bạn có chắc muốn xóa tất cả dữ liệu?')) {
        danhSach = [];
        luuDuLieu();
        capNhatBang();
    }
}

window.onload = function() {
    taiDuLieu();
    capNhatBang();
};