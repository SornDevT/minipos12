<template>
    <div class="card">
  <h5 class="card-header">ລາຍການ ສະຕ໋ອກສິນຄ້າ</h5>
  <div class="card-body">

    <div v-if="ShowForm">
        <div class=" d-flex justify-content-end mb-2">
            <button type="button" class="btn btn-success me-2" :disabled="CheckForm" @click="SaveStore()" >
                <span v-if="post_loading"> 
                    <div class="spinner-border spinner-border-sm " role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    ກຳລັງບັນທຶກ...    
                </span>
                <span v-else> <i class='bx bxs-save fs-4 me-2'></i> ບັນທຶກ </span>
            
            </button>
            <button type="button" class="btn btn-warning" @click="CancelStore()"><i class='bx bxs-x-circle fs-4 me-2'></i> ຍົກເລີກ</button>
        </div>
        <div class="row">
            <div class=" col-md-4 text-center" style=" position: relative;">
                <button type="button" class="btn rounded-pill btn-icon btn-danger" @click="Remove_img()" style=" position:absolute; right: 10px;" v-if="FormStore.image">
                    <i class='bx bx-x fs-3'></i>
                </button>

                <img :src="image_pre" @click="$refs.img_store.click()" class=" rounded cursor-pointer" style=" width: 80%;"  alt="">
                <input type="file" ref="img_store" style=" display: none;" @change="onSelect" >
            </div>
            <div class=" col-md-8">

                <!-- {{ FormStore }}
                <hr> -->
    
            <label  class="form-label fs-6">ຊື່ສິນຄ້າ: <span class=" text-danger">*</span> </label>
            <input type="text" class="form-control mb-2"  placeholder="....." v-model="FormStore.name" >

            <label  class="form-label fs-6">ຈຳນວນ: <span class=" text-danger">*</span></label>
            <cleave :options="options" class="form-control mb-2"  placeholder="....." v-model="FormStore.amount" />
                
                <div class="row">
                    <div class="col-md-6">
            
          

                        <label  class="form-label fs-6">ລາຄາຊື້: <span class=" text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <cleave :options="options" class="form-control"  placeholder="....." v-model="FormStore.price_buy" />
                            <span  class="input-group-text ">ກີບ</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label  class="form-label fs-6">ລາຄາຂາຍ: <span class=" text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <cleave :options="options" class="form-control"  placeholder="....." v-model="FormStore.price_sell" />
                            <span  class="input-group-text ">ກີບ</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="table-responsive text-nowrap" v-if="!ShowForm">
        <div class=" d-flex justify-content-between mb-2">
            <div class=" d-flex align-items-center">
                <div class="d-flex align-items-center me-2 cursor-pointer" @click="ChangeSort()">
                    <i class='bx bx-sort-up fs-4' v-if="Sort=='asc'"></i>
                    <i class='bx bx-sort-down fs-4' v-if="Sort=='desc'"></i>
                </div>
                <select class="form-select" v-model="PerPage" @change="GetStore()">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>
            <div class=" d-flex">
                <input type="text" class=" form-control me-2" v-model="Search" placeholder="ຄົ້ນຫາຂໍ້ມູນ..." @keyup.enter="GetStore()">
                <button type="button" class="btn btn-primary" @click="AddStore()"><i class='bx bxs-plus-circle me-2 fs-4'></i> ເພີ່ມຂໍ້ມູນ</button>
            </div>
        </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="60" class="text-center">ID</th>
            <th class="text-center" width="120">ຮູບພາບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th class="text-center" width="80">ຈຳນວນ</th>
            <th class="text-center" width="180">ລາຄາຊື້</th>
            <th class="text-center" width="80">ຈັດການ</th>
          </tr>
        </thead>
        <tbody v-if="table_loading">
            <tr>
                <td colspan="5" class="text-center text-info" >
                    <div class="spinner-border spinner-border-sm text-info" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    ກຳລັງໂຫຼດຂໍ້ມູນ....
                </td>
            </tr>
        </tbody>
        <tbody v-else>
          <tr v-for="list in StoreData.data" :key="list.id">
            <td class="text-center">{{ list.id }}</td>
            <td class="text-center">
                <!-- {{ list.image }} -->
                <img :src="url + '/assets/img/'+list.image" v-if="list.image" alt="" class=" rounded w-100" srcset="">
                <img :src="url + '/assets/img/img.jpg'" v-else alt="" class=" rounded w-100" srcset="">
            </td>
            <td >{{ list.name }}</td>
            <td class="text-center">{{ formatPrice(list.amount) }}</td>
            <td class=" text-end">{{ formatPrice(list.price_buy) }}</td>
            <td class="text-center">
                <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu" style="">
                  <a class="dropdown-item" href="javascript:void(0);" @click="EditStore(list.id)" ><i class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                  <a class="dropdown-item" href="javascript:void(0);" @click="DeleteStore(list.id)" ><i class="bx bx-trash me-1"></i> ລຶບ</a>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
            <Pagination :pagination="StoreData" :offset="4" @paginate="GetStore($event)" />
            <!-- <button @click="showAlert">Hello world</button> -->
    </div>
  </div>
