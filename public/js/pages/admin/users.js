"use strict";

var ulen = -1;
var urlPrefix = "";

$("#userSearch").on('input',function(e){
    let uname = $("#userSearch").val().trim();
    if (ulen < uname.length && uname != ''){
        populateUserSearchList(uname);
    }
    ulen = uname.length        
    //fetchUser(uname);
});

function populateUserSearchList(uname){

    let template = '<span onclick="return preFetchUser(this)" class="bg-primary text-white p-1 m-1"></span>';
    let noResults = '<span class="bg-danger text-white p-2 m-1">No results!</span>';
    $.ajax({
        type: "GET",
        url: "/api/admin/usersSearch/"+uname
    }).done(function(data) {
        $("#user-search-result").html(""); // empty
        data.forEach(function(user) {
            $("#user-search-result").append(template);
            $("#user-search-result > *").last().text(user.username);
        });

        if(data.length == 1){
            fetchUser(data[0].username);    
        }else if(data.length == 0){
            $("#user-search-result").html(noResults);
        }
    });
}

function preFetchUser(event){
    fetchUser($(event).text());
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
        $("#blockedUser").show();
    }else{
        $(btn).text('Block User');
        $("#blockedUser").hide();
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
                url: urlPrefix+'/api/admin/user/'+uid+'/deletePosts',
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
                url: urlPrefix+'/api/admin/user/'+uid+'/deleteComments',
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

function deleteUsersAvatar(){
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
                url: urlPrefix+'/api/admin/user/'+uid+'/deleteAvatar',
            }).done(function(data) {
                if(data.success){
                    swal({
                        title: 'Avatar Deleted!',
                        text: " ",
                        icon: 'success',
                        timer: 6000
                    });
                }else{
                    swal({
                        title: 'Could not delete the avatar!',
                        text: "There were no files to delete!",
                        icon: 'error',
                        timer: 6000
                    });
                }
            });
        }
    })
}

$(function() {
    let n = document.location.href.substr(document.location.href.lastIndexOf('/')+1);
    if( n != 'users' && n!= ''){ // id is set
        urlPrefix="../..";
        fetchUser(n);
    }
    else{
        urlPrefix="..";
    }
});