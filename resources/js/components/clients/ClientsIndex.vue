<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createClient'}" class="btn btn-success">Create new client</router-link>
        </div>
 
        <div class="panel panel-default">
            <div class="panel-heading">Client list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="client, index in clients">
                        <td><img src=""></td>
                        <td>{{ client.name }}</td>
                        <td>{{ client.address }}</td>
                        <td>{{ client.email }}</td>
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
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data: function () {
            return {
                clients: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/clients')
                .then(function (resp) {
                    app.clients = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load clients");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/v1/clients/' + id)
                        .then(function (resp) {
                            app.clients.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete client");
                        });
                }
            }
        }
    }
</script>