</div>
</template>

<script>
import Cleave from 'vue-cleave-component';
import axios from 'axios';
import { useStore } from '../store/auth';

export default {
    name: 'Minipos12Store',
    setup(){
        const store = useStore();
        return {store};
    },
    data() {
        return {
            ShowForm:false,
            FormStore:{
                name:'',
                image:'',
                amount:'',
                price_buy:'',
                price_sell:'',
            },
            FormType:true,
            StoreData:[],
            Sort:'asc',
            PerPage:5,
            Search:'',
            EditId:'',
            table_loading:false,
            post_loading:false,
            options:{
                //   prefix: '₭ ',
                  numeral: true,
                  numeralPositiveOnly: true,
                  noImmediatePrefix: true,
                  rawValueTrimPrefix: true,
                  numeralIntegerScale: 10,
                  numeralDecimalScale: 2,
                  numeralDecimalMark: ',',
                  delimiter: '.'
            },
            image_pre: window.location.origin + '/assets/img/img.jpg',
            url: window.location.origin
        };
    },
    components:{
        Cleave
    },

    computed:{
        CheckForm(){
            if(this.FormStore.name == '' || this.FormStore.amount == '' || this.FormStore.price_buy == '' || this.FormStore.price_sell == ''){
                return true;
            } else {
                if(this.post_loading){
                    return true
                } else {
                    return false;
                }
                
            }
        }
    },

    mounted() {
        
    },

    methods: {
        showAlert() {
            // Use sweetalert2
            this.$swal({
                // toast:true,
                // position: 'top-end',
                icon: 'error',
                title: 'Your work has been saved',
                text: 'ບັນທຶກບໍ່ສຳເລັດ',
                showConfirmButton: false,
                timer: 3500
                });
        },
        Remove_img(){
            this.FormStore.image = '';
            this.image_pre = window.location.origin + '/assets/img/img.jpg';
        },
        onSelect(event){
            // console.log(event)
            this.FormStore.image = event.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(this.FormStore.image);
            reader.addEventListener("load", function(){
                this.image_pre = reader.result;
            }.bind(this),false);
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        ChangeSort(){
            if(this.Sort == 'asc'){
                this.Sort = 'desc';
            } else {
                this.Sort = 'asc';
            }
            this.GetStore();
        },
        AddStore(){
            this.FormStore.name = '';
            this.FormStore.amount = '';
            this.FormStore.price_buy = '';
            this.FormStore.price_sell = '';
            this.FormStore.image = '';
            this.image_pre = window.location.origin + '/assets/img/img.jpg';
            this.ShowForm = true;
            this.FormType = true;
        },
        CancelStore(){
            this.ShowForm = false;
        },
        EditStore(id){
                // console.log(id)
                this.FormType = false;
                this.EditId = id;
                axios.get(`api/store/edit/${id}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{
                    
                    this.FormStore = res.data;
                    this.ShowForm = true;

                    // ອ່ານ-ສະແດງຮູບພາບ
                    if(res.data.image){
                        this.image_pre = window.location.origin + "/assets/img/" + res.data.image;
                    } else {
                        this.image_pre = window.location.origin + "/assets/img/img.jpg";
                    }

                }).catch((error)=>{
                    console.log(error);
                    if(error){
                        if(error.response.status == 401){
                            this.store.remove_token();
                            this.store.remove_user();
                            localStorage.removeItem('web_token');
                            localStorage.removeItem('web_user');
                            this.$router.push('/login')
                        }
                    }
                })

        },
        DeleteStore(id){

            this.$swal({
                title: 'ທ່ານແນ່ໃຈບໍ່?',
                text: "ທີ່ຈະລຶບຂໍ້ມູນນີ້!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ຍຶນຍັນລຶບ',
                cancelButtonText: 'ຍົກເລີກ'
                }).then((result) => {
                if (result.isConfirmed) {

                        axios.delete(`api/store/delete/${id}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{
                        // console.log(res);
                        if(res.data.success){

                            this.GetStore();

                            this.$swal({
                                toast:true,
                                position: 'top-end',
                                icon: 'success',
                                title: res.data.message,
                                showConfirmButton: false,
                                timer: 2500
                            });

                        } else {
                            this.$swal({
                                icon: 'error',
                                title: 'ບໍ່ສຳເລັດ',
                                text: res.data.message,
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }

                    }).catch((error)=>{
                        console.log(error);
                        if(error){
                        if(error.response.status == 401){
                            this.store.remove_token();
                            this.store.remove_user();
                            localStorage.removeItem('web_token');
                            localStorage.removeItem('web_user');
                            this.$router.push('/login')
                        }
                    }
                    });
                
                }
                });




           

        },
        SaveStore(){

            this.post_loading = true;

            if(this.FormType){
                // ເພີ່ມຂໍ້ມູນ

                axios.post('api/store/add', this.FormStore,{ headers:{ "content-type":"multipart/form-data", Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{
                    // console.log(res);
                    if(res.data.success){
                        this.ShowForm = false;
                        this.GetStore();

                        this.$swal({
                        toast:true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.data.message,
                        showConfirmButton: false,
                        timer: 2500
                        });


                    } else {

                        this.$swal({
                        icon: 'error',
                        title: 'ບໍ່ສຳເລັດ',
                        text: res.data.message,
                        showConfirmButton: false,
                        timer: 3500
                        });

                    }
              
                    this.post_loading = false;

                }).catch((error)=>{
                    console.log(error);
                    this.post_loading = false;
                    if(error){
                        if(error.response.status == 401){
                            this.store.remove_token();
                            this.store.remove_user();
                            localStorage.removeItem('web_token');
                            localStorage.removeItem('web_user');
                            this.$router.push('/login')
                        }
                    }
                })

            } else {
                // ອັບເດດຂໍ້ມູນ

                axios.post(`api/store/update/${this.EditId}`, this.FormStore,{ headers:{ "content-type":"multipart/form-data", Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{
                    // console.log(res);
                    if(res.data.success){
                        this.ShowForm = false;
                        this.GetStore();

                        this.$swal({
                        toast:true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.data.message,
                        showConfirmButton: false,
                        timer: 2500
                        });

                    } else {
                        this.$swal({
                        icon: 'error',
                        title: 'ບໍ່ສຳເລັດ',
                        text: res.data.message,
                        showConfirmButton: false,
                        timer: 3500
                        });
                    }

                    this.post_loading = false;

                }).catch((error)=>{
                    console.log(error);
                    this.post_loading = false;
                    if(error){
                        if(error.response.status == 401){
                            this.store.remove_token();
                            this.store.remove_user();
                            localStorage.removeItem('web_token');
                            localStorage.removeItem('web_user');
                            this.$router.push('/login')
                        }
                    }
                })

            }
        },
        GetStore(page){
            this.table_loading = true;
            axios.get(`api/store?page=${page}&sort=${this.Sort}&perpage=${this.PerPage}&search=${this.Search}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{
                
                this.StoreData = res.data;

                // setTimeout(()=>{
                    this.table_loading = false;
                // },2000)
                

                }).catch((error)=>{
                    console.log(error);
                    this.table_loading = false;
                    if(error){
                        if(error.response.status == 401){
                            this.store.remove_token();
                            this.store.remove_user();
                            localStorage.removeItem('web_token');
                            localStorage.removeItem('web_user');
                            this.$router.push('/login')
                        }
                    }
                })
        }
    },
    created(){
        this.GetStore();
    },
    watch:{
        Search(){
            if(this.Search == ''){
                this.GetStore();
            }
        }
    }
};
</script>

<style lang="scss" scoped>

</style>