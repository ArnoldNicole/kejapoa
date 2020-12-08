<template>
  <div>
    <Row justify="center">
      <Col  span="18">
      <Form>
      <Input v-model="data.caption" placeholder="Add caption" />
      <Upload
            ref="uploads"
            type="drag"
            :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
            :on-success="handleSuccess"
            :on-error="handleError"
            :format="['jpg','jpeg','png']"
            :max-size="2048"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            action="/app/upload">
          
            <div style="padding: 20px 0">
              <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
              <p>Click or drag files here to upload</p>
            </div>
          </Upload>
          <div class="demo-upload-list" v-if="data.iconImage">
             <img class="img-thumbnail w-50" :src="`${data.iconImage}`" />
            <div class="demo-upload-list-cover">
              <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
            </div>
          </div>
          <Button
              type="primary"
              @click="addImage"
              :disabled="isAdding"
              :loading="isAdding"
            >{{isAdding ? 'Adding..' : 'Add Image'}}</Button>
        </Form>
    </Col>
    </Row>
    <div class="space"></div>
    <Row>
      <Col span="24">
      <stack :column-min-width="320" :gutter-width="2" :gutter-height="2">
            <stack-item v-for="(houseImage, i) in houseImages" :key="i" v-if="houseImages.length" monitor-images-loaded>
              <img :src="houseImage.image" class="img-thumbnail w-100" />
            </stack-item>
          </stack>
    </Col>
    </Row>
  </div>
</template>

<script>
import { Stack, StackItem } from 'vue-stack-grid';
export default {
   components: { Stack, StackItem } ,
   props:['monitor-images-loaded'], 
  data() {
    return {
      data: {
        iconImage: "",
        caption: "",
        id:this.$route.params.id
      },
      message: "ready" ,
      avatarImage:'' ,
      imageId:this.$route.params.id,
      houseImages:[],
      token: "",
       isAdding: false,
    };
  },
  methods:{
    handleSuccess(res, file) {
         res = `/uploads/${res}`;
         this.data.iconImage = res;
       },

       handleError(res, file) {
         this.$Notice.warning({
           title: "The file format is incorrect",
           desc: `${
             file.errors.file.length
               ? file.errors.file[0]
               : "Something went wrong!"
           }`
         });
       },

       async addImage() {
            if (this.data.caption.trim() == "")
              return this.e("caption is required");
            if (this.data.iconImage.trim() == "")
            return this.e("Image is is required");
            this.data.iconImage = `${this.data.iconImage}`;
            const res = await this.callApi("post", "/landlord/image/upload", this.data);
            if (res.status === 201) {              
              this.houseImages.unshift(res.data);
              this.s("Image has been added successfully!");              
              this.data.caption = "";
              this.data.iconImage = "";
              this.$refs.uploads.clearFiles();
            } else {
              if (res.status == 422) {
                if (res.data.errors.caption) {
                  this.e(res.data.errors.caption[0]);
                }
                if (res.data.errors.iconImage) {
                  this.e(res.data.errors.iconImage[0]);
                }
              } else {
                if (res.status == 200) {
                    this.e(res.data)
                    this.data.caption = "";
                    this.data.iconImage = "";
                    this.$refs.uploads.clearFiles();
                }else{
                  this.swr()
                }
              }
            }
          },

       handleFormatError(file) {
         this.$Notice.warning({
           title: "The file format is incorrect",
           desc:
             "File format of " +
             file.name +
             " is incorrect, please select jpg or png."
         });
       },

       handleMaxSize(file) {
         this.$Notice.warning({
           title: "Exceeding file size limit",
           desc: "File  " + file.name + " is too large, no more than 2M."
         });
       },
       async deleteImage(isAdd = true) {              
               this.data.iconImage = "";
               this.$refs.uploads.clearFiles();
             }
  },
   
  mounted(){
    this.s('loaded')
   this.token = window.Laravel.csrfToken;         
  },
   async created()
   {    
     const res= await this.callApi('get', '/landlord/getHouseImageData/' + this.$route.params.id)
     if (res.status === 200) {     
     this.houseImages = res.data
   }
     else{
      this.e('Something went wrong while loading images')
     }
   }
};
</script>


