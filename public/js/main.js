//authentication
// user details
var username = localStorage.getItem('user_name');

if (username !== null) {
    $('.guest').addClass('d-none');
    $('#navbarDropdown').text(username)
} else {
    $('.guest').removeClass('d-none');
    $('.auth').addClass('d-none');
}

//logout
$('#logout').on('click', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'GET',
        headers: { "Authorization": 'Bearer ' + localStorage.getItem('api_token') },
        url: '/api/logout',
        success: function (result) {
            console.log(result);
            localStorage.removeItem("api_token");
            localStorage.removeItem("user_id");
            localStorage.removeItem("user_name");
            location.href = '/';
        },
        error: function (err) {
            console.log(err);
        }
    })
})
