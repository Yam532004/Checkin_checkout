
import Echo from "laravel-echo";
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
});

window.Echo.channel('user-delete')
    .listen('UserDeleted', (e) => {
        if (e.userId === userId) {
            alert('Your account has been deleted. Please log in again.');
            window.location.href = '/logout';
        }
    });
