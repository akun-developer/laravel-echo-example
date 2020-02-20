var host = window.location.hostname.replace('www.', '');
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: host + ':6001'
});
