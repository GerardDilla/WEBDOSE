<script src="https://unpkg.com/@feathersjs/client@^4.3.0/dist/feathers.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timeago.js/2.0.2/timeago.min.js" integrity="sha512-sl01o/gVwybF1FNzqO4NDRDNPJDupfN0o2+tMm4K2/nr35FjGlxlvXZ6kK6faa9zhXbnfLIXioHnExuwJdlTMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // const socket = io('https://stdominiccollege.edu.ph:4003');
    // const socket = io('http://10.0.0.81:4004');
    const socket = io('http://localhost:4004');
    const app = feathers();
    async function getNotifications(){
        const chat_notification = await app.service('chat-notification').find();
        console.log(chat_notification)
        if(chat_notification.notif_number>0){
            $('.notification-number').text(chat_notification.notif_number);
            $('.notification-number').css('display','inherit')
        }
        else{
            $('.notification-number').css('display','none')
        }
        $('#notification-div').empty();
        var chat_html = '';
        chat_notification.notif.forEach((item)=>{
            var text = item.last_message;
            var count = 50;
            // var result = text.slice(0, count) + (text.length > count ? "..." : "");
            // chat_html += `
            // <a href="#" class="notification-info">
            //     <div class="notification-student-name">${item.full_name}</div><div class="notification-student-message">${result}</div><span class="notification-time">5 hrs ago</span>
            // </a>
            // `;
            chat_html += `
                <a href="<?= base_url('index.php/StudentInquiry') ?>" class="notification-info">
                    <div class="notification-student-name">${item.full_name}</div><div class="notification-student-message">has <b>${item.total_unseen}</b> unread messages</div><span class="notification-time">${moment(Date.parse(item.last_notification_date)).format('LT')}</span>
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
    app.service('chat-inquiry').on('updated', function(){
        getNotifications();
    });
    getNotifications();
</script>