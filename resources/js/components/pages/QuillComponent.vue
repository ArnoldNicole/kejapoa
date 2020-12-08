<template>
    <div class="card-content collapse show">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div id="full-wrapper">
                  <div id="full-container">
                    <vue-editor v-model="content" />
                  </div>
                  <div v-html="content">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
</template>

<script>
import { VueEditor } from "vue2-editor";
export default {
    data(){
        return{
            content: '',
            loading: false
        }
    },
}
</script>