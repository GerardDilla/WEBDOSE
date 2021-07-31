<script src="https://unpkg.com/@feathersjs/client@^4.3.0/dist/feathers.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script>
    // const socket = io('https://stdominiccollege.edu.ph:4003'); 
    const socket = io('http://10.0.0.81:4004');

    const app = feathers();
    async function getNotifications(){
        const chat_notification = await app.service('chat-notification').find();
        console.log(chat_notification)
        $('#notification-div').empty();
        var chat_html = '';
        chat_notification.forEach((item)=>{
            var text = item.last_message;
            var count = 50;
            var result = text.slice(0, count) + (text.length > count ? "..." : "");

            chat_html += `
            <a href="#" class="notification-info">
                <div class="notification-student-name">${item.full_name}</div><div class="notification-student-message">${result}</div><span class="notification-time">5 hrs ago</span>
            </a>
            `;
        })
        $('#notification-div').append(chat_html)
    }
    app.configure(feathers.socketio(socket));
    app.service('chat-inquiry').on('created', function(){
        // $('#notification-div').empty();
        getNotifications();

    });
    getNotifications();
</script>