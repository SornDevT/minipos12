<template>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-2">
                <div class="card-body">
                    <input type="text" class=" form-control" v-model="Search" placeholder="ຄົ້ນຫາ...." @keyup.enter="GetStore()">
                </div>
            </div>
            <div class="row" style=" overflow: auto; height: 68vh; ">
                <div class="col-md-3 cursor-pointer" v-for="list in StoreData.data" :key="list.id">
                    <div class="card mb-3" @click="AddProduct(list.id)">
                        <span v-for="item in ListOrder" :key="item.imdex">
                            <span class="num-list"  v-if="list.id == item.id" >{{ item.order_amount }}</span>
                        </span>
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
            <div class="card" style=" overflow: auto; height: 79vh; ">
                <div class="card-body">
                    <label for="">ຊື່ລູກຄ້າ:</label>
                    <input type="text" name="" v-model="customer_name" class=" form-control mb-2" placeholder="ຊື່ລູກຄ້າ..." id="">
                    <label for="">ເບີໂທ:</label>
                    <input type="text" name="" v-model="customer_tel" class=" form-control mb-2" placeholder="ເບີໂທ..." id="">
                    <hr>
                    <div class=" d-flex justify-content-between fs-4 fw-bold text-info">
                        <span>ລວມຍອດເງິນ:</span>
                        <span>{{ formatPrice(TotalAmount) }} ກີບ</span>
                    </div>
                    <button class=" btn btn-info w-100 fs-5 fw-bold" :disabled="!TotalAmount" @click="Pay()"> ຊຳລະເງິນ </button>
        
        <table class="table table-bordered mt-2">
        <thead>
          <tr>
            <th>ລາຍການ</th>
            <th>ລາຄາ</th>
            <th>ຍອດລວມ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in ListOrder" :key="item.index">
            <td>{{ item.name }}</td>
            <td class=" text-end">{{ formatPrice(item.price_sell) }} <br>
                <i class='bx bxs-no-entry text-warning cursor-pointer' @click="RemoveProduct(item.id)"></i>  {{ formatPrice(item.order_amount) }} <i class='bx bxs-plus-circle text-success cursor-pointer' @click="AddProduct(item.id)"></i> | <i class='bx bxs-x-circle text-danger cursor-pointer' @click="DeleteProduct(item.id)"></i>
            </td>
            <td class=" text-end">{{ formatPrice(item.order_amount * item.price_sell) }}</td>
          </tr>
        </tbody>
      </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dialog_pay" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">ການຊຳລ່ະເງິນ</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class=" d-flex justify-content-between">
                    <span>ລວມຍອດເງິນ:</span>
                    <span>{{ formatPrice(TotalAmount) }} ກີບ</span>
                  </div>
                  <div class=" d-flex justify-content-between">
                    <span>ຮັບເງິນນຳລູກຄ້າ:</span>
                    <span>{{ formatPrice(CashAmount) }} ກີບ</span>
                  </div>
                  <div class=" d-flex justify-content-between text-danger" v-if="CashAmount-TotalAmount>0">
                    <span>ເງິນທອນ:</span>
                    <span>{{ formatPrice(CashAmount-TotalAmount)}} ກີບ</span>
                  </div>

                  <div class=" d-flex justify-content-center">

            <div class="row" style=" width: 250px; ">
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(1)" >1</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(2)" >2</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(3)" >3</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(4)" >4</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(5)" >5</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(6)" >6</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(7)" >7</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(8)" >8</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(9)" >9</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum('00')" >00</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(0)" >0</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-danger" style=" width: 60px;" @click="AddNum('-')" ><i class='bx bx-left-arrow-alt'></i></button>
                </div>


            </div>

            </div>
              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="ConfirmPay()" :disabled="!(CashAmount>=TotalAmount)" >ຍືນຍັນຊຳລ່ະ</button>
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ປິດ</button>
                  
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
            ListOrder:[],
            Sort:'desc',
            PerPage:16,
            Search:'',
            CashAmount:'',
            url: window.location.origin,
            customer_name:'',
            customer_tel:''
        };
    },

    mounted() {
        
    },
    computed:{
        TotalAmount(){
            let calcalate = this.ListOrder.reduce((num,item)=> parseInt(num) + (parseInt(item.price_sell) * parseInt(item.order_amount)),0);
            return calcalate;
        }
    },
    methods: {
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        Pay(){
            $("#dialog_pay").modal("show");
        },
        ConfirmPay(){

            axios.post('api/transection/add', {
                    customer_name: this.customer_name,
                    customer_tel: this.customer_tel,
                    listorder: this.ListOrder,
                    acc_type: 'income'
            },{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{
        
                    if(res.data.success){
                        this.customer_name = "";
                        this.customer_tel = "";
                        this.ListOrder = [];
                        this.CashAmount = "";
                        $("#dialog_pay").modal("hide");
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
                })
        },
        AddNum(num){
            if(num == '-'){ 
                this.CashAmount = this.CashAmount.slice(0,-1); // 120 = 12 = 1
            } else {  
                this.CashAmount = this.CashAmount + num; // 1 + 2 = 12
            }
        },
        AddProduct(id){
            // console.log(id);
            let item = this.StoreData.data.find((i)=>i.id == id);
            if(item.amount>0){
                    let list_order_item = this.ListOrder.find((i)=>i.id == id);
                    if(list_order_item){

                        list_order_item.order_amount++;

                    } else {
                        this.ListOrder.push({
                            id: item.id,
                            name: item.name,
                            order_amount: 1,
                            price_sell: item.price_sell
                        });
                    }
            } else {

            }
            
        },
        RemoveProduct(id){
                let list_order = this.ListOrder.find((i)=>i.id == id);
                if(list_order){
                    list_order.order_amount--;
                    if(list_order.order_amount<1){
                        this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1);
                    }
                }
        },
        DeleteProduct(id){
            this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1);
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