$(document).ready(function(){
    $("#logout").on('click',function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to logout?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                sessionStorage.clear() 
                window.localStorage.clear();
                $.ajax({
                    type: 'GET',
                    url: "/logoutFunction",
                    success: function(response){
                        if(response == 1){
                            window.location = "/login";
                        }
                        else{
                            Swal.fire({
                            icon: 'error',
                            title: 'Logout Failed',
                            showConfirmButton: true,
                        })     
                        }
                    }
                })
            }
        })
    });
});