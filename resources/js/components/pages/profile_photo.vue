<template>
  <div class="card vue-avatar-cropper-demo text-center">
    <div class="card-body">      
      <img :src="avatarImage" class="card-img avatar" />
      <div class="card-img-overlay">
        <button class="btn btn-primary btn-sm" id="pick-avatar"><Icon type="ios-cloud-upload"/></button>
      </div> 
      </div>
    <div class="card-footer text-muted" v-html="message"></div>
    <avatar-cropper
        @uploading="handleUploading"
        @completed="handleCompleted"        
        trigger="#pick-avatar"
        :upload-headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
        :cropper-options="{          
          aspectRatio: 1,
          autoCropArea: 1,
          viewMode: 1,
          movable: false,
          zoomable: true
        }"
        :withCredentials="true"
        :labels="{'cancel' : 'cancel', 'submit' : 'Ok'}"
        upload-url="/file/upload" />
        
        <!-- @uploaded="handleUploaded" -->
  </div>
</template>

<script>
import AvatarCropper from "vue-avatar-cropper";

export default {
  components: { AvatarCropper },  
  data() {
    return {
      message: this.$store.state.user.name ,
      token:'',
      avatarImage:this.$store.state.user.profile_image 
    };
  },
  methods: {
    handleUploading(form, xhr) {
      this.message = "uploading...";
    },
    handleCompleted(response, form, xhr) {     
      if(xhr.status == 200){
        this.s('Profile Picture updated')
        this.$store.commit('setUpdateUserProfile', response)
        this.avatarImage=response      
        this.message = this.$store.state.user.name
      }else{
        this.message = "Error Occured! Try Again"
      }
    },   
  }, 
  created(){
    this.token = window.Laravel.csrfToken;          
  },
};
</script>

<style scoped>
.vue-avatar-cropper-demo {
  max-width: 18em;
  margin: 0 auto;
}
.avatar {
  width: 160px;
  border-radius: 6px;
  display: block;
  margin: 20px auto;
}
.card-img-overlay {
  display: none;
  transition: all 0.5s;
}
.card-img-overlay button {
  margin-top: 20vh;
}
.card:hover .card-img-overlay {
  display: block;
}
</style>
