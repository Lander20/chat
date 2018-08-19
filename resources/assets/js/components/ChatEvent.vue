<template>
    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
        <div class="col-xs-12 messages">
            <div class="message" v-for="message in messages">
                <div>
                    <header>{{ message.user.name }} :</header>
                    <p>{{ message.message }}</p>
                    <img v-if="message.file && message.type == 'image' " :src="message.file" />
                    <video controls v-if="message.file && message.type == 'video' " :src="message.file" />
                </div>
            </div>
        </div>
        <div class="btn-sent col-xs-12 col-sm-6">
            <input class="col-xs-7 height-50" v-model="text">

            <input type="file" id="file" ref="file" class="col-xs-3 height-50 btn btn-success" v-on:change="handleFileUpload()" accept="image/*, video/*" style="line-height: 2.6;">
            <button class="col-xs-2 height-50 btn btn-primary" @click="sent" :disabled="!validateMessage">Enviar</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                text: '',
                file: '',
                messages: []
            }
        },
        computed: {
            validateMessage() {
                return this.text.length > 0 || this.file != '';
            }
        },
        mounted() {
            axios.get('/message').then(({data}) => {
                this.messages = data;
            });

            Echo.private('private-chat').listen('MessageSent', (message) => {
                this.text = '';
                this.file = '';
                this.messages.push({
                    message: message.message.message,
                    user: message.user,
                    file: message.message.file,
                    type: message.message.type,
                });
            });
        },
        methods: {
            sent() {
                let formData = new FormData();
                formData.append('file', this.file);
                formData.append('type', this.file ? this.file.type.split('/')[0] : '');
                formData.append('message', this.text);

                axios.post('/message',formData,
                    {headers: { 'Content-Type': 'multipart/form-data'}}
                );
            },
            handleFileUpload(){
                this.file = this.$refs.file.files[0];
            }
        }
    }
</script>

<style>
    .message{
        border-bottom: 1px solid;
        margin-bottom: 10px;
    }
    .message div{
        margin-left: 10px;
    }
    .message header{
        font-weight: bold;
    }
    .message p{
        margin-left: 1%;
    }
    .message img{
        width: 100%;
        margin-bottom: 10px;
    }
    .message video{
        width: 100%;
    }


    .btn-sent{
        position: fixed;
        bottom: 2px;
    }

    .messages{
        margin-bottom: 60px;
        background-color: white;
        margin-left: 14px;
        padding-top: 10px;
    }

    .height-50{
        height: 50px;
    }
</style>