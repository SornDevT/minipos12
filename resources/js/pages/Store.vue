<template>
    <div class="card">
  <h5 class="card-header">ລາຍການ ສະຕ໋ອກສິນຄ້າ</h5>
  <div class="card-body">

    <div v-if="ShowForm">
        <div class=" d-flex justify-content-end">
            <button type="button" class="btn btn-success me-2" :disabled="CheckForm"><i class='bx bxs-save fs-4 me-2'></i> ບັນທຶກ</button>
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
                <div class="d-flex align-items-center me-2">
                    <i class='bx bx-sort-up fs-4'></i>
                </div>
                <select class="form-select">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>
            <div class=" d-flex">
                <input type="text" class=" form-control me-2" placeholder="ຄົ້ນຫາຂໍ້ມູນ...">
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
          <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</template>

<script>
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
        SaveStore(){
            if(this.FormType){
                // ເພີ່ມຂໍ້ມູນ
            } else {
                // ອັບເດດຂໍ້ມູນ
            }
        }
    },
};
</script>

<style lang="scss" scoped>

</style>