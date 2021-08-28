<style>
    button{
        color:white;
    }
    .btn{
        color:white;
    }
    label{
        font-weight: 500;
    }
    section{
        padding: 60px 0;
    }

    #accordion-style-1 h1,#accordion-style-1 a{
        color:#007b5e;
    }

    #accordion-style-1 .btn-link {
        font-weight: 400;
        color:royalblue;
        background-color: transparent;
        text-decoration: none !important;
        font-size: 16px;
        font-weight: bold;
        padding-left: 25px;
    }

    #accordion-style-1 .card-header .btn.collapsed .fa.main{
        display:none;
    }

    #accordion-style-1 .card-header .btn .fa.main{
        background: royalblue;
        padding: 13px 11px;
        color: #ffffff;
        width: 35px;
        height: 41px;
        position: absolute;
        left: -1px;
        top: 10px;
        border-top-right-radius: 7px;
        border-bottom-right-radius: 7px;
        display:block;
    }
</style>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $t('259') }}</h3>
                </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Accordion -->
                                <div class="container-fluid bg-light" id="accordion-style-1">
                                    <div class="row">
                                        <div class="col-12 mx-auto">
                                            <div class="accordion mt-3" id="accordionExample">
                                                <div class="card">
                                                    <div class="card-header" id="headingTwo">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                <i class="fa fa-home main"></i><i class="fa fa-angle-double-right mr-3"></i>{{ $t('44') }}
                                                            </button>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseTwo" class="collapse fade show active" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <div class="text-center mb-3">
                                                                <img class="img-circle img-fluid" :src="`storage/employees/${form.emp_picture}`" width="150px" height="90px">
                                                            </div>
                                                            <ul class="list-group list-group-unbordered mb-3">
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('229') }}</b>
                                                                    <span class="float-right">{{ form.name }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('229') }} English</b>
                                                                    <span class="float-right">{{ form.name_en }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('16') }}</b>
                                                                    <span class="float-right">{{ form.email }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('18') }}</b>
                                                                    <span v-if="form.status==2" class="badge badge-danger float-right">Stopped</span>
                                                                    <span v-if="form.status==1" class="badge badge-success float-right">Active</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('23') }}</b>
                                                                    <span class="float-right">{{ form.role }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('15') }}</b>
                                                                    <span class="float-right">{{ form.notes }}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="card">
                                                    <div class="card-header" id="headingTwo">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                <i class="fa fa-home main"></i><i class="fa fa-angle-double-right mr-3"></i>{{ $t('45') }}
                                                            </button>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseThree" class="collapse fade" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <ul class="list-group list-group-unbordered mb-3">
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('24') }}</b>
                                                                    <span class="float-right">{{ form.date_of_birth }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('25') }}</b>
                                                                    <span v-if="form.gender==1" class="float-right">Male</span>
                                                                    <span v-if="form.gender==2" class="float-right">Female</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('25') }}</b>
                                                                    <span class="float-right">{{ form.country }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('29') }}</b>
                                                                    <span class="float-right">{{ form.mobile_number }}</span>
                                                                </li>
                                                            <div class="div2 mt-2">
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('30') }}</b>
                                                                    <span class="float-right">{{ form.present_address }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('31') }}</b>
                                                                    <span class="float-right">{{ form.present_city }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('32') }}</b>
                                                                    <span class="float-right">{{ form.present_state }}</span>
                                                                </li>
                                                            </div>
                                                            <div class="div2 mt-2">
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('34') }}</b>
                                                                    <span class="float-right">{{ form.perm_address }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('31') }}</b>
                                                                    <span class="float-right">{{ form.perm_city }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('32') }}</b>
                                                                    <span class="float-right">{{ form.perm_state }}</span>
                                                                </li>
                                                            </div>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- .// Accordion -->
                            </div>

                            <div class="col-md-6">
                                <!-- Accordion -->
                                <div class="container-fluid bg-light" id="accordion-style-1">
                                    <div class="row">
                                        <div class="col-12 mx-auto">
                                            <div class="accordion mt-3" id="accordionExample">
                                                <div class="card">
                                                    <div class="card-header" id="headingTwo">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                                <i class="fa fa-home main"></i><i class="fa fa-angle-double-right mr-3"></i>{{ $t('46') }}
                                                            </button>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseFive" class="collapse fade" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <ul class="list-group list-group-unbordered mb-3">
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('35') }}</b>
                                                                    <span class="float-right">{{ form.designation }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('36') }}</b>
                                                                    <span class="float-right">{{ form.department }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('37') }}</b>
                                                                    <span class="float-right">{{ form.emp_level }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('38') }}</b>
                                                                    <span class="float-right">{{ form.join_date }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('39') }}</b>
                                                                    <span class="float-right">{{ form.branch }}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="card">
                                                    <div class="card-header" id="headingTwo">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                                <i class="fa fa-home main"></i><i class="fa fa-angle-double-right mr-3"></i>{{ $t('47') }}
                                                            </button>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseSix" class="collapse fade" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <ul class="list-group list-group-unbordered mb-3">
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('40') }}</b>
                                                                    <span class="float-right">{{ form.attendance_shift }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('41') }} English</b>
                                                                    <span class="float-right">{{ form.leave_policy }}</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>{{ $t('42') }}</b>
                                                                    <span class="float-right">{{ form.holiday_lists }}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- .// Accordion -->
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['employee'],
    data: function(){
        return{
            form: new Form({
                id:'',
                name:'',
                name_en:'',
                first_name:'',
                sir_name:'',
                last_name:'',
                fist_name_en:'',
                sir_name_en:'',
                last_name_en:'',
                emp_picture:'',
                notes:'',
                email:'',
                status:1,
                send_credentials:'',
                allow_access:0,
                language:1,
                role:'',
                date_of_birth:'',
                gender:1,
                country:1,
                mobile_number:'',
                present_address:'',
                present_city:'',
                present_state:'',
                perm_address:'',
                perm_city:'',
                perm_state:'',
                designation:-1,
                department:-1,
                emp_level:-1,
                join_date:'',
                branch:1,
                salary:0,
                attendance_shift:-1,
                leave_policy:-1,
                holiday_lists:-1,
            })
        }
    },

    methods:{

        loadUsers(){
            if(this.form.id!=undefined)
                axios.get('api/manage_emp/'+this.form.id).then((res)=>{
                    this.form.fill(res.data)
                })
        },
    },

    created() {
        this.form.id = this.$route.query.employee;
        this.loadUsers()
    },
}

</script>
