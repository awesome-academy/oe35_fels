<!-- Handle notification JS -->
<script src="{{ asset('js/notify.js') }}"></script>

<!-- Pusher JS -->
<script>
    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
      cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
    });

    var channel = pusher.subscribe('notify-course');
    channel.bind('new-course-event', function(data) {
        $.reloadNotify();
        console.log(data);
    });
</script>
