<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createClient'}" class="btn btn-success">Create new client</router-link>
        </div>
 
        <div class="panel panel-default">
            <div class="panel-heading">Client list</div>
            <div class="panel-body">
                <validation-errors :errors="errors" v-if="errors"></validation-errors>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th width="100">&nbsp;</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="client, index in clients.data">
                        <td><img :src="'/storage/avatars/'+client.avatar" width="100" height="100"></td>
                        <td>{{ client.first_name }}</td>
                        <td>{{ client.last_name }}</td>
                        <td>{{ client.email }}</td>
                        <td>
                             <router-link :to="{name: 'transactionsIndex', params: {id: client.id}}" class="btn btn-xs btn-default">
                                View</br> Transactions
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="{name: 'editClient', params: {id: client.id}}" class="btn btn-xs btn-default">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteEntry(client.id, index)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <pagination :data="clients" @pagination-change-page="getClients"></pagination>
            </div>
        </div>
    </div>
</template>
 
<script>
    import ValidationErrors from '../validationErrors';
    export default {
        data: function () {
            return {
                clients: {},
                errors:''
            }
        },
        mounted() {
            this.getClients();
        },
        components:{
            'ValidationErrors':ValidationErrors
        },
        methods: {
            getClients(page){
                var app = this;
                if(typeof page === 'undifined'){
                    page = 1;
                }
                axios.get('/api/clients?page='+page)
                .then(function (resp) {
                    app.clients = resp.data;
                })
                .catch(function (resp) {
                    alert("Couldn't fetch clients");
                });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/clients/' + id)
                        .then(function (resp) {
                            app.clients.data.splice(index,1);
                        })
                        .catch(function (error) {
                            console.log(error);
                            if(error.response.status==404){
                                app.errors = [error.response.data];
                                alert("Client not found");
                            }
                            alert("Could not delete client");

                        });
                }
            }
        }
    }
</script>