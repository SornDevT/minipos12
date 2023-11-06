<template>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-2">
                <div class="card-body">
                    <input type="text" class=" form-control" v-model="Search" placeholder="ຄົ້ນຫາ...." @keyup.enter="GetStore()">
                </div>
            </div>
            <div class="row" style=" overflow: auto; height: 68vh; ">
                <div class="col-md-3" v-for="list in StoreData.data" :key="list.id">
                    <div class="card mb-3">
                        <span class="num-list">1</span>
                    <img class="card-img-top img-pos" v-if="list.image" :src="url + '/assets/img/' + list.image" >
                    <img class="card-img-top img-pos" v-else :src="url + '/assets/img/img.jpg'" >
                    <div class="card-body p-1 text-center">
                        {{list.name}}
                        <p class="card-text">
                        {{ formatPrice(list.price_sell)}} ກີບ
                        </p>
                    </div>
                    </div>
                </div>
              
       
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <label for="">ຊື່ລູກຄ້າ:</label>
                    <input type="text" name="" class=" form-control mb-2" placeholder="ຊື່ລູກຄ້າ..." id="">
                    <label for="">ເບີໂທ:</label>
                    <input type="text" name="" class=" form-control mb-2" placeholder="ເບີໂທ..." id="">
                    <hr>
                    <div class=" d-flex justify-content-between fs-4 fw-bold text-info">
                        <span>ລວມຍອດເງິນ:</span>
                        <span>150.000 ກີບ</span>
                    </div>
                    <button class=" btn btn-info w-100 fs-5 fw-bold"> ຊຳລະເງິນ </button>
        
        <table class="table table-bordered mt-2">
        <thead>
          <tr>
            <th>ລາຍການ</th>
            <th>ລາຄາ</th>
            <th>ຍອດລວມ</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>a</td>
            <td>b</td>
            <td>c</td>
          </tr>
        </tbody>
      </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useStore } from '../store/auth';
export default {
    name: 'Minipos12Pos',
    setup(){
        const store = useStore();
        return {store};
    },
    data() {
        return {
            StoreData:[],
            Sort:'desc',
            PerPage:16,
            Search:'',
            url: window.location.origin
        };
    },

    mounted() {
        
    },

    methods: {
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        GetStore(page){
            this.table_loading = true;
            axios.get(`api/store_pos?page=${page}&sort=${this.Sort}&perpage=${this.PerPage}&search=${this.Search}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{
                
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

<style scoped>
    .img-pos{
        width: 100%;
        height: 120px;
        object-fit: cover;
        object-position: center;
    }
    .num-list{
        position: absolute;
    right: 0px;
    padding: 5px;
    background-color: blue;
    color: white;
    border-radius: 0px 8px 0px 8px;
    }
</style>