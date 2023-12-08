// URL API
const GET_ALL_ORDERS = `http://127.0.0.1:8000/api/user/all_orders`;
// WOW Js
new WOW().init();
// Get Data From Localstorage
let dataUser = JSON.parse(localStorage.getItem("userData"));
let products = JSON.parse(localStorage.getItem("products"));
document.getElementById("count").innerHTML = products === null ? 0 : products.length;
// Get Elements
document.getElementById("name").value = dataUser.name;
document.getElementById("email").value = dataUser.email;
document.getElementById("location").value = dataUser.address;
document.getElementById("phone").value = dataUser.phone;
// Call DATA From Api
fetch(GET_ALL_ORDERS , {
    method: 'Get',
    headers: {
        'Authorization': `Bearer ${dataUser.token}`
    }
}).then(res => res.json())
    .then(data => {
        let dataAll = data.data;
        let count = 0;
        dataAll.forEach(element => {
            count++;
        });
        document.getElementById("totalOrders").value = count;
        document.getElementById("totalSales").value = count === 0 ? 0 : dataAll.map(e => +e.price).reduce((acc, ele) => acc + ele);
    })