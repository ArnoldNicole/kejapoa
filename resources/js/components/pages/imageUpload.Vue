<template>
  <div class="card vue-avatar-cropper-demo text-center">
    <div class="card-body">      
      <img :src="avatarImage" class="card-img avatar" />
      <div class="card-img-overlay">
        <button class="btn btn-primary btn-sm" id="pick-avatar">Select an new image</button>
      </div> 
      </div>
    <div class="card-footer text-muted" v-html="message"></div>
    <avatar-cropper
        @uploading="handleUploading"
        @uploaded="handleUploaded"
        @completed="handleCompleted"        
        trigger="#pick-avatar"
        output-mime="jpg"
        :labels="{'cancel' : 'cancel', 'submit' : 'Ok'}"
        upload-url="/file/upload" />
  </div>
</template>

<script>
import AvatarCropper from "vue-avatar-cropper";

export default {
  components: { AvatarCropper },
  // props:['avatarImage'], 
  data() {
    return {
      message: "ready" ,
      avatarImage:'' 
    };
  },
  methods: {
    handleUploading(form, xhr) {
      this.message = "uploading...";
    },
    handleUploaded(response) {
      if (response.status == "success") {
        //this.user.avatar = response.url;
        // Maybe you need call vuex action to
        // update user avatar, for example:
        // this.$dispatch('updateUser', {avatar: response.url})
        this.message = "user avatar updated.";
      }
    },
    handleCompleted(response, form, xhr) {     
      this.s('Profile Picture updated')
      window.location='/profile'
    },
    // handlerError(message, type, xhr) {
    //   this.message = "Oops! Something went wrong...";
    // }
  }, 
  mounted(){
    this.csrf = window.Laravel.csrfToken;          
  },
   async created()
   {    
     const res= await this.callApi('get', '/user/profileData')
     if (res.status === 200) {     
     this.avatarImage = res.data.profile_image
   }
     else{
      this.e('Something went wrong while loading profile photo')
     }
   }
};
</script>

<style>
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
