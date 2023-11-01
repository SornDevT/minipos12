<template>
    <div class="card">
  <h5 class="card-header">ລາຍການ ສະຕ໋ອກສິນຄ້າ</h5>
  <div class="card-body">

    <div v-if="ShowForm">
        <div class=" d-flex justify-content-end">
            <button type="button" class="btn btn-success me-2" :disabled="CheckForm" @click="SaveStore()" ><i class='bx bxs-save fs-4 me-2'></i> ບັນທຶກ</button>
            <button type="button" class="btn btn-warning" @click="CancelStore()"><i class='bx bxs-x-circle fs-4 me-2'></i> ຍົກເລີກ</button>
        </div>
        <div class="row">
            <div class=" col-md-4">image</div>
            <div class=" col-md-8">

                {{ FormStore }}
                <hr>
    
            <label  class="form-label fs-6">ຊື່ສິນຄ້າ: <span class=" text-danger">*</span> </label>
            <input type="text" class="form-control mb-2"  placeholder="....." v-model="FormStore.name" >

            <label  class="form-label fs-6">ຈຳນວນ: <span class=" text-danger">*</span></label>
            <input type="text" class="form-control mb-2"  placeholder="....." v-model="FormStore.amount" >
                
                <div class="row">
                    <div class="col-md-6">
            
          

                        <label  class="form-label fs-6">ລາຄາຊື້: <span class=" text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control"  placeholder="....." v-model="FormStore.price_buy">
                            <span  class="input-group-text ">ກີບ</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label  class="form-label fs-6">ລາຄາຂາຍ: <span class=" text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control"  placeholder="....." v-model="FormStore.price_sell">
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
            <th>ID</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th>ລາຄາຊື້</th>
            <th>ຈຳນວນ</th>
            <th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in StoreData.data" :key="list.id">
            <td>{{ list.id }}</td>
            <td>{{ list.name }}</td>
            <td>{{ list.price_buy }}</td>
            <td>{{ list.amount }}</td>
            <td>
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
    </div>
  </div>
</div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Minipos12Store',

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
        };
    },

    computed:{
        CheckForm(){
            if(this.FormStore.name == '' || this.FormStore.amount == '' || this.FormStore.price_buy == '' || this.FormStore.price_sell == ''){
                return true;
            } else {
                return false;
            }
        }
    },

    mounted() {
        
    },

    methods: {
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
                axios.get(`api/store/edit/${id}`).then((res)=>{
                    
                    this.FormStore = res.data;
                    this.ShowForm = true;

                }).catch((error)=>{
                    console.log(error);
                })

        },
        DeleteStore(id){

            axios.delete(`api/store/delete/${id}`).then((res)=>{
                    // console.log(res);
                    if(res.data.success){

                        this.GetStore();
                    } else {

                    }

                }).catch((error)=>{
                    console.log(error);
                })

        },
        SaveStore(){
            if(this.FormType){
                // ເພີ່ມຂໍ້ມູນ

                axios.post('api/store/add', this.FormStore).then((res)=>{
                    // console.log(res);
                    if(res.data.success){
                        this.ShowForm = false;
                        this.GetStore();
                    } else {

                    }

                }).catch((error)=>{
                    console.log(error);
                })

            } else {
                // ອັບເດດຂໍ້ມູນ

                axios.post(`api/store/update/${this.EditId}`, this.FormStore).then((res)=>{
                    // console.log(res);
                    if(res.data.success){
                        this.ShowForm = false;
                        this.GetStore();
                    } else {

                    }

                }).catch((error)=>{
                    console.log(error);
                })

            }
        },
        GetStore(page){

            axios.get(`api/store?page=${page}&sort=${this.Sort}&perpage=${this.PerPage}&search=${this.Search}`).then((res)=>{
                
                this.StoreData = res.data;

                }).catch((error)=>{
                    console.log(error);
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