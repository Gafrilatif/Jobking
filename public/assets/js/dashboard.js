document.getElementById('openModalButton').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('modalPost'));
    modal.show();
});


$(document).ready(function() {
    
    const baseUrl = document.querySelector('meta[name="base-url"]').content;

    $.ajax({
        url: baseUrl + '/dashboard/getCommissions',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            var commissionsHTML = '';

            data.forEach(function(commission) {
                commissionsHTML += `
                    <div class="feature-item py-5 rounded-4" data-bs-toggle="modal" data-bs-target="#commissionModal"
                         data-task-id="${commission.id_task}" 
                         data-username="${commission.username}" 
                         data-task-title="${commission.task_title}" 
                         data-task-tags="${commission.task_tags}" 
                         data-task-desc="${commission.task_description}">
                        <div class="feature-detail d-flex align-items-center">
                            <div class="left-section d-flex align-items-center">
                                <div class="profile-picture me-3 align-items-center justify-content-center">
                                    <img src="${baseUrl}/assets/img/reviwer1.jpg" alt="${commission.username}" class="rounded-circle" width="100" height="100">
                                    <h5 class="text-light username">${commission.username}</h5>
                                </div>
                            </div>
                            <div class="commission-info ms-4">
                                <h2 class="feature-title">${commission.task_title}</h2>
                                <p class="commission-description">${commission.brief_desc}</p>
                                <div class="commission-tags">
                                    ${commission.task_tags.split(',').map(tag => `<span class="tag">${tag.trim()}</span>`).join('')}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
        
            $('#commissions').html(commissionsHTML);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching commission data: " + error);
        }
    });

    $.ajax({
        url: baseUrl + 'dashboard/getAcceptedTask',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            var acceptedtaskHTML = '';

            data.forEach(function(acceptedtask) {
                acceptedtaskHTML += `
                    <li class="list-group-item text-dark accepted-task-item" 
                        data-task-accept="${acceptedtask.id_accept}"
                        data-task-id="${acceptedtask.id_task}" 
                        data-task-title="${acceptedtask.task_title}" 
                        data-task-desc="${acceptedtask.task_description}" 
                        data-task-user="${acceptedtask.username}">
                        ${acceptedtask.task_title}
                    </li>
                `;
            });
            
        
            $('#acceptedtask').html(acceptedtaskHTML);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching commission data: " + error);
        }
    });

    $(document).on('click', '.accepted-task-item', function() {
        const taskId = $(this).data('task-id');
        const acceptId = $(this).data('task-accept');
        const taskTitle = $(this).data('task-title');
        const taskDesc = $(this).data('task-desc');
        const taskUser = $(this).data('task-user');
    
        $('#modalAcceptedTaskTitle').text(taskTitle);
        $('#modalAcceptedTaskDesc').text(taskDesc);
        $('#modalAcceptedTaskUser').text(taskUser);
    
        $('#acceptedTaskModal').data('task-id', taskId);
        $('#acceptedTaskModal').data('task-accept', acceptId);
        $('#acceptedTaskModal').modal('show');
    });

    $('#finishTaskBtn').on('click', function() {
        const acceptId = $('#acceptedTaskModal').data('task-accept');
    
        $.ajax({
            url: baseUrl + 'dashboard/finishTask',
            method: 'POST',
            data: { id_accept: acceptId },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('Task Finished', 'The task has been marked as finished.', 'success').then(() => {
                        $('#acceptedTaskModal').modal('hide');
                        location.reload(); 
                    });
                } else {
                    Swal.fire('Error', 'Could not finish the task.', 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Error', 'Something went wrong. Please try again later.', 'error');
            }
        });
    });

    $(document).on('click', '.feature-item', function() {
        const taskId = $(this).data('task-id');
        const username = $(this).data('username');
        const taskTitle = $(this).data('task-title');
        const taskTags = $(this).data('task-tags').split(',').map(tag => `<span class="tag">${tag.trim()}</span>`).join('');
        const taskDesc = $(this).data('task-desc');

        $('#commissionModal').attr('data-task-id', taskId);
    
        $('#modalUsername').text(username);
        $('#modalTaskTitle').text(taskTitle);
        $('#modalTaskTags').html(taskTags);
        $('#modalTaskDesc').text(taskDesc);
    });
    

    $('#nextStep').on('click', function() {
        $('#modalStep1').addClass('d-none');
        $('#modalStep2').removeClass('d-none');
    });

    $('#backStep').on('click', function() {
        $('#modalStep2').addClass('d-none');
        $('#modalStep1').removeClass('d-none');
    });

    $('#postTask').on('click', function() {
        var taskTitle = $('#taskTitle').val();
        var briefDescription = $('#briefDescription').val();
        var testTags = $('#testTags').val();
        var detailedDescription = $('#detailedDescription').val();

        var formData = {
            taskTitle: taskTitle,
            briefDescription: briefDescription,
            testTags: testTags,
            detailedDescription: detailedDescription
        };

        $.ajax({
            url: baseUrl + '/dashboard/postCommission',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then(function() {
                        // Close the modal and reset the form
                        $('#modalPost').modal('hide');
                        $('#modalStep1').removeClass('d-none');
                        $('#modalStep2').addClass('d-none');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while posting the commission.',
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                });
            }
        });

        
    });

    $('#accept_btn').on('click', function () {
        const taskId = $('#commissionModal').data('task-id');
    
        $.ajax({
            url: baseUrl + 'dashboard/acceptTask', 
            method: 'POST',
            data: {
                id_task: taskId,
            },
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire('Task Accepted', 'The task has been successfully accepted.', 'success').then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', 'Something went wrong while accepting the task.', 'error');
                }
            },
            error: function (xhr, status, error) {
                console.error("Error accepting task:", error);
                Swal.fire('Error', 'Unable to accept the task at the moment.', 'error');
            }
        });
    });

    let conn; 
    let currentRoomId; 
    const messagesDiv = $('#messages');

    const currentUserId = $('body').data('user-id');
    const currentUsername = $('body').data('username');

    $('#chat-tab').on('click', function() {
        $.ajax({
            url: baseUrl + '/dashboard/getChatRooms',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                const chatList = $('#chat-list');
                chatList.html(''); 

                if (data.length > 0) {
                    data.forEach(function(room) {
                        const otherUserName = (room.commissioner_id == currentUserId) 
                                              ? room.freelancer_name 
                                              : room.commissioner_name;

                        const unreadDot = (room.unread_count > 0) 
                                          ? '<span class="unread-dot"></span>' 
                                          : '';

                        const lastMessage = room.last_message ? room.last_message.substring(0, 30) + '...' : 'No messages yet.';

                        const chatListItemHTML = `
                            <div class="chat-room-item" data-room-id="${room.room_id}" data-other-user="${otherUserName}">
                                <div class="profile-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                    </svg>
                                </div>
                                <div class="chat-details">
                                    <div class="chat-user-name">${otherUserName}</div>
                                    <div class="chat-message-preview">${lastMessage}</div>
                                </div>
                                ${unreadDot}
                            </div>
                        `;
                        chatList.append(chatListItemHTML);
                    });
                } else {
                    chatList.html('<p class="p-3">You have no active chats.</p>');
                }
            }
        });
    });

    $('#search-chat-input').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('.chat-room-item').each(function() {
            const userName = $(this).data('other-user').toLowerCase();
            if (userName.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });


    $(document).on('click', '.chat-room-item', function() {
        $('#chat-list-container').hide();
        $('#chat-window-container').show();

        currentRoomId = $(this).data('room-id');
        const otherUser = $(this).data('other-user');

        $('.chat-room-item').removeClass('active');
        $(this).addClass('active');

        $(this).find('.unread-dot').remove();

        $('.chat-room-item').removeClass('active');
        $(this).addClass('active');
        $('#chat-window-header').text(`Chat with ${otherUser}`);
        messagesDiv.html('<p class="p-3 text-center">Loading message history...</p>');

        $.ajax({
            url: baseUrl + '/dashboard/markChatAsRead/' + currentRoomId,
            method: 'POST'
        });

        $.ajax({
            url: baseUrl + '/dashboard/getMessages/' + currentRoomId,
            method: 'GET',
            dataType: 'json',
            success: function(history) {
                messagesDiv.html(''); // Clear the "loading" message

                if (history.length > 0) {
                    history.forEach(function(message) {
                        const senderName = message.sender_id == currentUserId ? 'You' : otherUser;
                        const messageClass = message.sender_id == currentUserId ? 'message-sent' : 'message-received';
                        
                        messagesDiv.append(`
                            <div class="message-wrapper ${messageClass}">
                                <div class="message-bubble">
                                    <strong>${senderName}:</strong><br>
                                    ${message.message_text}
                                </div>
                            </div>
                        `);
                    });
                } else {
                    messagesDiv.html('<p class="p-3 text-center">No messages yet. Say hello!</p>');
                }
                messagesDiv.scrollTop(messagesDiv[0].scrollHeight);
            },
            error: function() {
                messagesDiv.html('<p class="p-3 text-center text-danger">Could not load messages.</p>');
            }
        });

        if (conn) {
            conn.close();
        }
        conn = new WebSocket('ws://localhost:8080');

        conn.onopen = function(e) {
            console.log("Connection established for room: " + currentRoomId);
            conn.send(JSON.stringify({
                type: 'register',
                roomId: currentRoomId,
                userId: currentUserId
            }));
        };

        conn.onmessage = function(e) {
            const data = JSON.parse(e.data);
            if (data.roomId === currentRoomId) {
                const messageClass = data.userId == currentUserId ? 'message-sent' : 'message-received';
                
                messagesDiv.append(`
                    <div class="message-wrapper ${messageClass}">
                        <div class="message-bubble">
                            <strong>${data.user}:</strong><br>
                            ${data.message}
                        </div>
                    </div>
                `);
                messagesDiv.scrollTop(messagesDiv[0].scrollHeight);
            }
        };
    });
    
    $('#sendBtn').on('click', function() {
        const messageBox = $('#messageBox');
        const message = messageBox.val();

        if (message.trim() === '' || !conn || conn.readyState !== WebSocket.OPEN) {
            return; 
        }

        const data = {
            type: 'message',
            roomId: currentRoomId,
            userId: currentUserId,
            user: currentUsername,
            message: message
        };

        conn.send(JSON.stringify(data));

        $('.chat-room-item.active').find('.chat-message-preview').text('You: ' + message);

        messagesDiv.append(`
            <div class="message-wrapper message-sent">
                <div class="message-bubble">
                    <strong>You:</strong><br>
                    ${message}
                </div>
            </div>
        `);
        messagesDiv.scrollTop(messagesDiv[0].scrollHeight);
        messageBox.val('');
    });

    $('#messageBox').on('keyup', function(e) {
        if (e.key === 'Enter') {
            $('#sendBtn').click();
        }
    });

    $(document).on('click', '#back-to-chat-list-btn', function() {
    $('#chat-window-container').hide();
    $('#chat-list-container').show();

    if (conn) {
        conn.close();
    }
    currentRoomId = null; 
});
    
});

