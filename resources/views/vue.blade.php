<div class="content" id="app">
    <div class="title m-b-md">
        @{{ count }}
    </div>

    <div class="links">
        <a href="" v-for="user in users">@{{ user.email }}</a>
    </div>
</div>

@push('script')
    <script src="{{ asset('js/vue/vue.js') }}"></script>
    <script>
        var app = new Vue({
            el: '#app',
            mode: 'production',
            data: {
                count: '',
                users: [],
            },
            mounted() {
                this.loadData();
                this.socket();
            },
            methods: {
                loadData() {
                    axios.get('users')
                    .then((json) => {
                        this.count = json.data.count;
                        this.users = json.data.users;
                    })
                },
                socket() {
                  let self = this;
                  // name of channel include {app_name_database_channel_name}
                  Echo.channel('realtime_database_User')
                  .listen('.refresh.users', function (json) {
                    if(json.refresh) {
                      self.loadData();
                    }
                  });
                },
            }
        });
    </script>
@endpush
