<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daily Report</h3>
                    </div>

                    <div class="card-body">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered table-hover text-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Creation Date</th>
                                        <th>Ticket Status</th>
                                        <th>Ticket Value</th>
                                        <th>Payment Method</th>
                                        <th>Paid Up</th>
                                        <th>Residual</th>
                                        <th>Client Name</th>
                                        <th>car Number</th>
                                        <th>Employee Name</th>
                                    </tr>
                                </thead>
                            <!--<tbody>
                                <tr v-for="role in roles.data" :key="role.id">
                                    <td>{{ role.id }}</td>
                                    <td>{{ role.name }}</td>
                                    <td>{{ role.name_ar }}</td>
                                    <td>
                                        <a href="#" @click="editRole(role)">
                                            <i class="fa fa-edit red"></i>
                                        </a>&nbsp;/
                                        <a href="#" @click="deleteRole(role.id)">
                                            <i class="fa fa-trash red"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>-->
                           </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
