<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>
        <div class="form-group">
           <img :src="client.avatar" width="100" height="100">
           <h3>{{client.first_name}}  {{client.last_name}}</h3>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Transactions</div>
            <div class="panel-body">
                <validation-errors :errors="errors" v-if="errors"></validation-errors>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Transaction Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="transaction, index in transactions.data">
                        <td>{{ transaction.amount }}</td>
                        <td>{{ transaction.transaction_date }}</td>
                    </tr>
                    </tbody>
                </table>
                <pagination :data="transactions" @pagination-change-page="getTransactions"></pagination>
            </div>
        </div>
    </div>
</template>
 
<script>
    import ValidationErrors from '../validationErrors';
    export default {
        data: function () {
            return {
                transactions: {},
                client:{},
                errors:''
            }
        },
        mounted() {
            this.getTransactions();
            this.getClient();
        },
        components:{
            'ValidationErrors':ValidationErrors
        },
        methods: {
            getTransactions(page){
                var app = this;
                let id = app.$route.params.id;
                if(typeof page === 'undifined'){
                    page = 1;
                }
                axios.get('/api/clients/'+id+'/transactions?page='+page)
                .then(function (resp) {
                    app.transactions = resp.data;
                })
                .catch(function (error) {
                    if(error.response.status==404){
                        app.errors = [error.response.data];
                    }
                });
            },
            getClient(){
                let app = this;
                let id = app.$route.params.id;

                axios.get('/api/clients/' + id)
                .then(function (resp) {
                    app.client = resp.data;
                    app.client.avatar = '/storage/avatars/'+resp.data.avatar;
                })
                .catch(function () {
                    alert("Could not load client")
                });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/clients/' + id)
                        .then(function (resp) {
                            app.transactions.data.splice(index,1);
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