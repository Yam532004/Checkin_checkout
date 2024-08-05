window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
});

// document.addEventListener('DOMContentLoaded', function() {
//     var userId = @json(Auth::id());

//     window.Echo.private(`user.deleted.${userId}`)
//         .listen('UserDeleted', (event) => {
//             toastr.warning('Your account has been deleted. Please log in again', 'Account Deleted');
//             setTimeout(() => {
//                 window.location.href = "http://127.0.0.1:8000/login";
//             }, 2000);
//         });
// });



