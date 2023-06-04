window.UtilAjax = {
    // 通用 SubmitAjax
    formSubmit: function(url, method = 'POST', postData) {
        axios({
            url: url,
            method: method,
            data: postData,
        }).then(function (response) {
            // handle success
            const code = response.status;
            const respJson = response.data;
            if(respJson.message && respJson.redirect) {
                UtilSwal.showRedirectMessage(respJson.message, respJson.redirect);
            }
            else if(respJson.redirect) {
                location.href = respJson.redirect;
            }
            else {
                UtilSwal.showSuccess(respJson.message);
            }
        }).catch(function (error) {
            // handle error
            const code = error.response.status;
            const respJson = error.response.data;
            if(/^4/.test(code)) {
                UtilSwal.showError(respJson.message);
            }
            else {
                UtilSwal.showError();
                console.log(error);
            }
        });
    },
}
