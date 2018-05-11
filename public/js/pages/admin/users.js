"use strict";


function fetchUserFromSearch(){
    let uname = $("#userSearch").val();
    fetchUser(uname);
    return false;
}


function fetchUser(uname){
    $.ajax({
        type: "GET",
        url: "/api/admin/user/"+uname
    }).done(function(data) {
        let ddata = JSON.parse(data);
        if(ddata == ""){ // empty
            swal("User not found!", "You may use the button in the upper-right corner to list all users.", "error");
        }else{
            fillSpaces(ddata[0]);
            swal({
                title: 'User loaded!',
                text: ' ', /* please keep the space here for design reasons */
                icon: 'success',
                timer: 600,
                buttons: false
            });
        }
    });
}


function fillSpaces(user){

    // locked inputs
    $("#username").val(user.username);
    $("#realName").val(user.name);
    $("#birthdate").val(user.birthdate);
    $("#email").val(user.email);
    $("#aboutme").val(user.description);

    // spans
    $("#registerDate").text(user.register_date);
    $("#lastSeenDate").text(user.last_login);
    $("#uID").text(user.id);
    updateBlockButton(user.type);
    enableButtons(user.type);
}

function enableButtons(uType){
    $(".sideButtons").find("button").attr("disabled", false);
}

function blockUser(){ // aplies to currently selected user.
    let uid = getCurrentSelectedUserID();
    if(uid==-1) return false;
    $.ajax({
        type: "PUT",
        url: '../api/admin/user/'+uid+'/block',
    }).done(function(data) {
       if(!data.success){
        swal({
            title: 'Error!',
            text: data.msg, /* please keep the space here for design reasons */
            icon: 'error',
            timer: 6000
        });
       }
       else{
            if(data.newType == 'banned'){
                swal({
                    title: 'Success!',
                    text: "The user has been successfully blocked!", /* please keep the space here for design reasons */
                    icon: 'success',
                    timer: 6000
                });
            }else{
                swal({
                    title: 'Success!',
                    text: "The user has been successfully unblocked!", /* please keep the space here for design reasons */
                    icon: 'success',
                    timer: 6000
                });
            }
           updateBlockButton(data.newType);
       }
    }).fail(function(){
        alert("Update failed. Try again later!");
    });
}

function updateBlockButton(nType){
    let btn = $('#blockUserBtn');

    if(nType == 'banned'){
        $(btn).text('Unblock User');
    }else{
        $(btn).text('Block User');
    }
}

function getCurrentSelectedUserID(){

    let uid = $("#uID").text();
    if(uid=="n/a" || uid == ""){
        swal({
            title: 'Error!',
            text: 'Present user could not be loaded. Please try again.', /* please keep the space here for design reasons */
            icon: 'error',
            timer: 6000,
            buttons: true
        });
    }
    return uid;    
}

$(".list-group-item").click( function() {
    fetchUser($(this).text());
    $('#showAllUsersModal').modal('hide');
});

function deleteUsersPosts(){
    let uid = getCurrentSelectedUserID();
    if(uid==-1) return false;
    
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        buttons: {
            cancel: "Cancel",
            delete: true,
        }
    }).then((result) => {
        if (result == 'delete') {
            $.ajax({
                type: "DELETE",
                url: '../api/admin/user/'+uid+'/deletePosts',
            }).done(function(data) {
                swal({
                    title: 'Posts Deleted!',
                    text: data.n + " post(s) were deleted.",
                    icon: 'success',
                    timer: 6000
                })
            });
        }
    })
}

function deleteUsersComments(){
    let uid = getCurrentSelectedUserID();
    if(uid==-1) return false;
    
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        buttons: {
            cancel: "Cancel",
            delete: true,
        }
    }).then((result) => {
        if (result == 'delete') {
            $.ajax({
                type: "DELETE",
                url: '../api/admin/user/'+uid+'/deleteComments',
            }).done(function(data) {
                swal({
                    title: 'Comments Deleted!',
                    text: data.n + " comment(s) were deleted.",
                    icon: 'success',
                    timer: 6000
                })
            });
        }
    })
}