<style scoped>
    button{
        color:white;
    }
</style>
<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">{{ $t('48') }}</h3>
                        <div class="card-tools">
                            <router-link :to="{ path: '/emp_infos_create'}" class="btn btn-success">
                                <i class="fas fa-user-plus fa-fw"></i>&nbsp;{{ $t('49') }}
                            </router-link>
                        </div>
                    </div>
                        <div class="card-body">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-bordered table-hover text-center">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ $t('109') }}</th>
                                    <th>{{ $t('229') }}</th>
                                    <th>{{ $t('16') }}</th>
                                    <th>{{ $t('253') }}</th>
                                    <th>{{ $t('38') }}</th>
                                    <th>{{ $t('18') }}</th>
                                    <th>{{ $t('36') }}</th>
                                    <th>{{ $t('110') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="employee in employees.data" :key="employee.id">
                                    <td>{{ employee.id }}</td>
                                    <td>{{ employee.name_en }}</td>
                                    <td>{{ employee.email }}</td>
                                    <td>{{ employee.salary }}</td>
                                    <td>{{ employee.join_date }}</td>
                                    <td v-if="employee.status==2"><span class="badge badge-danger">Stopped</span></td>
                                    <td v-if="employee.status==1"><span class="badge badge-success">Active</span></td>
                                    <td>{{ employee.dep_name }}</td>
                                    <td>
                                        <router-link :to="{ path: '/emp_infos_create?employee='+employee.id}">
                                            <i class="fa fa-edit blue"></i>
                                        </router-link>&nbsp;&nbsp;/
                                        <router-link :to="{ path: '/show_employee?employee='+employee.id}">
                                            <i class="fa fa-eye" style="color:green;"></i>
                                        </router-link>&nbsp;&nbsp;/
                                        <a href="#" @click="deleteEmployee(employee.id)">
                                            <i class="fa fa-trash" style="color:red;"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
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
    data: function() {
        return {
            employees:{},
        }
    },
    methods: {
        loadUsers: function() {
            axios.get("api/manage_emp").then((res) => {
                this.employees=res.data
            });
        },

        deleteEmployee(id){
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    axios.get('api/manage_emp_delete/'+id).then(()=>{
                        swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    }).catch(()=> {
                        swal.fire("Failed!", "There was something wronge.", "warning");
                    });
                }
            })
        },
    },

    created() {
        this.loadUsers();
        Fire.$on('AfterCreate',() => {
            this.loadUsers();
        });
    },
}
</script>
