//API
const UPDATE_DATA = 'http://127.0.0.1:8000/api/admin/update_data';
// Get Data From Localstorage
let dataUser = JSON.parse(localStorage.getItem("userData"));
// Get Elements
function adminData(){
    document.getElementById("username").value = dataUser.name;
    document.getElementById("email").value = dataUser.email;
    document.getElementById("role").value = dataUser.role;
}

adminData();

//Send data
submit.addEventListener('submit', function (e) {
    if (username.value.trim()) {
        e.preventDefault();
        const formData = new FormData();
        formData.append('name', username.value);
        formData.append('email', email.value);
        formData.append('password', password.value);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', UPDATE_DATA, true);
        xhr.addEventListener('load', function () {
            if (xhr.status === 201) {
                    swal("Your data has been updated", "", "success");
                    dataUser.name = username.value;
                    localStorage.setItem("userData", JSON.stringify(dataUser));
                    password.value = ''
                    adminData();
            } else {
                // Handle non-200 status code (e.g., server error)
                swal("Server error. Please try again later", "", "error");
            }
        });
        xhr.send(formData);
    }
});
