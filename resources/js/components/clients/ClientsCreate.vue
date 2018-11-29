<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>
 
        <div class="panel panel-default">
            <div class="panel-heading">Create new client</div>
            <div class="panel-body">
                <form @submit="saveForm()" style="margin:15px">

                    <validation-errors :errors="errors" v-if="errors"></validation-errors>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">First Name</label>
                            <input type="text" v-model="client.first_name" class="form-control" required="true">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Last Name</label>
                            <input type="text" v-model="client.last_name" class="form-control" required="true" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Email</label>
                            <input type="email" v-model="client.email" class="form-control" required="true">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Avatar</label>
                            <input type="file" id='avatar' @change="onFileChange" class="form-control" required="true" />
                            <img v-if="client.avatar":src="client.avatar" id="img_avatar" width="100" height="100">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
 
<script>
    import ValidationErrors from '../validationErrors';
    export default {
        data: function () {
            return {
                client: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    avatar: '',
                },
                errors:''
            }
        },
        components:{
            'ValidationErrors':ValidationErrors
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                axios.post('/api/clients', this.client)
                    .then(function (resp) {
                        app.$router.push({path: '/'});
                    })
                    .catch(function (error) {
                        if(error.response.status == 422){
                            app.errors = error.response.data.errors;
                        }else{
                            alert("Could not create the client");
                        }
                    });
            },
            onFileChange(e) {
                let files = e.target.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let app = this;
                //read the contents of the file as data: URL
                reader.readAsDataURL(file);
                let img = new Image;
                //when read operation is finished assign data URL to client.avatar
                reader.onload = (e) => {
                    img.src = e.target.result;
                    //img dimentions validation
                    img.onload = function(){
                        if(img.width<100 || img.height<100){
                            app.errors = ['Avatar must be aleast 100x100'];
                        }else{
                            app.client.avatar = e.target.result;
                        }
                    }
                    
                };

            }
        }
    }
</script>