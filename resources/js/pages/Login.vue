<template>

    <div class=" d-flex justify-content-center">

   

    <div class="authentication-wrapper authentication-basic container-p-y col-md-4">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="index.html" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">

</span>
         
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">ສະບາຍດີ! 👋</h4>
          <p class="mb-4">ຍິນດີຕ້ອນຮັບ, ກະລຸນາເຂົ້າສູ່ລະບົບ</p>

            <div class="mb-3">
              <label for="email" class="form-label">ອີເມວລ໌:</label>
              <input type="text" class="form-control" id="email" v-model="email" name="email-username" placeholder="........" autofocus="">
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ລະຫັດຜ່ານ:</label>
                
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" v-model="password" name="password" placeholder="········" aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="alert alert-warning" role="alert" v-if="show_error" >
          {{ text_error }}
        </div>
          
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" :disabled="check_bt" @click="Login()">ເຂົ້າສູ່ລະບົບ</button>
            </div>
        

          <p class="text-center">
            <span>ບໍ່ມີບັນຊີຜູ້ໃຊ້? </span>
            <router-link to="/register">
              <span>ລົງທະບຽນ</span>
            </router-link>
          </p>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
</div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'Minipos12Login',

    data() {
        return {
            email:'',
            password:'',
            show_error: false,
            text_error:''
        };
    },

    computed:{
      check_bt(){
        if(this.email == '' || this.password == '' || this.password.length<4 ){
          return true;
        } else {
          return false;
        }
      }
    },

    mounted() {
        
    },

    methods: {
        Login(){
            if(this.email !='' || this.password !=''){

              axios.post('api/login',{
                    login_email: this.email,
                    login_password: this.password
                  }).then((res)=>{
                  
                      if(res.data.success){

                        this.show_error = false;
                        this.text_error = '';
                        this.email = '';
                        this.password = '';

                        localStorage.setItem('web_token',res.data.token);
                        localStorage.setItem('web_user',JSON.stringify(res.data.user));

                        this.$router.push('/');


                      } else {
                        this.show_error = true;
                        this.text_error = res.data.message;
                      }

                  }).catch((err)=>{
                    console.log(err);
                  });

            }
        }
    },
};
</script>

<style lang="scss" scoped>

</style>