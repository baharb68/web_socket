<template>
    <div v-if="users.length > 0">
        <div class="d-flex align-items-start border-right">
            <div class="nav flex-column nav-pills me-3 bg-white border rounded px-3 py-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <div class="font-weight-bold border-bottom pb-1 mb-2 text-secondary" style="white-space: nowrap">chat with</div>
                <button v-for="user in users" @click="getMessages(user.id)" class="nav-link show-messages"  :id="`v-pills-${user.id}-tab`" data-bs-toggle="pill" :data-bs-target="`#v-pills-${user.id}`" type="button" role="tab" :aria-controls="`v-pills-${user.id}`" aria-selected="false">{{user.name}}</button>
            </div>
            <div class="tab-content w-100" id="v-pills-tabContent">
                <div  v-for="user in users" class="tab-pane fade bg-white border rounded w-100 p-2" :id="`v-pills-${user.id}`" role="tabpanel" :aria-labelledby="`v-pills-${user.id}-tab`">
                    <div v-if="messages.length">
                        <div v-for="item in messages">
                                <div v-if="current_user.id == item.user_id" class="mr-auto w-50 p-2 rounded mb-1" style="background-color:#b9ffc5">{{item.message}}</div>
                                <div v-else class="ms-auto w-50 p-2 rounded bg-light mb-1">{{item.message}}</div>
                            </div>
                        </div>
                    <div v-else class="text-secondary"><p>no messages.</p></div>
                </div>
            </div>
        </div>
        <div class="d-flex mt-4" v-if="listener">
            <div class="col-md-10 me-1">
                <textarea class="form-control" v-model="message" rows="1"></textarea>
            </div>
            <button class="col btn btn-success btn-sm" @click.prevent="postMessages">send</button>
        </div>
     </div>
    <div v-else>
        <h3 class="text-center text-secondary">No user is registered for chatting.</h3>
        <p class="text-center">Please register more than one user. Then you can chat with others.</p>
    </div>
</template>

<script>
    export default {
        props: ['users', 'current_user'],
        data(){
            return {
                messages: {},
                message: "",
                listener: '',
            }
        },
        mounted() {
            this.listen();
        },
        methods: {
            getMessages(id){
                this.messages = [];
                this.listener = id;
                axios.get(`/api/messages/${this.listener}?user_id=${this.current_user.id}`)
                    .then((response) => {
                        this.messages = response.data
                        console.log(this.messages);
                    })
                    .catch(function(error){
                        console.log(error);
                    })
            },
            postMessages(){
                axios.post(`/api/messages/${this.listener}`,{
                    message:this.message,
                    user_id:this.current_user.id,
                })
                    .then((response) => {
                        //this.messages = response.data;
                        this.message = ""
                    })
                    .catch(function(error){
                        console.log(error);
                    })
            },
            listen(){
                Echo.private(`message.${this.current_user.id}`)
                .listen('NewMessage', (message) => {
                    this.messages.push(message.message);
                })
            }
        }
    }
</script>
