<template>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card" id="print">
                <div class="card-header">
                    <h3 class="card-title">{{$t('86')}}</h3>
                    <div class="row card-tools">
                        <div class="col-md-6">
                            <select name="printer" id="printer" v-model="form.printer" class="form-control" @change="submitForm">
                                <option value="1">A4</option>
                                <option value="2">Reset 5.5</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-info" @click="print">
                                <i class="fas fa-print fa-fw"></i>&nbsp; {{$t('212')}}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="filters">{{ $t('134') }}</label>
                            <select name="filters" id="filters" v-model="filter" class="form-control" @change="getResults">
                                <option value="-1">{{ $t('135') }}</option>
                                <option value="1">{{ $t('252') }}</option>
                                <option value="2">{{ $t('246') }}</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{$t('273')}}</label>
                                <input type="text" name="total_tickets" class="form-control" :value="total_tickets" disabled>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{$t('274')}}</label>
                                <input type="text" name="total_servs" class="form-control" :value="servs" disabled>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{$t('275')}}</label>
                                <input type="text" name="total_cost" class="form-control" :value="fin_cost" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-hover text-center">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>{{$t('199')}}</th>
                                    <th>{{$t('276')}}</th>
                                    <th>{{$t('242')}}</th>
                                    <th>{{$t('197')}}</th>
                                    <th>{{$t('277')}}</th>
                                    <th>{{$t('278')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(sale,indx) in sales.data" :key="indx">
                                    <td>{{ sale.id }}</td>
                                    <td>{{ sale.ticket_date }}</td>
                                    <td>{{user}}</td>
                                    <td>{{ sale.totalServices }}</td>
                                    <td>{{ sale.totalSum }}</td>
                                    <td>{{ tot_taxes(sale.totalSum) }}</td>
                                    <td>{{ end_cost(tot_taxes(sale.totalSum),sale.totalSum) }}</td>
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
    data: function () {
        return {
            sales: {},
            user: '',
            endCost: '',
            filter: 1,
            car_ticket: '',
            carpet_ticket: '',
            ticket_id: '',
            total_tickets: 0,
            total_taxes: 0,
            servs: 0,
            tot_cost: 0,
            fin_cost: 0,

            form: new Form({
                printer: 1,
            })
        }
    },
    methods: {
        submitForm(){
            this.form.post('api/sales_reports').then(()=>{
                Fire.$emit('AfterCreateCode_table');
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Machine Selected successfully',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$Progress.finish();
            })
        },
        print() {
            this.$htmlToPaper('print');
        },

        tot_taxes(x) {
            return parseFloat(x / 100 * 15)
        },

        end_cost(x, y) {
            return parseFloat(x) + parseFloat(y)
        },

        get_total_tickets() {
            axios.get('api/get_total_tickets/' + this.filter).then((res) => {
                this.total_tickets = res.data
            })
        },

        get_total_servs() {
            axios.get('api/get_total_servs/' + this.filter).then((res) => {
                this.servs = res.data
            })
        },

        get_total_tickcost() {
            axios.get('api/get_total_fin_cost/' + this.filter).then((res) => {
                this.fin_cost = res.data
            })
        },

        getResults(page = 1) {
            this.sales = {}
            axios.get('api/sales_reports/' + this.filter + '?page=' + page).then((res) => {
                this.sales = res.data;
            });
            this.get_user();
            this.get_total_cost();
            this.get_total_tickets();
            this.get_total_servs();
            this.get_total_tickcost();
        },

        get_user() {
            axios.get('api/get_user').then((res) => {
                this.user = res.data;
            });
        },

        get_total_cost() {
            axios.get('api/get_total_cost/' + this.filter).then((res) => {
                this.endCost = res.data;
            });
        },
    },
    created() {
        this.getResults();
    }
}
</script>
