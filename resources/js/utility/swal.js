window.UtilSwal = {
    // 通用 Info
    showInfo: function(title = '系統提示', text = '') {
        Swal.fire({
            icon: 'info',
            title: title,
            text: text,
            showConfirmButton: true,
        });
    },
    // 通用 Success
    showSuccess: function(title = '操作成功', text = '') {
        Swal.fire({
            icon: 'success',
            title: title,
            text: text,
            showConfirmButton: true,
        });
    },
    // 通用 Warning
    showWarning: function(title = '系統警告', text = '') {
        Swal.fire({
            icon: 'warning',
            title: title,
            text: text,
            showConfirmButton: true,
        });
    },
    // 通用 Error
    showError: function(title = '操作失敗', text = '') {
        Swal.fire({
            icon: 'error',
            title: title,
            text: text,
            showConfirmButton: true,
        });
    },
    // 確認表單送出
    formSubmit: function(cb) {
        Swal.fire({
            icon: 'warning',
            title: '是否確認送出？',
            confirmButtonColor: '#3085d6',
            confirmButtonText: '確定',
            showCancelButton: true,
            cancelButtonText: '取消',
        }).then(result => {
            if (result.isConfirmed) {
                UtilSwal.showLoading();
                if(cb) {
                    cb();
                }
                else {
                    setTimeout(function () {
                        UtilSwal.showError('抱歉，有東西出錯了');
                    }, 250);
                }
            }
        });
    },
    // 等待 Loading 用
    showLoading: function() {
        Swal.fire({
            icon: 'info',
            title: '處理中，請稍後',
            showConfirmButton: false,
            showCloseButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });
    },
    // 確認後跳轉頁面
    showRedirectMessage: function(title = '', href = '/') {
        Swal.fire({
            icon: 'success',
            title: title,
            confirmButtonColor: '#3085d6',
            confirmButtonText: '確定',
            allowOutsideClick: false,
        }).then(result => {
            if (result.isConfirmed) {
                location.href = href;
            }
        });
    },
}
