<div class="title m-b-md">
    @{{ count }}
</div>

<div class="links">
    <a href="" v-for="user in users">@{{ user.email }}</a>
</div>

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
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
